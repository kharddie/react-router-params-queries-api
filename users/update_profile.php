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
$user->name = $data->name;
$user->user_name = $data->user_name;
$user->email = $data->email; 
$user->address = $data->address;
$user->contact_number = $data->contact_number; 
$token = "";



if($user->UpdateProfile()){

     echo '{';
     echo '"message": "Profile was updated","error": null,"data": {"user": {"id":"'.$user->id.'","name":"'.$user->name.'","user_name":"'.$user->user_name.' ","address":"'.$user->address.'",
        "email":"'.$user->email.' ", "contact_number":"'.$user->contact_number.' "}}, "token": "' . $token . '"';
     echo '}';



   } else {
     echo '{';
     echo '"message": "Unable to update user.", "error": "error","data":null';
     echo '}';
   }


?>