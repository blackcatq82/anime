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
        # Get IpAddress client
        $Ipaddress = $tools->tool['BaseTools']['instance']->get_ip();
        # Set object information.
        $information = array('country_code' => 'Unknow');
        # Set Date setting
        $date = date ('Y-m-d H:i:s', time());
        # Set strtotime 
        $date = strtotime($date);
        # calcul 3600*24 = seconds 24hours.
        $second24h = (int)(3600 * 24);
        $date = date('Y-m-d H:i:s', strtotime($second24h .' sec', $date));
        if(strlen($Ipaddress) > 4)
        {
            $information = $tools->tool['BaseTools']['instance']->ip_info($Ipaddress);
        }

        if($this->CheckExists($Ipaddress))
        {
            #Update Date time to new one.
            $query = "UPDATE `onlines` SET `Country`= ?,`Date`= ? WHERE `Ipaddress` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $information['country_code'], $date, $Ipaddress);
            $stmt->execute();
        }
        else
        {   
            $username = '';
            #Set Query
            if(isset($_SESSION['username']))
            {
                $username  = $_SESSION['username'];
            }
            $query = "INSERT INTO `onlines`(`Ipaddress`, `Country`, `Date`, `username`) VALUES ( ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $Ipaddress, $information['country_code'], $date, $username);
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


    function InitClear()
    {
        global $conn;
        #Set Query
        $query = "DELETE FROM `onlines` WHERE Date < ? ";
        $stmt = $conn->prepare($query);
        $new = date ('Y-m-d H:i:s', time());
        $stmt->bind_param('s', $new);
        $stmt->execute();

    }

    function Count()
    {
        global $conn;
        #Set Query
        $query = "SELECT * FROM `onlines`";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return (int)$result->num_rows;
    }

    function GetOnlines()
    {
        global $conn;
        #Set Query
        $query = "SELECT * FROM `onlines`";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        #TODO : Desgin online on 24h class
        # set rows in them.
        while($rows = $result->fetch_assoc())
        {
            $code = strtolower($rows['Country']);

            if($code == 'unknow'){
                $code = 'kw';                
            }

            if($rows['username'] != '')
            {
                echo '<li class="Flagli">' . $rows['username'] .' من <img class="flag" src="https://lipis.github.io/flag-icon-css/flags/4x3/' . $code . '.svg" style="height:30px;weight:30px;" alt=""></li>';
                continue;
            }
            
            echo '<li class="Flagli">ضيف من <img class="flag" src="https://lipis.github.io/flag-icon-css/flags/4x3/' . $code . '.svg" style="height:30px;weight:30px;" alt=""></li>';
        }
    }
}