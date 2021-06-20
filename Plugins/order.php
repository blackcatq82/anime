<?php 

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("InterFaces.php");
class order implements Plugins
{
    public $title = "order";
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
    /* we use it function for login users as well. */
    public function create_order($order_name , $order_email)
    {
        # we use a global database
        global $conn;
        # we need to checking if there some row is null.
        if(empty($order_name) || empty($order_email))
        {
            # we need to return message about null values.
            echo 'danger=\'أدخل جميع البيانات المطلوبة.;';
            return;
        }
        else
        {

           
            $q = "SELECT * FROM orders WHERE order_name = ? AND order_email = ?";
            $x = $conn->prepare($q);
            $x->bind_param('ss',$order_name,$order_email);
            $x->execute();
            $results = $x->get_result();

            if($results->num_rows > 0)
            {
                $row = $results->fetch_assoc();
                echo 'success=\' شكراً لكم من جديد طلبك مسجل بالفعل في تاريخ <br /> ' . $row['time'] . ';';
            }
            else
            {   # first checking in data base if has rows.
                $QUERY = "INSERT INTO `orders`(`order_name`, `order_email`, `time`) VALUES (? , ? , STR_TO_DATE( ? , '%Y/%m/%d %H:%k:%S'))";
                $time = date("Y/m/d h:m:s");
                $stmt = $conn->prepare($QUERY);
                $stmt->bind_param('sss', $order_name , $order_email,$time);
                $stmt->execute();
                echo 'success=\' تم قبول طلبك ستم معالجته بأقرب وقت ممكن وتبليغكم عبر البريد شكرأ من قلب .. ;';
                /** str_replace.
                 * [numberorder] : رقم الطلب
                 * [cartoonname] : الاسم الكرتون
                 * [date] : تاريخ الطلب
                 */
                $random_number = rand(1000,100000);
                $title = "تم قبول طلبك كرتون عربي مدبلج";
                $messagetouser = $template = file_get_contents("template/order.html");

                $messagetouser = str_replace('[numberorder]', $random_number ,$messagetouser);
                $messagetouser = str_replace('[cartoonname]',$order_name ,$messagetouser);
                $messagetouser = str_replace('[date]',$time ,$messagetouser);
                global $plugins;
                $plugins->plugin['email']['instance']->sendto($order_email,$title,$messagetouser);
            }

        }
    }
}