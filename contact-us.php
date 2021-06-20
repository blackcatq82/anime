<?php
include_once("IncludeAll.php");
include_once('Includes/start.php');

if(isset($_POST['send-message']))
{
    if(isset($_POST['title-massage']))
    {
        if(isset($_POST['email-massage']))
        {
            if(isset($_POST['massage']))
            {
                if(!empty($_POST['massage']) && !empty($_POST['email-massage']) && !empty($_POST['title-massage']))
                {
                    $email = (string)$_POST['email-massage'];
                    $title = (string)$_POST['title-massage'];
                    $message = (string)$_POST['massage'];
                    $date = date ('Y-m-d H:i:s', time());
                    $ip = $tools->tool['BaseTools']['instance']->get_ip();
                    $done = false;
                    $query = "SELECT * FROM `contact_us` WHERE `title` = ? AND `message` = ? AND `email` = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('sss',$title,$message,$email);
                    $stmt->execute();
                    $results = $stmt->get_result();
                    
                    if($results->num_rows > 0)
                    {
                        $error = '<div class="alert alert-warning" role="alert">
                        لقد إستلمنا رسالتك من قبل شكراً لك وسيتم الرد عليه في إقرب وقت
                       </div>';
                    }
                    else
                    {
                        $query = "INSERT INTO `contact_us`(`title`, `message`, `email`, `date`, `ip`, `done`) VALUES (? , ? , ? , ? , ? , ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('ssssss',$title,$message,$email,$date,$ip,$done);
                        if($stmt->execute())
                        {
                            $email_title = "تم استقبال رسالتكم كرتون مدبلج بالعربي !!";
                            $body = $template = file_get_contents("template/contact-us.html");
                            $body = str_replace('[title]',$title ,$body);
                            $body = str_replace('[email]',$email ,$body);
                            $body = str_replace('[date]',$date ,$body);
                            $plugins->plugin['email']['instance']->sendto($email,$email_title,$body);                            
                            $error = '<div class="alert alert-success" role="alert">
                            لقد تم إرسال رسالتك شكراً من القلب لكم وجاري الرد عليه في أقرب وقت..
                           </div>';

                        }
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
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php  echo $title_website; ?></title>
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
<div id="Title">
    <h4 style="display:inline;"> أرسل لنا رسالتك </h4> <p style="display:inline;color:red;font-size:24px;"> ❤ </p>
</div>
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
                        <form action="" method="POST" class="form-message">
                            <small> بريدك الإلكتروني : </small>
                            <input type="text" name="email-massage" id="title-massage"  placeholder="بريدك الإلكتروني"/>
                            <small> عنوان رسالتك : </small>
                            <input type="text" name="title-massage" id="title-massage" placeholder="عنوان الرسالة"/>
                            <small> رسالتك : </small>
                            <textarea type="text" name="massage" id="title-massage"></textarea>
                            <button class="btn btn-dark" type="submit" name="send-message" value="true" id="title-massage">أرسل</button>
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