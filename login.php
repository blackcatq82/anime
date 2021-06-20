<?php


#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022




/* Includes Started */
include_once("IncludeAll.php");
include_once("Includes/start.php");


# التاكد من عدم تسجيل دخول والتسجيل بنفس الوقت.
if(isset($_SESSION['username']) && isset($_POST['ajax']))
{
    echo 'danger=\'انت مسجل بالفعل وانت في حسابك الان.;';
    exit;
}
# التاكد عدم دخول المسجلين هذي الصفحة بشكل عام.
else if(isset($_SESSION['username']))
{
    header('location: ' . $dir_website . 'index.php');
    exit;
}

# التاكد من ان استقبل البيانات كاملة عن طريق ajax.
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['ajax']))
{
    // أخذ الاسم المستخدم على انه نصي<div class=""></div>
    $username = (string)$_POST['username'];
    // تشفير الرقم السري قبل إستخدامه.
    $password = md5($_POST['password']);
    // أستخدام بلجن التسجيل بكل سهوله
    $plugins->plugin['register']['instance']->login($username,$password);
    // عمل جلسة بشكل تلقائي كم هو موضح في
    /*
        information : https://www.php.net/manual/en/function.session-regenerate-id.php
        (PHP 4 >= 4.3.2, PHP 5, PHP 7, PHP 8)
        session_regenerate_id — Update the current session id with a newly generated one

        session_regenerate_id() will replace the current session id with a new one, and keep the current session information.
        When session.use_trans_sid is enabled, output must be started after session_regenerate_id() call. Otherwise, old session ID is used.
    */
    session_regenerate_id(true);
}
else
{
    // التاكد عدم دخول المسجلين هذي الصفحة بشكل عام.
    if(isset($_SESSION['username']))
    {
        // تحويل للرئيسية سيتم تغيره قريباً بشكل افضل.
        header('location: index.php');
    }
    

    // أذا تفاعل invoke form register.
    if(isset($_POST['submit']))
    {
        // التاكد من حصولنا على البيانات بشكل كامل
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            // التاكد من انه ليست خاليه او string empty.
            if(empty($_POST['username']) || empty($_POST['password']))
            {
                $error = '<div class="alert alert-danger" role="alert">
                ستكمل جميع الحقول من فضلك !!
            </div>';
            }
            else
            {
                // أخذ الاسم المستخدم كنصي
                $username = (string)$_POST['username'];
                // أخذ كلمة المرور وتشفيره
                $password = md5($_POST['password']);

                // أستخدام بلجن التسجيل بكل سهوله
                $plugins->plugin['register']['instance']->login($username,$password , true);
                /*
                    information : https://www.php.net/manual/en/function.session-regenerate-id.php
                    (PHP 4 >= 4.3.2, PHP 5, PHP 7, PHP 8)
                    session_regenerate_id — Update the current session id with a newly generated one

                    session_regenerate_id() will replace the current session id with a new one, and keep the current session information.
                    When session.use_trans_sid is enabled, output must be started after session_regenerate_id() call. Otherwise, old session ID is used.
                */
                session_regenerate_id(true);
            }
        }
    }
?>
<!DOCTYPE html>
<html>
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

<?php /* include all cuts */ ?>
<?php /* أستدعاء تقسيمات الملفات */ ?>
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>



<div id="Title">
    <h4> تسجيل دخول </h4>
</div>
<div id="Context" class="container">
  <div class="row">
      <div class="col-3"></div>
        <form class="form col-6" method="post" action="login.html" autocomplete="off">
            <?php if(isset($error)){echo $error;} ?>
          <input class="form-control mr-sm-2" name="username" type="username" placeholder="الاسم المستخدم" aria-label="الاسم المستخدم">
          <input class="form-control mr-sm-2" name="password" type="password" placeholder="كلمة المرور" aria-label="كلمة المرور">
          <button class="btn btn-dark" type="submit" name="submit">تسجيل دخول!</button>
        </form>
      <div class="col-3"></div>
    </div>
</div>
</main>
<?php 

/* Includes Ended */
include_once("Includes/footer.php");
include_once('Includes/end.php');


?>
</body>

</html>
<?php
}
?>