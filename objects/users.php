<?php
class Users{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $name;
    public $email;
    public $password;
    public $created;
    public $lastInsertId;
    public $userdata;

    public function __construct($db){
        $this->conn = $db;
    }



    // used by select drop-down list
    public function login(){
        //select all data


        $query = "SELECT
        id, name, email
        FROM
        " . $this->table_name . "
        WHERE
        name=:username and password=:password";


       // SELECT id, name, email FROM `users` WHERE name="xx" and password="xx"


        $stmt = $this->conn->prepare( $query );

        $this->password = hash('sha256',$this->password);  ///wewe

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);

        //print_r($param_new);


        try {
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }



    // forgot password
    public function ForgotPwd(){
        //select all data


        $query = "SELECT
        id, name, email
        FROM
        " . $this->table_name . "
        WHERE
        email=:email";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":email", $this->email);

        //print_r($param_new);


        try {
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }



    // create product
    function create(){

        // query to insert record
        $query = "INSERT INTO
        " . $this->table_name . "
        SET
        name=:name,  
        email=:email, 
        password=:password,
        created=:created
        ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->password = hash('sha256',$this->password); 
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);

        try{
            if($stmt->execute()){

                $this->lastInsertId = $this->conn->lastInsertId();
                return true;
            }

            return false;
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

         //;   
    }

}
?>