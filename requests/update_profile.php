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
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare users object
$user = new users($db);
 
// get id of profile to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of profile to be edited
$user->id = $data->id;
 
// set profile property values
$user->name = $data->name;
$user->user_name = $data->user_name;
$user->email = $data->email;



if($user->UpdateProfile()){
    echo '{';
        echo '"message": "user was updated.","data":{"id":"'.$user->id.'","name":"'.$user->name.'","user_name":"'.$user->user_name.'",
        "email":"'.$user->email.'"}';
    echo '}';
}

 
// if unable to update the user, tell the user
else{
    echo '{';
        echo '"message": "Unable to update user.","error": "true"';
    echo '}';
}
?>