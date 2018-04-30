<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//Request header field Authorization is not allowed by Access-Control-Allow-Headers in preflight response
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/offers.php';
include_once '../objects/encodeDecodeJWT.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$offers = new Offers($db);
$decodeJWT = new encodeDecodeJWT($db);

//validate token
$decodeJWT->Decode();

//echo $decodeJWT->Decode();

if($decodeJWT->Decode()->data == "Passed"){

    // query offers
    $stmt = $offers->read();
    $num = $stmt->rowCount();

// check if more than 0 record found
    if($num>0){

    // offers array
        $offers_arr=array();
        $offers_arr["data"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
            extract($row);

            $offers_item=array(
                "request_id" => $request_id,
                "name" => $name,
                "user_name" => $user_name,
                "created" => $created,
                "user_id" => $user_id,
                "content" => html_entity_decode($content),
                "created" => $created
            );

            array_push($offers_arr["data"], $offers_item);
        }

        echo json_encode($offers_arr);
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