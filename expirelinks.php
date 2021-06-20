<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

# this for report videos by guests.
include_once("IncludeAll.php");
if(isset($_POST['expirelinks']))
{
    if(isset($_POST['vide_id']))
    {


        $vide_id = (string)$_POST['vide_id'];

        #checking if there more then one.
        $query = "SELECT * FROM `expirelinks` WHERE `epvideoid` = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $vide_id);
        $stmt->execute();
        $results = $stmt->get_result();

        if($results->num_rows > 0)
        {
            echo 'success=\'لقد استلمنا طلب مسبق وجاري المعاينه له..;';
            exit;
        }
        $time = date ('Y-m-d H:i:s', time());
        $done = false;
        $query = "INSERT INTO `expirelinks`(`epvideoid`, `time`, `done`) VALUES ( ? , ? , ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss',$vide_id,$time,$done);

        if($stmt->execute())
        {
            echo 'success=\'شكرا لك تم تبليغ عن الروابط بنجاح  وسيتم مراجعة باقرب وقت.;';
            exit;
        }
        else
        {
            echo 'danger=\'حدث خطاء ما برجاء مراسلة الادارة الموقع.;';
            exit;
        }
    }
    
}
?>