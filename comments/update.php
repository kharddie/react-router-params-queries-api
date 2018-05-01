<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
 
// set ID property of product to be edited
$product->id = $data->id;
 
// set product property values
$product->name = $data->name;
$product->category_id = $data->category_id;

if($product->update()){
    echo '{';
        echo '"message": "Product was updated.","data":{"id":"'.$product->id.'","name":"'.$product->name.'","category_id":"'.$product->category_id.'"}';
    echo '}';
}

 
// if unable to update the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to update product.","error": "true"';
    echo '}';
}
?>