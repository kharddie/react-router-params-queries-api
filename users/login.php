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
  include_once '../objects/encodeDecodeJWT.php';




  // instantiate database and product object
  $database = new Database();
  $db = $database->getConnection();

  // initialize object
  $users = new Users($db);
  $encodeJWT = new encodeDecodeJWT($db);
  // get posted data
  $data = json_decode(file_get_contents("php://input"));

  // set usres property values

  $users->username = $data->username;
  $users->password = $data->password;

  // query users
  try{
    $stmt = $users->login();
    $num = $stmt->rowCount();

    $users->userdata = $stmt->fetch(PDO::FETCH_OBJ);

    if($users->userdata){
     $userId = $users->userdata->id;
     $users->userdata = json_encode($users->userdata);

     //create token
     $encodeJWT->userId = $userId;
     $token = $encodeJWT->Encode();

     echo '{';
     echo '"message": "success","error": null,"data": {"user": ' .$users->userdata .' }, "token": "' . $token . '"';
     echo '}';

   } else {
     echo '{';
     echo '"message": "Unable to log in.", "error": "error","data":null';
     echo '}';
   }


 }
 catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}



?>

