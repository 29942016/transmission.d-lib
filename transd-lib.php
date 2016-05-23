<?php

error_reporting(1);
require_once("authentication.php");


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

//Adds torrent via URL+Autostart, returns FAIL/SUCESS
function addTorrent($url, $autostart = false)
{
    $autostart = "";
    
    if($autostart === true)
        $start = "--no-start-paused";
    else
        $start = "--start-paused";
        
    return generateQuery($start." --add ".$url);
}

//=====================
?>