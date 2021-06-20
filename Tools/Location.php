<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("interface.php");

class Location implements Tools
{
    public $title = "Location";
    public $instance;
    public $Methods;


    public $array_files = array();

    public function Base()
    {
        $this->Methods = $this->BuilderMethods();
        $array = array('instance' => $this->instance , 'Methods' =>  $this->Methods);
        return $array;
    }
    public function BuilderMethods()
    {
        $this->instance = $this;
        $methods = get_class_methods($this);
        $array = array();
        foreach($methods as $method){ $array += [$method => $method]; }
        return $array;
    }



    /* function get all files php in dir and set as array with keys */
    public function SetArrayFilesByNames()
    {  
        foreach (glob("*.php") as $filename)
        {
            if (strpos($filename, '.php') !== false)
            {
                $name = $this->GetNameFile($filename);
                $pathName = $filename;
                $row = array('Name' => $name, 'Path' => $pathName);
                array_push($this->array_files, $row);
            }
        }
    }


    /* this funcetion return name file  without php*/
    public function GetNameFile($str)
    {
        $order = ".php";
        $replace = '';
       return str_replace($order, $replace, $str);
    }

    public function GetLocationByName()
    {
        $this->SetArrayFilesByNames();
        $location = $_SERVER['PHP_SELF'];
        return $this->GetNameFile($this->mb_basename($location));
    }

    // works both in windows and unix
    public function mb_basename($path)
    {
    if (preg_match('@^.*[\\\\/]([^\\\\/]+)$@s', $path, $matches)) {
        return $matches[1];
    } else if (preg_match('@^([^\\\\/]+)$@s', $path, $matches)) {
        return $matches[1];
    }
        return '';
    }
}



?>