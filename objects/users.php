<?php
class Users{

    // database connection and table name
    private $conn;
    private $table_name = "users";
    private $queryUser="id,name,user_name, email,contact_number,address";
    // object properties
    public $id;
    public $name;
    public $email;
    public $password;
    public $confirmPassword;
    public $created;
    public $lastInsertId;
    public $userdata;
    public $user_name;
    public $user_id_from_token;
    public $address;
    public $contact_number;
    public $token;
    public $userId;

    public function __construct($db){
        $this->conn = $db;
    }

// read products
    function MeFromToken(){

        $query = "SELECT
        ".$this->queryUser."
        
        FROM
        " . $this->table_name . "
        WHERE
        id=:id";

       // SELECT id, name, email FROM `users` WHERE name="xx" and password="xx"

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":id", $this->user_id_from_token);

        try {
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
    }

    public function login(){
        //select all data

        $query = "SELECT
        ".$this->queryUser."
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
        user_name=:user_name,
        email=:email, 
        password=:password,
        created=:created
        ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->password = hash('sha256',$this->password); 
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":user_name", $this->user_name);
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

    // update the product
    function UpdateProfile(){

    // update query
        $query = "UPDATE
        " . $this->table_name . "
        SET
        name = :name,
        user_name = :user_name,
        email = :email,
        address = :address,
        contact_number = :contact_number
        WHERE
        id = :id";

    // prepare query statement
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));

    // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':contact_number', $this->contact_number);

        //echo $query;

    // execute the query
        if($stmt->execute()){         
            return true;
        }
        return false;
    }



     // for forgot password
    function UpdateUsertableToken(){

    // update query
        $query = "UPDATE
        " . $this->table_name . "
        SET
        token = :token
        WHERE
        id = :userId";

    // prepare query statement
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->token=htmlspecialchars(strip_tags($this->token));
        $this->userId=htmlspecialchars(strip_tags($this->userId));


    // bind new values
        $stmt->bindParam(':token', $this->token);
        $stmt->bindParam(':userId', $this->userId);

        //echo $query;

    // execute the query
        if($stmt->execute()){ 
        //echo "Updated Usertable with token Token==".$this->userId;        
            return true;
        }
        echo '{';
        echo '  "message": "Could not update user table","error": null,"data": null';
        echo '}';

        exit();
    }


    function ResetPwd(){

    // update query
        $query = "UPDATE
        " . $this->table_name . "
        SET
        password = :password
        WHERE
        id = :userId";

    // prepare query statement
        $stmt = $this->conn->prepare($query);

    // sanitize
        $this->token=htmlspecialchars(strip_tags($this->token));
        $this->userId=htmlspecialchars(strip_tags($this->userId));


    // bind new values
        $stmt->bindParam(':token', $this->token);
        $stmt->bindParam(':userId', $this->userId);

        //echo $query;

    // execute the query
        if($stmt->execute()){         
            return true;
        }
        echo '{';
        echo '  "message": "Could not update user table","error": null,"data": null';
        echo '}';

        exit();
    }


    // update th password
    function UpdateProfilePwd(){

    // update query
        $query = "UPDATE
        `users`
        SET
        password = :password
        WHERE
        id = :userId";

    // prepare query statement
        $stmt = $this->conn->prepare($query);

        //echo "password to be hashed=".$this->confirmPassword;

        $this->confirmPassword = hash('sha256',$this->confirmPassword); 

    // sanitize
        $this->userId=htmlspecialchars(strip_tags($this->userId));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));

    // bind new values
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':password', $this->confirmPassword);


        //echo $query;

    // execute the query
        if($stmt->execute()){         
            return true;
        }
        echo '{';
        echo '  "message": "Could not update user table -- password","error": null,"data": null';
        echo '}';

        exit();
    }










}
?>