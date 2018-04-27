<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate offers object
include_once '../objects/offers.php';

$database = new Database();
$db = $database->getConnection();

$offers = new Offers($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
/*
$offers->user_id = 1;
$offers->request_id= 2;
$offers->message_id = 3;
$offers->content = "swdbWRBQERB";
$offers->created = "win5";
*/

$offers->user_id = $data->user_id;
$offers->request_id= $data->request_id;
$offers->message_id = '';
$offers->content = $data->content;
$offers->created = $data->created;

$offers->modified = date('Y-m-d H:i:s');;

// query the offers
if($offers->create()){
     echo '{';
     echo '  "message": "success","error": null,"data": {"id": ' .$offers->lastInsertId .' } ';
     echo '}';

   } 

   else {
     echo '{';
     echo '"message": "failed.", "error": "error","data":null';
     echo '}';
   }
?>


