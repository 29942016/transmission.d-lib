<?php
error_reporting(1);
require_once("authentication.php");

/* DEBUG data
$tor1 = new Torrent(16);
echo PHP_EOL.'> '.$tor1->getID();
echo PHP_EOL.'==> '.$tor1->getName();
echo PHP_EOL.'==> '.$tor1->getHash();
echo PHP_EOL.'==> '.$tor1->getComplete();
echo PHP_EOL.'==> '.$tor1->getMagnetURI();
*/

class Torrent
{
    //Class variables
    private $id;
    private $name;
    
    private $hash,
            $magnetURI,
            $state,
            $location,
            $complete;
    
    //Constructor
    function __construct($id)
    {
        $this->id = $id;
        
        //If we successfully give this object a ID then load it with data.
        if($this->id != NULL)
            $this->update();
    }
    
    //Class methods
    function update()
    {
        $data = generateQuery(' -t'.$this->id.' -i');
        $this->name = $this->stripTextBuffer($data[2]);
        $this->hash = $this->stripTextBuffer($data[3]);
        $this->magnet = $this->stripTextBuffer($data[4]);
        $this->complete = $this->stripTextBuffer($data[9]);
    }
    
    //Removes the 'key value' on the array object
    function stripTextBuffer($text)
    {
        $text = strstr($text, ': ');          //Strip everything preceeding ':'
        $text = str_replace(': ', '', $text); //Strip the ':'
        return $text;
    }
    
    //Get+Set 'ers
    function getID()
    {
        return $this->id;
    }
    function getName()
    {
        return $this->name;
    }
    function getMagnetURI()
    {
        return $this->magnet;
    }
    function getHash()
    {
        return $this->hash;
    }
    function getComplete()
    {
        return $this->complete;
    }
    
   
}
?>