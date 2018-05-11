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
  $tokenString = '';
  $decodeJWT = new encodeDecodeJWT($db,$tokenString);

    // get token from headers check if its a guest user
  $token = explode(" ", apache_request_headers()["Authorization"]);
  $token =  $token[1]; 

//check for guest user
  if($token === "undefined"){
    //echo "token=". $token;
      //decode token and get user id and the token
    $users->user_id_from_token = 0;
  }else{
       //decode token and get user id and the token
    $users->user_id_from_token = $decodeJWT->Decode()->user_id_from_token;
    $token = $decodeJWT->Decode()->token;   
  }




  // query users
  try{
    $stmt = $users->MeFromToken();
    $num = $stmt->rowCount();

    $users->userdata = $stmt->fetch(PDO::FETCH_OBJ);

    if($users->userdata){
     $userId = $users->userdata->id;
     $users->userdata = json_encode($users->userdata);

     echo '{';
     echo '"message": "success","error": null,"data": {"user": ' .$users->userdata .' }, "token": "' . $token . '"';
     echo '}';

   } else {
     echo '{';
     echo '"message": "You are either a guest user or you need to log in.", "error": "error","data":null';
     echo '}';
   }


 }
 catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}



?>

