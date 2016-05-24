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
            $ratio;
    
    //Constructor
    function __construct($id)
    {
        $this->id = $id;
        
        //If we successfully give this object a ID then load it with data.
        if($this->id != NULL)
            $this->update();
        
        echo 'Torrent: '.$this->id.' created.'.PHP_EOL;
    }
    
    //Sets the objects values, this will be called every refresh.
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
            return generateQuery('-t'.$id.' -R');
        else    
            return generateQuery('-t'.$id.' -r');
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
    //==================================
    
}
?>