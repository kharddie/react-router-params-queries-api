
<?php
//https://github.com/luciferous/jwt
class EncodeDecodeJWT{

    // database connection and table name
  private $conn;
  private $tokenString;
  private $table_name = "users";
  private $secret ='abC123!';
  private $root;
  private $table_name_users = "users";
  private $user_id_from_token;


    // object properties
  public $encodedJWT;
  public $userId;
  public $token;
  public $userdata;

  public function __construct($db,$tokenString) {

    $this->conn = $db;
    $this->tokenString = $tokenString;
    $this->root = realpath(dirname(dirname(__FILE__)));
    require_once $this->root . '/objects/JWT.php';
  }


  public function Decode(){
      // get token from headers
    $this->token = explode(" ", apache_request_headers()["Authorization"]);
    $this->encodedJWT =  $this->token[1];  
    //print_r ("token from token =" .$this->encodedJWT);
    //print_r ("xxxxxxxxxxxx===".$this->tokenString);


    //decode the token
    if($this->tokenString !=''){
      $res = JWT::decode($this->tokenString, $this->secret);
    }else{

      $res = JWT::decode($this->encodedJWT, $this->secret);
    }



    //pass the user id to $this->user_id_from_token
  $this->user_id_from_token = $res->user_id;
    //print_r ("id from token =" .$this->user_id_from_token);

  $query = "SELECT id, name FROM `". $this->table_name ."` WHERE id = " .  $this->user_id_from_token;
         // prepare query statement
  $stmt = $this->conn->prepare($query);
    // execute query
  $stmt->execute();
  $num = $stmt->rowCount();
  $this->userdata = $stmt->fetch(PDO::FETCH_OBJ);

  $resObj = (object)[];

  if($this->userdata){
   $userId = $this->userdata->id;
   $userName = $this->userdata->name;

     //echo "userId=".$userId. "  userName=".$userName;   
   $resObj->data = "Passed";
   $resObj->user_id_from_token = $this->user_id_from_token;
   $resObj->token = $this->encodedJWT;

   return ($resObj);

 }else{

   $resObj->data = "Failed";
   $resObj->user_id_from_token = $this->user_id_from_token;
   $resObj->token = $this->encodedJWT;

   return $resObj;
 }

}


public function Encode(){

          // Create token header as a JSON string
 $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

  // Create token payload as a JSON string
 $payload = json_encode(['user_id' => $this->userId]);

  // Encode Header to Base64Url String
 $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

  // Encode Payload to Base64Url String
 $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

  // Create Signature Hash
 $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);

  // Encode Signature to Base64Url String
 $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  // Create JWT
 $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

 return $jwt;
}

}
?>

