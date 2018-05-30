<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/requests.php';
include_once '../objects/encodeDecodeJWT.php';
 
$database = new Database();
$db = $database->getConnection();
 
$requests = new Requests($db);
$tokenString = '';
$encodeJWT = new encodeDecodeJWT($db,$tokenString);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product id to be deleted
$requests->request_id = $data->request_id;


 
// delete the product
if($requests->delete()){
    echo '{';
        echo '"message": "Request was successfully deleted.","data":'. $requests->request_id;
    echo '}';
}
 
// if unable to delete the product
else{
    echo  '{' ;
    echo ' "data": [], "message" :"Error deleting request.", "error" :"error" '; 
    echo  '}' ;
}
?>