<?php 
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("interface.php");
class online implements Plugins
{

    public $title = "online";
    public $instance;
    public $Methods;

    public function Builder()
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


    # this function for set as online one table onlines
    # for more information about status website.
    function SetOnline()
    {
        global $conn, $tools;
        $Ipaddress = $tools->tool['BaseTools']['instance']->get_ip();
        if($this->CheckExists($Ipaddress))
        {
            #Update Date time to new one.
        }
        else
        {
            #Set Query
            $query = "SELECT * FROM `onlines` WHERE Ipaddress = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $Ipaddress);
            $stmt->execute();
        }
    }

    function CheckExists($Ipaddress)
    {
        global $conn;
        #Set Query
        $query = "SELECT * FROM `onlines` WHERE Ipaddress = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $Ipaddress);
        $stmt->execute();

        #Get result 
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? true : false;
    }


    function ClearOfflines()
    {

    }
}