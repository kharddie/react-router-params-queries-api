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
$decodeJWT = new encodeDecodeJWT($db);

//validate token
$decodeJWT->Decode();

//echo $decodeJWT->Decode();

if($decodeJWT->Decode()->data == "Passed"){

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
                "title" => $title,
                "address" => $address,
                "status" => $status,
                "modified" => $modified,
                "content" => html_entity_decode($content),
                "due_date" => $due_date,

                "created" => $created
            );

            array_push($requests_arr["data"], $requests_item);
        }

        echo json_encode($requests_arr);
    }

    else{
        echo json_encode(
            array("message" => "No requests found.")
        );
    }

}else{
    echo json_encode(
        array("message" => "Token failed.")
    );

}

?>