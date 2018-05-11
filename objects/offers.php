<?php
class Offers{

    // database connection and table name
    private $conn;
    private $table_name = "offers";
    private $holdeQuery;
    // object properties
    public $id;
    public $user_id;
    public $offers_id;
    public $message_id;  
    public $created;
    public $lastInsertId;
    public $query;
    public $content;
    public $due_date;
    public $modified;
    public $status;
    public $request_id;
    public $contact_number;
    public $offer_id;
    public $request_user_Id;
    public $request_user_Email;
    public $user_name;

    function accept(){

//get the email user who issued the offer and there email address



        $query = "
        SELECT 
        email 
        FROM 
        `users` 
        WHERE 
        $this->user_id = id";

    // prepare query statement
        $stmt = $this->conn->prepare($query);

    // execute query
        $stmt->execute();

     // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
        $this->request_user_Email = $row['email'];


//create the accepted offer

        $query = "INSERT INTO
        `accepted_offers`
        SET
        user_id=:user_id,
        offer_id=:offer_id,
        request_id=:request_id,
        created=:created,
        modified=:modified";

    // prepare query
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->offer_id=htmlspecialchars(strip_tags($this->offer_id));
        $this->request_id=htmlspecialchars(strip_tags($this->request_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->modified=htmlspecialchars(strip_tags($this->modified));

    // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":offer_id", $this->offer_id);
        $stmt->bindParam(":request_id", $this->request_id);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":modified", $this->modified); 

       // echo $query;

    // execute query

        if($this->user_id !='' && $this->offer_id !='' && $this->request_id !='' && $this->created !=''){

            if($stmt->execute()){

         //alter the status of the request
             $status="Assigned";

             $query = "UPDATE
             `requests`
             SET
             status = :status

             WHERE
             user_id = :user_id";

             $stmt2 = $this->conn->prepare($query);

             $status=htmlspecialchars($status);
             $this->user_id=htmlspecialchars(strip_tags($this->user_id));

             $stmt2->bindParam(':status', $status);
             $stmt2->bindParam(':user_id', $this->user_id);

             if($stmt2->execute()){
                // return true;
             }else{
                 echo '{';
                 echo '  "message": "Could not alter the status of the request table","error": null,"data": null';
                 echo '}';

                 exit();
            // return false;
             }

             $this->lastInsertId = $this->conn->lastInsertId();
             return true;
         }else{
            return false;
        }
    }

}















function create(){

    $query1 = "
    SELECT 
    user_id 
    FROM 
    `offers` 
    WHERE 
    request_id = ". $this->request_id."
    AND
    user_id = ". $this->user_id
    ;

    // prepare query statement
    $stmt = $this->conn->prepare($query1);

    // execute query
    $stmt->execute();
    $num = $stmt->rowCount();

    // check if more than 0 record found
    if($num > 0) {

       echo '{';
       echo '  "message": "You have already offered to help out with this request","error": null,"data": null';
       echo '}';

       exit();
   }

   $query = "INSERT INTO
   " . $this->table_name . "
   SET
   user_id=:user_id,
   request_id=:request_id,
   created=:created,
   modified=:modified";

    // prepare query
   $stmt = $this->conn->prepare($query);

    // sanitize
   $this->user_id=htmlspecialchars(strip_tags($this->user_id));
   $this->request_id=htmlspecialchars(strip_tags($this->request_id));
   $this->created=htmlspecialchars(strip_tags($this->created));
   $this->modified=htmlspecialchars(strip_tags($this->modified));

    // bind values
   $stmt->bindParam(":user_id", $this->user_id);
   $stmt->bindParam(":request_id", $this->request_id);
   $stmt->bindParam(":created", $this->created);
   $stmt->bindParam(":modified", $this->modified); 

       // echo $query;

    // execute query
   try{

    if($stmt->execute() && $this->user_id != '' && $this->request_id != '' && $this->created != '' ){

            //update users set phone number

        $query = "UPDATE
        `users`
        SET
        `contact_number` = :contact_number
        WHERE
        id = :user_id";


    // prepare query statement
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

    // bind new values
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':user_id', $this->user_id);

    // execute the query
        if(!$stmt->execute()){
           echo '{';
           echo '"message": '.$this->user_id.' "Failed to update users table.", "error": "error","data":null';
           echo '}';
           exit();
       }

       $this->lastInsertId = $this->conn->lastInsertId();
       return true;
   }else{
    return false;
}

} catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}
}


// read request
function read(){

    // select all query
    $query = "SELECT 
    r.id as request_id,
    u.name as name,
    u.user_name as user_name,
    o.created, 
    o.user_id, 
    o.id as offer_id,
    x.user_id as whos_accepted_this
    FROM 
    " . $this->table_name . " o
    LEFT JOIN requests r ON r.id = o.request_id
    LEFT JOIN users u ON o.user_id = u.id
    LEFT JOIN accepted_offers x ON o.id = x.offer_id 
    WHERE o.request_id = ".$this->request_id."
    ORDER BY
    o.created";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}


function ReadAcceptedOffersList(){

    // select all query
    $query = "SELECT 
    id,
    user_id,
    offer_id,
    request_id,
    created 

    FROM 
    `accepted_offers`

    ORDER BY
    created";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}








// used when filling up the update product form
function readOne(){

    // query to read single z
    $query = "SELECT
    c.name as category_name, p.id, p.name, p.description, p.category_id, p.created
    FROM
    " . $this->table_name . " p
    LEFT JOIN
    categories c
    ON p.category_id = c.id
    WHERE
    p.id = ?
    LIMIT
    0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->name = $row['name'];
    $this->description = $row['description'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
}



// update the product
function update(){

    // update query
    $query = "UPDATE
    " . $this->table_name . "
    SET
    name = :name

    WHERE
    id = :id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));


    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
       // = 'table='. $this->table_name. '--id='. $this->id. '--name='. $this->name;
        // return $this->query;
        return true;
    }

    return false;
}

// delete the product
function delete(){

    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind id of record to delete
    $stmt->bindValue(1, $this->id, PDO::PARAM_INT);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}
// search products
function search($keywords){

    // select all query
    $query = "SELECT
    c.name as category_name, p.id, p.name, p.description, p.category_id, p.created
    FROM
    " . $this->table_name . " p
    LEFT JOIN
    categories c
    ON p.category_id = c.id
    WHERE
    p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
    ORDER BY
    p.created DESC";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);

    // execute query
    $stmt->execute();

    return $stmt;
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){

    // select query
    $query = "SELECT
    c.name as category_name, p.id, p.name, p.description, p.category_id, p.created
    FROM
    " . $this->table_name . " p
    LEFT JOIN
    categories c
    ON p.category_id = c.id
    ORDER BY p.created DESC
    LIMIT ?, ?";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

    // execute query
    $stmt->execute();

    // return values from database
    return $stmt;
}

// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['total_rows'];
}


    // constructor with $db as database connection
public function __construct($db){
    $this->conn = $db;
}
}