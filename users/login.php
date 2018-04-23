  <?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  // include database and object files
  include_once '../config/database.php';
  include_once '../objects/users.php';



  // instantiate database and product object
  $database = new Database();
  $db = $database->getConnection();

  // initialize object
  $users = new Users($db);

  // get posted data
  $data = json_decode(file_get_contents("php://input"));

  // set product property values

  $users->username = $data->username;
  //$users->email = $data->email;
  $users->password = $data->password;

  // query products


  try{
    $stmt = $users->login();
    $num = $stmt->rowCount();

    $users->userdata = $stmt->fetch(PDO::FETCH_OBJ);

    if($users->userdata){
     $userId = $users->userdata->id;
     $users->userdata = json_encode($users->userdata);




  // Create token header as a JSON string
     $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

  // Create token payload as a JSON string
     $payload = json_encode(['user_id' => $userId]);

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

         //echo $jwt;

     echo '{"user": ' .$users->userdata .',"token": "' .$jwt. '"}';




   } else {
     echo '{"error":{"text":"Bad request wrong username and password"}}';
   }

 }
 catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>