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
include_once '../objects/comments.php';

$database = new Database();
$db = $database->getConnection();

$comments = new Comments($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values

$comments->content = $data->content;                
$comments->created = $data->created;
$comments->user_id = $data->user_id;
$comments->request_id = $data->request_id;
$comments->modified = $data->created;

// request the comments
if($comments->create()){

	echo '{';
	echo '  "message": "success","error": null,"data": {"id": ' .$comments->lastInsertId .' } ';
	echo '}';

} 

else {
	echo '{';
	echo '"message": "failed.", "error": "error","data":null';
	echo '}';
}


?>