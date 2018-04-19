<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate requests object
include_once '../objects/requests.php';
 
$database = new Database();
$db = $database->getConnection();
 
$requests = new Requests($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$requests->id = $data->id;
$requests->address = $data->address;
$requests->title = $data->title;
$requests->content = $data->content;
$requests->due_date = date('Y-m-d H:i:s');
$requests->created = date('Y-m-d H:i:s');




/*
$requests->id = "xxxxxx";
$requests->address = "xxxxxx";
$requests->title = "xxxxxx";
$requests->content = "xxxxxx";
$requests->date = date('Y-m-d H:i:s');
$requests->created = date('Y-m-d H:i:s');
*/
 
// request the requests
if($requests->create()){
    echo '{';
        echo '"message": "Request was created.","data":{"id":"'.$requests->lastInsertId.'","title":"'.$requests->title.'","address":"'.$requests->address.'","content":"'.$requests->content.'","due_date":"'.$requests->due_date.'"}';
    echo '}';
}



 
// if unable to create the request, tell the user
else{
    echo '{';
        echo '"message": "Unable to create request."';
    echo '}';
}
?>