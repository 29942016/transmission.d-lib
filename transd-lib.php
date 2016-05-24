<?php

error_reporting(1);
require_once("authentication.php");
require_once("torrent.php");

//Declare and initilize the torrent list
$torrentList = array();
refreshTorrents();

//=========================================
//      Transmission Settings API
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

//Sets the Upload/Download speed, if 0 then no limit is applied.
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

//Check for available torrents and then populate our own torrent object array
function refreshTorrents()
{
    $ids = array();
    global $torrentList;
    
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
    {
        $torrentList[$counter] = new Torrent($newTor);
    }
    
}

//function used for debugging 
function debug()
{
    global $torrentList;
    
    //echo var_dump($torrentList);
    
    //echo $torrentList[0]->getName();
    $test = $torrentList[0]->info();
    var_dump($test);
}

?>