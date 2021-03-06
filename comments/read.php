<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//Request header field Authorization is not allowed by Access-Control-Allow-Headers in preflight response
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/comments.php';
include_once '../objects/encodeDecodeJWT.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$comments = new Comments($db);
$tokenString = '';
$encodeJWT = new encodeDecodeJWT($db,$tokenString);

//validate token
//$decodeJWT->Decode();

if (isset($_GET['rid'])) {
    $comments->request_id = $_GET['rid'];

} else {
    $comments->request_id = 0;
}

//echo $decodeJWT->Decode();

//no need for jwt
//if($decodeJWT->Decode()->data == "Passed"){

    // query comments
    $stmt = $comments->read();
    $num = $stmt->rowCount();

// check if more than 0 record found
    if($num>0){

    // comments array
        $comments_arr=array();
        $comments_arr["data"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
            extract($row);

            $comments_item=array(
                "id" => $id,
                "name" => $name,
                "user_name" => $user_name,
                "created" => $created,
                "content" => nl2br(htmlspecialchars($content)),
                "request_id" => $request_id,
            );

            array_push($comments_arr["data"], $comments_item);
        }

        $comments_arr["message"] = "success";
        echo json_encode($comments_arr);
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