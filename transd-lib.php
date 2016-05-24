<?php

error_reporting(1);
require_once("authentication.php");
require_once("torrent.php");

//Declare and initilize the array for storing torrents
$torrents = array();
refreshTorrents();

//=========================================
//   Transmission Global Settings API
//=========================================

//Adds torrent via URL+Autostart, returns FAIL/SUCCESS
function addTorrent($url, $autostart = true)
{
    $autostart = "";
    
    if($autostart === true)
        $start = "--no-start-paused";
    else
        $start = "--start-paused";
        
    return generateQuery($start." --add ".$url);
}

//Starts all torrents
function startAll()
{
    global $torrents;
    
    foreach($torrents as $torrent)
        $torrent->start();
}
//Stops all torrents
function stopAll()
{
    global $torrents;
    
    foreach($torrents as $torrent)
        $torrent->stop();
}

//Sets the global Upload/Download speed, if 0 then no limit is applied.
function setSpeed($down = NULL, $up = NULL)
{
    $append = "";
    
    if($down != NULL)
       $append.=' -d'.$down;
    else if($down == 0)
        $append.=' -D';
    
    if($up != NULL)
       $append.=' -u'.$up;
    else if($up == 0)
        $append.=' -U';
    
    return generateQuery($append);
    
}

//Tell the daemon to run a script as the transmission user on torrent completion
function runScriptOnFinish($enabled = false, $scriptPath = "")
{
    if($enabled == true && $scriptPath != "")
        return generateQuery('--torrent-done-script '.$scriptPath);
    else
        return generateQuery('--no-torrent-done-script');
        
}

//Returns current session stats + overall statistics in array
function sessionStats()
{
     return generateQuery('-st | sed \'s/  */ /g\' ');        
}

//Check for available torrents and then populate our own torrent object array
function refreshTorrents()
{
    $ids = array();
    global $torrents;
    
    //Grab the ID of every available torrent into a array
    $idArray = generateQuery('-l | sed \'s/  */ /g\' | cut -d\' \' -f2');
    
    //move the array ids into a ordered array.
    foreach($idArray as $counter=>$index)
    {
        //Dont include the first and last rows of torrent information, they're just header/footer rows.
        if($counter != 0 && $counter != count($idArray)-1)
            $ids[$counter-1].=$index;
    }
    
    //create torrent objects based off the available ids
    foreach($ids as $counter=>$newTor)
        $torrents[$counter] = new Torrent($newTor);
}
?>