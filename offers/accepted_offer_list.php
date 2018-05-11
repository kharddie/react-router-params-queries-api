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
//$decodeJWT->Decode();

if (isset($_GET['rid'])) {
    $offers->request_id = $_GET['rid'];

} else {
    $offers->request_id = 0;
}

//echo $decodeJWT->Decode();

//no need for jwt
//if($decodeJWT->Decode()->data == "Passed"){

    // query comments
    $stmt = $offers->ReadAcceptedOffersList();
    $num = $stmt->rowCount();



// check if more than 0 record found
    if($num>0){

    // offers array
        $acceptedOffersList_arr=array();
        $acceptedOffersList_arr["data"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
            extract($row);

            $acceptedOffersList_arr_item=array(
                "id" => $id,
                "user_id," => $user_id,
                "offer_id" => $offer_id,
                "request_id" => $request_id,
                "created" => $created,
            );

            array_push($acceptedOffersList_arr["data"], $acceptedOffersList_arr_item);
        }

        $acceptedOffersList_arr_item["message"] = "success";
        echo json_encode($acceptedOffersList_arr);
    }

    else{

        echo  '{' ;
        echo ' "data": [], "message" :"No comments found." '; 
        echo  '}' ;


    }

/*
}else{

    echo  '{' ;
    echo ' "data": [], "message" :"Token failed." '; 
    echo  '}' ;

}
*/

?>