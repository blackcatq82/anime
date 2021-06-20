<?php
# this for report videos by guests.
include_once("IncludeAll.php");
include_once("Includes/start.php");
if(isset($_POST['report']))
{
    if(isset($_POST['link']))
    {


        $link = (string)$_POST['link'];

        #checking if there more then one.
        $query = "SELECT * FROM `report` WHERE link = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $link);
        $stmt->execute();
        $results = $stmt->get_result();

        if($results->num_rows > 0)
        {
            echo 'success=\'لقد استلمنا طلب مسبق وجاري المعاينه له..;';
            exit;
        }
        $time = date ('Y-m-d H:i:s', time());
        $done = false;
        $query = "INSERT INTO `report`(`link`, `date`, `done`) VALUES ( ? , ? , ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss',$link,$time,$done);
        if($stmt->execute())
        {
            echo 'success=\'شكرا لك تم تبليغ بنجاح  وسيتم مراجعة باقرب وقت.;';
            exit;
        }
        else
        {
            echo 'danger=\'حدث خطاء ما برجاء مراسلة الادارة الموقع.;';
            exit;
        }
    }
    
}
if(isset($_POST['send-report']))
{
    if(isset($_POST['title-report']))
    {
        if(isset($_POST['massage-report']))
        {
            if(!empty($_POST['title-report']) && !empty($_POST['massage-report']))
            {
                $title = "Report by guests.";
                $query = "SELECT * FROM `report_massage` WHERE `title` = ? AND `message` = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ss',$_POST['title-report'],$_POST['massage-report']);
                if($stmt->execute())
                {
                    $results = $stmt->get_result();
                    if($results->num_rows > 0)
                    {
                        $error = '<div class="alert alert-success" role="alert">
                        لفد وصلنا طلبك من قبل وشكراً لك مره اخر وجاري المتابعة لتبليغكم المحترم شكرا مره اخر.
                       </div>';
                    }
                    else
                    {
                        $title = (string)$_POST['title-report'];
                        $massage = (string)$_POST['massage-report'];
                        $date = date ('Y-m-d H:i:s', time());
                        $ip = $tools->tool['BaseTools']['instance']->get_ip();
                        $path = $title;

                        $query = "INSERT INTO `report_massage`(`title`, `message`, `date`, `ip`, `path_report`) VALUES ( ? , ? , ? , ? , ? )";

                        $stmt  = $conn->prepare($query);
                        $stmt->bind_param('sssss',$title,$massage,$date,$ip,$path);
                        if($stmt->execute())
                        {
                            $error = '<div class="alert alert-success" role="alert">
                            تم الارسال وسيتم مراجعة طلبك في اقرب وقت ممكن وشكراً لك.
                           </div>';
                        }
                    }
                }
                else
                {
                    $error = '<div class="alert alert-warning" role="alert">
                    حاول مرة اخر او اتصل بالادارة عن طريق البريد الالكتروني.
                   </div>';
                }
            }
            else
            {
                $error = '<div class="alert alert-warning" role="alert">
                أكمل البيانات من فضلك.
               </div>';
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php  if(isset($title)){echo $title_website.' '.$title;}else{echo $title_website;} ?></title>
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Markazi+Text">
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/css/styles.min.css">
</head>
<body>
<main id="page">
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<!--- start anime list --->
<div id="Title">
    <h4 style="display:inline;"> يمكنك تبليغ هنا </h4> <p style="display:inline;color:red;font-size:24px;"> ❤ </p>
</div>
<!--- end search ajax --->
<div id="Context-About">
    <div class="body-blocker">
        <div class="row justify-content-center" id="terms">
            <div class="col-sm-12 col-lg-12">
                <div class="base-message">
                    <div class="About-us-Title">
                        <h5> صندوق الإرسال! </h5>
                    </div>
                    <div class="marks-point">
                        <?php if(isset($error)){echo $error;} ?>
                        <form class="form-message" action="" method="POST">
                            <small> عنوان الكرتون او الرابط: </small>
                            <input type="text" name="title-report" id="title-massage" placeholder="أسم الكرتون او الحلقة او الرابط "/>
                            <small> السبب : </small>
                            <textarea type="text" name="massage-report" id="title-massage"></textarea>
                            <button class="btn btn-dark" type="submit" name="send-report" value="true" id="title-massage">أرسل</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php include_once("Includes/footer.php");
include_once('Includes/end.php');
?>
</body>
</html>