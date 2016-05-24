<?php

//Transmission Credentials
$user = "___";
$pass = "___";
$connection   = "192.168.1.___:1338";
  
//base command, used by all API.
function generateQuery($command)
{
    global $user,
           $pass,
           $connection;
    
    exec('transmission-remote '.$connection.' --auth  '.$user.':'.$pass.' '.$command, $output);
    return $output;
}

    
?>