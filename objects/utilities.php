<?php
class Utilities{
 
    public $error;
    public $success;
    public $data;
    public $extraInfo;
    public $message;

public  function returnApi($error,$success ,$data,$message) {

$Str = <<<EOT
  data = {
      error: $error
      success: $success
      data: $data
      message: $message
    }
EOT;

  return $Str;

}

}


