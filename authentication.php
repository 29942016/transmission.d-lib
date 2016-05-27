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

//Removes the 'key value' on the array object
function stripTextBuffer($text)
{
    $text = strstr($text, ': ');          //Strip everything preceeding ':'
    $text = str_replace(': ', '', $text); //Strip the ':'
    return $text;
}

//Check the result of the query
function parseOutput($result)
{
    if(strpos($result[0], "success") !== false)
        echo "SUCCESS";
    else
        echo "FAILED";
}
    
?>
