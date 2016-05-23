<?php

error_reporting(1);

//Transmission Credentials
$user = "lombardi";
$pass = "Rev0lt1x01";
$connection   = "192.168.1.102:1338";
  


//====== API ========

//Create command
function generateQuery($command)
{
    global $user,
            $pass,
            $connection;
    
    exec('transmission-remote '.$connection.' --auth  '.$user.':'.$pass.' '.$command, $output);
    return $output;
}

//Returns a specific torrent via its array index.
function getTorrent($id)
{
   return generateQuery('-t'.$id.' -i');
}

//Returns all currently added torrents.
function getAllTorrents()
{
    return generateQuery('-l');
}

?>