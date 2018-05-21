<?php
class Requests{

    // database connection and table name
    private $conn;
    private $table_name = "requests";
    private $holdeQuery;

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    public $lastInsertId;
    public $query;

    public $address;
    public $content;
    public $due_date;
    public $title;
    public $status;
    public $requests_uid;

    public $lat;
    public $lng;


// read request
    function read(){

    // select all query
        if($this->requests_uid != ''){
            $where = "WHERE u.id = ".$this->requests_uid;
        } else {
            $where = '';
        }

        $query = "SELECT 
        u.name,
        u.id as user_id, 
        r.title, 
        r.id, 
        r.address, 
        r.due_date, 
        r.content, 
        r.status, 

        r.lat, 
        r.lng, 

        r.created, 
        r.modified 
        FROM 
        " . $this->table_name . " r 
        LEFT JOIN 
        users u 
        ON 
        r.user_id = u.id
        " .$where. "
        ORDER BY
        r.created DESC";

    // prepare query statement
        $stmt = $this->conn->prepare($query);

    // execute query
        $stmt->execute();

        return $stmt;
    }

// create request
    function create(){

    // query to insert record
        $query = "INSERT INTO
        " . $this->table_name . "
        SET
        user_id=:id,
        address=:address,
        content=:content,
        due_date=:due_date,
        status=:status,
        title=:title,
        lat=:lat,
        lng=:lng,
        created=:created";

    // prepare query
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->address=htmlspecialchars(strip_tags($this->address));

        $this->content=htmlspecialchars(strip_tags($this->content));
       // $this->content=nl2br(htmlentities($this->content, ENT_QUOTES, 'UTF-8'));
        
        $this->lat=htmlspecialchars(strip_tags($this->lat));
        $this->lng=htmlspecialchars(strip_tags($this->lng));


        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->due_date=htmlspecialchars(strip_tags($this->due_date));
        $this->created=htmlspecialchars(strip_tags($this->created));

    // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":content", $this->content);

        $stmt->bindParam(":lat", $this->lat);
        $stmt->bindParam(":lng", $this->lng);

        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->created);

    // execute query
        if($this->id !='' && $this->address !='' && $this->content !='' && $this->due_date !=''){
            if($stmt->execute()){
                $this->lastInsertId = $this->conn->lastInsertId();
                return true;
            }else{

                return false;
            }
        }

    }

// used when filling up the update product form
    function readOne(){

    // query to read single record
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