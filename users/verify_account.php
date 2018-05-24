<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate users object
include_once '../objects/users.php';
include_once '../objects/encodeDecodeJWT.php';

$database = new Database();
$db = $database->getConnection();
$users = new Users($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
//$tokenString = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMTE1In0.taQ_6EoTYgMM3V2ghAbri9ivfGMetn2RQ_BEmhjOk98";

$tokenString = $data->token;
$users->verified =1;


//echo "token string from website string=".$tokenString;

// initialize object
$decodeJWT = new encodeDecodeJWT($db,$tokenString);

//validate token
$decodeJWT->Decode();
$users->userId = $decodeJWT->Decode()->user_id_from_token;
//echo $users->userId;
if($decodeJWT->Decode()->data == "Passed"){
// create the users
  if($users->UpdateProfileVerify()){
    echo '{';
    echo '"message": "Your Account has been verified.","error": null,"data":{}';
    echo '}';
  }

// if unable to create the product, tell the user
  else{

    echo '{';
    echo '"message": "failed.", "error": "error","data":null';
    echo '}';
  }

}else{
  echo json_encode(
    array("message" => "Token failed.")
  );

}
?>