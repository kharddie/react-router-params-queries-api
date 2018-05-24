<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate users object
include_once '../objects/users.php';
include_once '../objects/encodeDecodeJWT.php';
include_once '../objects/emailer.php';

$database = new Database();
$db = $database->getConnection();

$users = new Users($db);
$tokenString = '';
$encodeJWT = new encodeDecodeJWT($db,$tokenString);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values

$users->name = $data->name;
$users->user_name = $data->username;
$users->email = $data->email;
$users->password = $data->password;





// create the users
if($users->create()){

	         //create token
	$encodeJWT->userId = $users->lastInsertId;
	//echo "$users->lastInsertId=".$users->lastInsertId;
	$users->token = $encodeJWT->Encode();
	//echo "token encoded=". $users->token;
    //update user table
	$users->userId = $users->lastInsertId;


	    //update user table
	$users->userId = $users->lastInsertId;
	if($users->UpdateUsertableToken()){

	            //email to user
		$sendEmail = new Emailer();

		$sendEmail->to = $users->email;
		$sendEmail->subject = 'Email from saidia.com.au';
		$sendEmail->from = 'saidia@eastweb.com.au';
		$sendEmail->link ='http://saidia.eastweb.com.au/#/verifyAccount?token='.$users->token;
		$sendEmail->message = '<html><body tyle="background-color:#f8f9fa;">';
		$sendEmail->message .= '<table style="width:100%";background-color:#f8f9fa;>';
		$sendEmail->message .= '  <tr>';
		$sendEmail->message .= '   <th style="background-color:#9fc104;"><h1>saidia.com.au</h1></th>';
		$sendEmail->message .= ' </tr>';
		$sendEmail->message .= ' <tr>';
		$sendEmail->message .= '   <td>';
		$sendEmail->message .= '<p style="color:#454e48;font-size:14px;">Hi, '.$users->name.'<br/><br/>Click or copy and paste the link below to verify your account</p>
		<p style="color:#454e48;font-size:14px;">'.$sendEmail->link.'
		</p><p style="color:#454e48;font-size:14px;">Kind regards,<br/>Admin</p>
		';
		$sendEmail->message .= '  </td>';
		$sendEmail->message .= '  </tr>';
		$sendEmail->message .= ' <tr>';
        $sendEmail->message .= '   <td style="text-align:center;background-color:#26272b;color: #808288;height:60px">Copyright © eastweb 2018</td>';
		$sendEmail->message .= '  </tr>';
		$sendEmail->message .= '</table>'; 
		$sendEmail->message .= '</body></html>';

		if($sendEmail->sendEmail()){
			echo '{';
			echo '"message": "Please check your email address to verify your account.","error": null,"data":{"id":"'.$users->lastInsertId.'","name":"'.$users->name.'","email":"'.$users->email.'"}';
			echo '}';
		}else{
			echo '{';
			echo '  "message": "Failed to send email.","error": null,"data": null';
			echo '}';
		}

	}else{
		echo '{';
		echo '  "message": "Failed to update user table.","error": null,"data": null';
		echo '}';
	}



}




// if unable to create the product, tell the user
else{

	echo '{';
	echo '"message": "failed.", "error": "error","data":null';
	echo '}';
}
?>