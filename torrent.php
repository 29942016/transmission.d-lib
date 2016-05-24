<?php
require_once("authentication.php");

class Torrent
{
    //Class variables
    private $id,
            $name,
            $hash,
            $magnetURI,
            $state,
            $location,
            $complete,
            $ETA,
            $downSpeed,
            $upSpeed,
            $totalSize,
            $downloaded,
            $uploaded,
            $ratio,
            $bandwidthAllowance,
            $peers;
    
    //Constructor
    function __construct($id)
    {
        $this->id = $id;
        
        //If we successfully give this object a ID then load it with data.
        if($this->id != NULL)
            $this->update();
    }
    
    //Sets the objects values.
    function update()
    {
        $data = generateQuery(' -t'.$this->id.' -i');
        
        $this->name = $this->stripTextBuffer($data[2]); 
        $this->hash = $this->stripTextBuffer($data[3]); 
        $this->magnet = $this->stripTextBuffer($data[4]);
        $this->state = $this->stripTextBuffer($data[7]);
        $this->location = $this->stripTextBuffer($data[8]);
        $this->complete = $this->stripTextBuffer($data[9]);
        $this->ETA = $this->stripTextBuffer($data[10]);
        $this->downSpeed = $this->stripTextBuffer($data[11]);
        $this->upSpeed = $this->stripTextBuffer($data[12]);
        $this->totalSize = $this->stripTextBuffer($data[15]);
        $this->downloaded = $this->stripTextBuffer($data[16]);
        $this->uploaded = $this->stripTextBuffer($data[17]);
        $this->ratio = $this->stripTextBuffer($data[18]);
        $this->peers = $this->stripTextBuffer($data[20]);
        $this->bandwidthAllowance = $this->stripTextBuffer($data[41]);
        
        
    }
    
    //Removes the 'key value' on the array object
    function stripTextBuffer($text)
    {
        $text = strstr($text, ': ');          //Strip everything preceeding ':'
        $text = str_replace(': ', '', $text); //Strip the ':'
        return $text;
    }
    
    //======= Torrent functions =========
    
    //Start downloading/uploading
    function start()
    {
        return generateQuery(' -t'.$this->id.' -s');
    }
    
    //Stop downloading/uploading
    function stop()
    {
        return generateQuery(' -t'.$this->id.' -S');
    }
    
    //Returns a structured array of this objects properties i.e name,id,hash,magnet.
    function info()
    {
        return get_object_vars($this);
    }
    
    // Remove the torrent, if delete is true then also remove related data, returns FAIL/SUCCESS in array object
    function remove($delete = false)
    {
        if($delete == true)
            return generateQuery('-t'.$this->id.' -R');
        else    
            return generateQuery('-t'.$this->$id.' -r');
    }
    
    
    //=====================================
    
    
    //========== Get+set 'ers ============
    function getID()
    { return $this->id; }
    
    function getName()
    { return $this->name; }
    
    function getMagnetURI()
    { return $this->magnet; }
    
    function getHash()
    { return $this->hash; }
    
    function getComplete()
    { return $this->complete; }
    
    function getState()
    { return $this->state; }

    function getLocation()
    { return $this->location; }
    
    function getETA()
    { return $this->ETA; }
    
    function getDownSpeed()
    { return $this->downSpeed; }
    
    function getUpSpeed()
    { return $this->upSpeed; }
    
    function getTotalSize()
    { return $this->totalSize; }
    
    function getDownloaded()
    { return $this->downloaded; }
    
    function getUploaded()
    { return $this->uploaded; }
    
    function getRatio()
    { return $this->ratio; }
    
      function getPeers()
    { return $this->peers; }
    
    function getBandwidthAllowance()
    { return $this->bandwidthAllowance; }
    
    function setBandwidthAllowance($input)
    { 
        $input = strtolower($input);
        $append = "";
        
        if(strpos($input, "high") !== false)
            $append.=" -Bh";
        else if(strpos($input, "low") !== false)
            $append.=" -Bl";
        else
            $append.=" -Bn";
        
        return generateQuery('-t'.$this->id.' '.$append);
    }
    
  
    //==================================
    
}
?>