<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare categories object
$categories = new Categories($db);
 
// get categories id
$data = json_decode(file_get_contents("php://input"));
 
// set categories id to be deleted
$categories->id = $data->id;
 
// delete the categories
if($categories->delete()){
    echo '{';
        echo '"message": "category was deleted.","data":'. $categories->id;
    echo '}';
}
 
// if unable to delete the categories
else{
    echo '{';
        echo '"message": "Unable to delete category."';
    echo '}';
}
?>