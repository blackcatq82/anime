<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

# this for report videos by guests.



/* Includes Started */
include_once("IncludeAll.php");
include_once("Includes/start.php");


// التاكد من حصولنا على القيمة التبليغات
if(isset($_POST['report']))
{
    // التاكد من حصولنا على الرابط المبلغ عنه
    if(isset($_POST['link']))
    {

        // اخذ الرابط بشكل نصي
        $link = (string)$_POST['link'];
        
        // اخذ ايبي الشخص مقدم الطلب التبليغ
        $ip =  $tools->tool['BaseTools']['instance']->get_ip();

        // صنع query injection من اجل عدم تكرار
        $query = "SELECT * FROM `report` WHERE link = ? AND IpAddress = ?";

        // اضافة query
        $stmt = $conn->prepare($query);

        // اضافة القيمة الرابط في query.
        $stmt->bind_param('ss', $link, $ip);

        // تفعيل الامر
        $stmt->execute();

        // اخذ النتائج البحث في قاعدة البيانات
        $results = $stmt->get_result();

        // التاكد من وجود النتائج
        if($results->num_rows > 0)
        {
            echo 'success=\'لقد استلمنا طلب مسبق وجاري المعاينه له..;';
            exit;
        }

        // تسجيل الوقت الفعلي
        $time = date ('Y-m-d H:i:s', time());

        // وضع الحالة غير مكتمل للعلم بحالة الطلب.
        $done = false;
        

        // صنع كويري لتسجيل البيانات في قاعدة البيانات
        $query = "INSERT INTO `report`(`link`, `date`, `done`, `IpAddress`) VALUES ( ? , ? , ? , ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $link, $time, $done, $ip);

        // تفعيل الامر
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
// check if we found value send-report in method post.
if(isset($_POST['send-report']))
{
    // check if there set value title-reported.
    if(isset($_POST['title-report']))
    {
        // check message reported.
        if(isset($_POST['massage-report']))
        {
            // check if they are not empty.
            if(!empty($_POST['title-report']) && !empty($_POST['massage-report']))
            {
                // Title Reported.
                $title = "Report by guests.";
                // Seleced from report tab in mysql.
                $query = "SELECT * FROM `report_massage` WHERE `title` = ? AND `message` = ?";
                // set query in prepare.
                $stmt = $conn->prepare($query);
                // bind the values in query.
                $stmt->bind_param('ss', $_POST['title-report'], $_POST['massage-report']);
                // exeucted the query injection.
                if($stmt->execute())
                {
                    // get results.
                    $results = $stmt->get_result();
                    // check if there row mean we got the order befor.
                    if($results->num_rows > 0)
                    {
                        $error = '<div class="alert alert-success" role="alert">
                        لفد وصلنا طلبك من قبل وشكراً لك مره اخر وجاري المتابعة لتبليغكم المحترم شكرا مره اخر.
                       </div>';
                    }
                    else
                    {
                        // set title reported.
                        $title = (string)$_POST['title-report'];
                        // set message text as string value.
                        $massage = (string)$_POST['massage-report'];
                        // set date timer now.
                        $date = date ('Y-m-d H:i:s', time());
                        // use tool for get ip address sender order report.
                        $ip = $tools->tool['BaseTools']['instance']->get_ip();
                        // set path report from title
                        $path = $title;
                        // create a insert query,
                        $query = "INSERT INTO `report_massage`(`title`, `message`, `date`, `ip`, `path_report`) VALUES ( ? , ? , ? , ? , ? )";
                        // set on prepare method.
                        $stmt  = $conn->prepare($query);
                        // set bind param values.
                        $stmt->bind_param('sssss',  $title,     $massage,   $date,  $ip,    $path);

                        // execute the query
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
<?php 
/* Include Ended */
include_once("Includes/footer.php");
include_once('Includes/end.php');
?>
</body>
</html>