<?php
$to = 'kharddie@gmail.com';
$subject = 'Email from saidia.com.au';
$from = 'saidia@eastweb.com.au';
$link ='http://saidia.eastweb.com.au/resetPwd';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from ."\r\n".
    'Reply-To: '.$from ."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '<html><body tyle="background-color:#f8f9fa;">';
$message .= '<table style="width:100%">';
$message .= '  <tr>';
$message .= '   <th style="background-color:#ffffff;"><h1>saidia.com.au</h1></th>';
$message .= ' </tr>';
$message .= ' <tr>';
$message .= '   <td>';
$message .= '<p style="color:#839094;font-size:18px;">Hi, USERMANE\nClick the link below to reset your your password\n</p>
<p style="color:#839094;font-size:18px;">'.$link.'
</p><p style="color:#839094;font-size:18px;">Kind regards,\nAdmin</p>
';
$message .= '  </td>';
$message .= '  </tr>';
$message .= ' <tr>';
$message .= '   <td style="background-color:#26272b;width:50px">Copyright © eastweb 2018</td>';
$message .= '  </tr>';
$message .= '</table>'; 
$message .= '</body></html>';

 
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo 'Your mail has been sent successfully.';
} else{
    echo 'Unable to send email. Please try again.';
}
?>