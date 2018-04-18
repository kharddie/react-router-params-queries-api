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
 
$database = new Database();
$db = $database->getConnection();
 
$users = new Users($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values

$users->name = $data->name;
$users->email = $data->email;
$users->password = $data->password;

/*
$users->name = "mimi";
$users->email = "mimi@hhh.com";
$users->password = "aefnsrthtrbjetyjet";
$users->created = date('Y-m-d H:i:s');
*/


// create the users
if($users->create()){
    echo '{';
        echo '"message": "users was created.","data":{"id":"'.$users->lastInsertId.'","name":"'.$users->name.'","email":"'.$users->email.'"}';
    echo '}';
}



 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create users."';
    echo '}';
}
?>