<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../objects/emailer.php';

    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiODIifQ.U5wQtAYs5O5QlVCIFKub1Q70dbBfh5jSHxWIbfHBriU';
    $link ='http://saidia.eastweb.com.au/resetPwd?token='.$token;
    $name= 'arden';
    $email ='kharddie@hotmail.com';

    //email to user
    $sendEmail = new Emailer();

    $sendEmail->to = $email;
    $sendEmail->subject = 'Email from saidia.com.au';
    $sendEmail->from = 'saidia@eastweb.com.au';
    $sendEmail->link ='http://saidia.eastweb.com.au/resetPwd';

    $sendEmail->message = '<html><body tyle="background-color:#f8f9fa;">';
    $sendEmail->message .= '<table style="width:100%">';
    $sendEmail->message .= '  <tr>';
    $sendEmail->message .= '   <th style="background-color:#ffffff;"><h1>saidia.com.au</h1></th>';
    $sendEmail->message .= ' </tr>';
    $sendEmail->message .= ' <tr>';
    $sendEmail->message .= '   <td>';
    $sendEmail->message .= '<p style="color:#839094;font-size:18px;">Hi, '.$name.'<br/>Click the link below to reset your your password\n</p>
    <p style="color:#839094;font-size:18px;">'.$link.'
    </p><p style="color:#839094;font-size:18px;">Kind regards,<br/>Admin</p>
    ';
    $sendEmail->message .= '  </td>';
    $sendEmail->message .= '  </tr>';
    $sendEmail->message .= ' <tr>';
    $sendEmail->message .= '   <td style="background-color:#26272b;width:50px">Copyright © eastweb 2018</td>';
    $sendEmail->message .= '  </tr>';
    $sendEmail->message .= '</table>'; 
    $sendEmail->message .= '</body></html>';

    $sendEmail->sendEmail();























?>