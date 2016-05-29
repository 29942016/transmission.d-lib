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
    private function update()
    {
        $data = generateQuery(' -t'.$this->id.' -i');
        
        $this->name     = stripTextBuffer($data[2]); 
        $this->hash     = stripTextBuffer($data[3]); 
        $this->magnet   = stripTextBuffer($data[4]);
        $this->state    = stripTextBuffer($data[7]);
        $this->location = stripTextBuffer($data[8]);
        $this->complete = stripTextBuffer($data[9]);
        $this->ETA      = stripTextBuffer($data[10]);
        $this->downSpeed= stripTextBuffer($data[11]);
        $this->upSpeed  = stripTextBuffer($data[12]);
        $this->totalSize = stripTextBuffer($data[15]);
        $this->downloaded = stripTextBuffer($data[16]);
        $this->uploaded = stripTextBuffer($data[17]);
        $this->ratio    = stripTextBuffer($data[18]);
        $this->peers    = stripTextBuffer($data[20]);
        $this->bandwidthAllowance = stripTextBuffer($data[41]);
        
        
    }
    //======= Torrent functions =========
    
    //Start downloading/uploading
    public function start()
    {
        return parseOutput(generateQuery(' -t'.$this->id.' -s'));
    }
    
    //Stop downloading/uploading
    public function stop()
    {
        return parseOutput(generateQuery(' -t'.$this->id.' -S'));
    }
    
    //Returns a structured array of this objects properties i.e name,id,hash,magnet.
    public function info()
    {
        return get_object_vars($this);
    }
    
    // Remove the torrent, if delete is true then also remove related data, returns FAIL/SUCCESS in array object
    public function remove($delete = false)
    {
        if($delete == true)
            return parseOutput(generateQuery('-t'.$this->id.' --remove-and-delete'));
        else    
            return parseOutput(generateQuery('-t'.$this->id.' -r'));
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
        
        return parseOutput(generateQuery('-t'.$this->id.' '.$append));
    }
    
  
    //==================================
    
}
?>
