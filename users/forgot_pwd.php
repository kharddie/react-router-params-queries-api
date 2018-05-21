<?php
// required headers

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

// include database and object files
include_once '../config/database.php';
include_once '../objects/users.php';
include_once '../objects/encodeDecodeJWT.php';
include_once '../objects/emailer.php';



// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$users = new Users($db);
$tokenString = '';
$encodeJWT = new encodeDecodeJWT($db,$tokenString);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values

//$users->email = $data->email;
$users->email = $data->email;

// query products


  $stmt = $users->ForgotPwd();
  $num = $stmt->rowCount();

  $users->userdata = $stmt->fetch(PDO::FETCH_OBJ);

  if($users->userdata){

       $userId = $users->userdata->id;
       $email = $users->userdata->email;
       $name = $users->userdata->name;
       $users->userdata = json_encode($users->userdata);

           //email pwd
       //echo $users->userdata;

         //create token
       $encodeJWT->userId = $userId;
       //echo "userId=".$userId;
       $users->token = $encodeJWT->Encode();
       //echo "token encoded=".$users->token;
    //update user table
       $users->userId = $userId;
       if($users->UpdateUsertableToken()){

            //email to user
            $sendEmail = new Emailer();

            $sendEmail->to = $email;
            $sendEmail->subject = 'Email from saidia.com.au';
            $sendEmail->from = 'saidia@eastweb.com.au';
            $sendEmail->link ='http://saidia.eastweb.com.au/#/resetPwd??token='.$users->token;
            $sendEmail->message = '<html><body tyle="background-color:#f8f9fa;">';
            $sendEmail->message .= '<table style="width:100%">';
            $sendEmail->message .= '  <tr>';
            $sendEmail->message .= '   <th style="background-color:#ffffff;"><h1>saidia.com.au</h1></th>';
            $sendEmail->message .= ' </tr>';
            $sendEmail->message .= ' <tr>';
            $sendEmail->message .= '   <td>';
            $sendEmail->message .= '<p style="color:#839094;font-size:14px;">Hi, '.$name.'<br/>Click the link below to reset your your password\n</p>
            <p style="color:#839094;font-size:14px;">'.$sendEmail->link.'
            </p><p style="color:#839094;font-size:14px;">Kind regards,<br/>Admin</p>
            ';
            $sendEmail->message .= '  </td>';
            $sendEmail->message .= '  </tr>';
            $sendEmail->message .= ' <tr>';
            $sendEmail->message .= '   <td style="background-color:#26272b;width:50px">Copyright © eastweb 2018</td>';
            $sendEmail->message .= '  </tr>';
            $sendEmail->message .= '</table>'; 
            $sendEmail->message .= '</body></html>';

             if($sendEmail->sendEmail()){
                echo '{';
                echo '"message": "Further instructions have been sent to your e-mail address.","data":{"token":"'.$users->token.'","email":"'.$email .'","name":"'.$name.'"}';
                echo '}';
             }else{
               echo '{';
               echo '  "message": "Failed to send email.","error": null,"data": null';
               echo '}';
             }

      } else {
         echo '{';
         echo '  "message": "Failed to update user table.","error": null,"data": null';
         echo '}';
        }

} else {
 echo '{';
 echo '  "message": "Email provided does not exist. Please enter the email you registered with.","error": null,"data": null';
 echo '}';
 exit();
}



?>