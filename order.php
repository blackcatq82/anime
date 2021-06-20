<?php
include_once("IncludeAll.php");
include_once("Includes/start.php");
if(isset($_POST['ordername']) && isset($_POST['orderemail']))
{
    $name_order = $_POST['ordername'];
    $email_order = $_POST['orderemail'];

    if(!empty($name_order) && !empty($email_order))
    {
        $plugins->plugin['order']['instance']->create_order($name_order,$email_order);
    }
    else
    {
        echo 'danger=\'أدخل جميع البيانات المطلوبة.;';
    }

    
}
include_once("Includes/end.php");