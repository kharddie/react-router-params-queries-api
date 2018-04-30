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


// create request
    function create(){

    // query to insert record
        $query = "INSERT INTO
        " . $this->table_name . "
        SET
        user_id=:user_id,
        request_id=:request_id,
        message_id=:message_id,
        content=:content,
        created=:created,
        modified=:modified";

    // prepare query
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->request_id=htmlspecialchars(strip_tags($this->request_id));
        $this->message_id=htmlspecialchars(strip_tags($this->message_id));
        $this->content=htmlspecialchars(strip_tags($this->content));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->modified=htmlspecialchars(strip_tags($this->modified));

    // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":request_id", $this->request_id);
        $stmt->bindParam(":message_id", $this->message_id);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":modified", $this->modified); 

       // echo $query;

    // execute query
        try{
            if($stmt->execute()){

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
    o.content, 
    o.user_id, 
    o.id as offer_id
    FROM 
    " . $this->table_name . " o
    LEFT JOIN requests r ON r.id = o.request_id
    LEFT JOIN users u ON o.user_id = u.id 
    ORDER BY
    o.created";

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