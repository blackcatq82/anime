<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022
/// this for cards anime loop in index page.
include_once("interface.php");
class email implements Plugins
{
    /**
     *  this class well building on plugins.
     */
    public $title = "email";
    public $instance;
    public $Methods;
    private $page_number,$page_max;
    
    # start to building.
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
    /**
     * we use it fun for send message to guest.
     */
    public function sendto($email,$title, $msg)
    {
        $headers = 'From: <cartoon.modablg@gmail.com>' . "\r\n"; 
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $subject = '=?utf-8?B?'.base64_encode($title).'?=';

        if(mail($email,$subject,$msg,$headers))
        {
            # we are sending a msg to persion by gmail.com
        }
        else
        {
            # we are didn't sending to persion by gmail.com
        };
       
    }

}