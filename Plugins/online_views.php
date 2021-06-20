<?php 

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

/// for take setting from mysqli and use on.
include_once("InterFaces.php");
class online_views implements Plugins
{
    public $title = "online_views";
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

    # we are getting a values from table SELECT * FROM `navbar`
    public function set_online($animeid)
    {
        # we will using a global value connection to mysql.
        global $conn;
        global $tools;
        # values set
        $REQUEST_URI = urldecode($_SERVER['REQUEST_URI']);
        $link = $animeid;
        $ip = $tools->tool['BaseTools']['instance']->get_ip();
        /*
        $ip_information = $tools->tool['BaseTools']['instance']->ip_info('822.123.213.121');
        # maybe we will use it shit.
        #this away to know guest country code.
        var_dump($ip_information['country_code']);

        */

        $date = date ('Y-m-d H:i:s', time());
        $date = strtotime($date);
        $date = date('Y-m-d H:i:s', strtotime('30 sec', $date));
        # we needed to find a online guest has same ip.
        $query = "SELECT * FROM `online_views` WHERE `ip` = ? ";
        # we will start to prepare with connection.
        $stmt = $conn->prepare($query);
        # we will add values on stmt.
        $stmt->bind_param('s', $ip);
        # we will execute a query mysql.
        $stmt->execute();
        # check num
        $num = $stmt->get_result();

        if($num->num_rows > 0)
        {
            $query = "DELETE FROM `online_views` WHERE `ip` =  ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $ip);
            $stmt->execute();
            
        }
        # we need to deleted old views.
        $query = "DELETE FROM `online_views` WHERE date < ? ";
        $stmt = $conn->prepare($query);
        $new = date ('Y-m-d H:i:s', time());
        $stmt->bind_param('s', $new);
        $stmt->execute();
        
        # we will create a query for select table.
        $QUERY = "INSERT INTO `online_views`(`link`, `ip`, `date`) VALUES ( ? , ? , ? )";
        # we will start to prepare with connection.
        $stmt = $conn->prepare($QUERY);
        # we will add values on stmt.
        $stmt->bind_param('sss', $link , $ip , $date);
        # we will execute a query mysql.
        $stmt->execute();
    }

    public function GetCountView($link)
    {
        # we need to select by count as `views` on table.
    
        global $conn;
        global $tools;

        $query = "SELECT COUNT(*) as `views` FROM `online_views` WHERE `link` = ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param('s',$link);
        if($stmt->execute())
        {
            $results = $stmt->get_result();
            $count = $results->fetch_assoc();

            return $count['views'];
        }
    }
}