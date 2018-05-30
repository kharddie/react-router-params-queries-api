<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//Request header field Authorization is not allowed by Access-Control-Allow-Headers in preflight response
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/requests.php';
include_once '../objects/encodeDecodeJWT.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$requests = new Requests($db);
$tokenString = '';
$encodeJWT = new encodeDecodeJWT($db,$tokenString);

if (isset($_GET['uid'])) {
    $requests->requests_uid = $_GET['uid'];

} else {
    $requests->requests_uid = '';
}

//validate token
//$decodeJWT->Decode();

//echo $decodeJWT->Decode();

//if($decodeJWT->Decode()->data == "Passed"){

    // query requests
$stmt = $requests->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // requests array
    $requests_arr=array();
    $requests_arr["data"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $requests_item=array(
            "id" => $id,
            "name" => $name,
            "user_id" => $user_id,
            "title" => $title,
            "address" => $address,

            "lat" => $lat,
            "lng" => $lng,

            "status" => $status,
            "modified" => $modified,
            "content" => nl2br(htmlspecialchars($content)),
            "due_date" => $due_date,

            "created" => $created
        );

        array_push($requests_arr["data"], $requests_item);
    }

        $requests_arr["message"] = "success";
        $requests_arr["error"] = null;
        echo json_encode($requests_arr);
}

else{
    echo  '{' ;
    echo ' "data": [], "message" :"You currently have no requets to display.", "error" :"error" '; 
    echo  '}' ;
}
/*
}else{
    echo json_encode(
        array("message" => "Token failed.")
    );

}
*/

?>