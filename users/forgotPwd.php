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



// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$users = new Users($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values

//$users->email = $data->email;
$users->email = "kharddie@gmail.com";


// query products


try{
    $stmt = $users->ForgotPwd();
    $num = $stmt->rowCount();

    $users->userdata = $stmt->fetch(PDO::FETCH_OBJ);

    if($users->userdata){
       $userId = $users->userdata->id;
       $email = $users->userdata->email;
       $users->userdata = json_encode($users->userdata);

       //email pwd
echo $users->userdata;

$msg = "Hi, arden\nClick the link below to reset your your password\nKind regards,\nAdmin";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
//mail($email,"Reset password",$msg);



   } else {
       echo '{"error":{"Wrong username and password"}}';
   }

}
catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>