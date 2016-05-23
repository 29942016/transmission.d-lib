<?php

//Transmission Credentials
$user = "lombardi";
$pass = "Rev0lt1x01";
$connection   = "192.168.1.102:1338";
  
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