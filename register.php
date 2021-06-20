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
    exit; // أستخدام الاقزت في ajax مطلوب
}

# التاكد عدم دخول المسجلين هذي الصفحة بشكل عام.
else if(isset($_SESSION['username']))
{
    header('location: ' . $dir_website . 'index.php');
    exit;  // أستخدام الاقزت في ajax مطلوب
}

// التاكد من حصول على جميع البيانات المطلوب للتسجيل بالموقع
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['ajax']))
{
    // عمل متغير للاسم المستحدم
    $username = $_POST['username'];
    // عمل متغير لكلمة المرور
    $password = $_POST['password'];
    // عمل متغير للبريد
    $email = $_POST['email'];

    //  التاكد من ان البيانات ليس فارغة قبل التسجيل.
    if(!empty($username) && !empty($password) && !empty($email))
    {
        // أستخدام البلجن التسجيل
        $plugins->plugin['register']['instance']->registe($username,$email,$password);
    }
    else
    {
        echo 'danger=\'أدخل جميع البيانات المطلوبة.;';
        exit;// أستخدام الاقزت في ajax مطلوب
    }
}
else
{
    // عن التفاعل الفورم
    if(isset($_POST['submit']))
    {
        // التاكد من البيانات بشكل كامل
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['email']))
        {
            // التاكد من الموافقة على الشروط
            if(!isset($_POST['check']))
            {
                $error = '<div class="alert alert-danger" role="alert">
                يجب عليك الموافقة على الشروط والأحكام لقبول تسجيلك..
              </div>';
            }
            else
            {
                // التاكد من ان الشروط على وضع الموافقة
                if($_POST['check'] !== 'true')
                {
                    $error = '<div class="alert alert-danger" role="alert">
                    يجب عليك الموافقة على الشروط والأحكام لقبول تسجيلك..
                  </div>';
                }
                else
                {
                    // التاكد من ان البيانات ليست فارغة بشكل عام.
                    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['repassword']) || empty($_POST['email']))
                    {
                        $error = '<div class="alert alert-danger" role="alert">
                        ستكمل جميع الحقول من فضلك !!
                    </div>';
                    }
                    else
                    {   
                        // التاكد من ان كلمة المرور متطابقات.
                        if($_POST['password'] !== $_POST['repassword'])
                        {
                            $error = '<div class="alert alert-danger" role="alert">
                            كلمة المرور غير متطابقة؟
                        </div>';
                        }
                        else
                        {
                            // عمل متغير الاسم المستخدم
                            $username = $_POST['username'];
                            // عمل متغير كلمة المرور
                            $password = $_POST['password'];
                            // عمل متغير البريد
                            $email = $_POST['email'];
                            // استخدام بلجن التسجيل
                            $plugins->plugin['register']['instance']->registe($username,$email,$password, true);
                        }
                    }
                }
                
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
    <h4> سجل معنا </h4>
</div>
<div id="Context" class="container">
  <div class="row">
      <div class="col-3"></div>
        <form class="form col-6" method="post" action="register.html" autocomplete="off">
            <?php if(isset($error)){echo $error;} ?>
          <input class="form-control mr-sm-2" name="username" type="username" placeholder="الاسم المستخدم" aria-label="الاسم المستخدم">
          <input class="form-control mr-sm-2" name="email" type="email" placeholder="البريد الإلكتروني" aria-label="البريد الإلكتروني">
          <input class="form-control mr-sm-2" name="password" type="password" placeholder="كلمة المرور" aria-label="كلمة المرور">
          <input class="form-control mr-sm-2" name="repassword" type="password" placeholder="تأكيد كلمة المرور" aria-label="تأكيد كلمة المرور">
          <label class="form-check-label" style="display:inline;">
              الموافقة على <a href="terms-and-conditions.html"> الشروط والأحكام </a>
          </label>
          <input type="hidden" name="check" value="false"/>
          <input type="checkbox" name="check" value="true">
          <button class="btn btn-dark" type="submit" name="submit">سجل!</button>
        </form>
      <div class="col-3"></div>
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
<?php
}
?>