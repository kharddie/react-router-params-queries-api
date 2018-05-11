<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

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
$encodeJWT = new encodeDecodeJWT($db,$tokenString);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values

//$users->email = $data->email;
$users->email = $data->email;


// query products


try{
  $stmt = $users->ForgotPwd();
  $num = $stmt->rowCount();

  $users->userdata = $stmt->fetch(PDO::FETCH_OBJ);

  if($users->userdata){
   $userId = $users->userdata->id;
   $email = $users->userdata->email;
   $name = $users->userdata->name;
   $users->userdata = json_encode($users->userdata);

       //email pwd
   //echo $users->userdata;

     //create token
   $encodeJWT->userId = $userId;
   //echo "userId=".$userId;
   $users->token = $encodeJWT->Encode();
   //echo "token=".$users->token;
//update user table
   $users->userId = $userId;
   if($users->UpdateUsertableToken()){
    echo '{';
    echo '"message": "Email has been sent to your email address.","data":{"token":"'.$users->token.'","email":"'.$email .'","name":"'.$name .'"}';
    echo '}';

    //email to user
  }





} else {
 echo '{';
 echo '  "message": "Email provided does not exist. Please enter the email you registered with.","error": null,"data": null';
 echo '}';
}

}
catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>