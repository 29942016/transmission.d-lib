<?php

error_reporting(1);
require_once("authentication.php");
require_once("torrent.php");

$torrentList = array();
    
//============= API ============//
// Where the paramater $id      //
// is expected; values such     //
// as: '2,3,4' or '2-4'         //
// can be passed, representing  //
// torrents from 2 to 4         //
//==============================//

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

//Remove a torrent via id, if delete is true then also remove related data, returns FAIL/SUCCESS
function removeTorrent($id, $delete = false)
{
    if($id != NULL)
        return generateQuery('-t'.$id.' -r');
    else if($id != NULL && $delete == true)
        return generateQuery('-t'.$id.' -R');
    
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

//Start the selected torrent
function start($id)
{
    return generateQuery('-t'.$id.' -s');
}

//Stop the selected torrent
function stop($id)
{
    return generateQuery('-t'.$id.' -S');
}

//
function populateTorrents()
{
    $ids = array();

    //Grab the ID
    $idArray = generateQuery('-l | sed \'s/  */ /g\' | cut -d\' \' -f2');
    
    foreach($idArray as $counter=>$index)
    {
        //Dont include the first and last rows of torrent information, they're just header/footer rows.
        if($counter != 0 and $counter != count($idArray)-1)
            $ids[$counter].=$index;
    }
    
    //Populate torrents
    foreach($ids as $counter=>$newTor)
    {
        $torrentList[$counter] = new Torrent($newTor);
    }
}

?>