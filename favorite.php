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
/* التاكد من حصول على المتغيرات المطلوب من بوست وليس قيت لماذا؟ */
# ببساطه ال POST هو الافضل في جدول الطلبات وذلك منع تكرار الطلب بشكل يحمل الموقع عبى الطلب
# وهي الاكثر اماناً بالنسبه لنقل البيانات بشكل بسيط
# Get يستخدم فقط في الانتقالات بين الصفحات وليس للطلب البيانات او إرسالة. 
# More information : https://www.w3schools.com/tags/ref_httpmethods.asp
if(isset($_POST['Title']) && isset($_SESSION['username']) && isset($_POST['ajax']))
{
    #Get Title Anime and set in var.
    $Title = $_POST['Title'];
    $Ajax = $_POST['ajax'];

    # this mean there someone didn't use ajax system
    if($Ajax === 'false')
    {
        return;
    }

    # this mean title length not bigger then 1 char.
    if($Title === '')
    {
        return;
    }

    # Executed or adding to list.
    $fv = $plugins->plugin['favorite']['instance'];

    # SetAsfavorite
    $fv->SetAsfavorite($Title);

    # we can send something there.
}
?>

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


# this page for register users.
if(!isset($_SESSION['username']))
{
    $tools->tool['BaseTools']['instance']->GoTo();
}


# we will use plugin online views here.
# هذا الامر من اجل تسجيل المشاهدين المتصلين الان في نفس الصفحة.
$plugins->plugin['online_views']['instance']->set_online('home');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $title_website; ?></title>
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Markazi+Text">
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php  echo $dir_website; ?>assets/css/styles.min.css">
</head>
<script>
</script>

<body>
<!--- start main --->
<main id="page">
<?php /* include all cuts */ ?>
<?php /* أستدعاء تقسيمات الملفات */ ?>
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<!--- start anime list --->
<div id="Title">
    <h4> قائمة المفضلة <img src="themes/img/fv_yes.png">!</h4>
</div>

<div id="Context">
    <div class="body-blocker">
        <div class="row justify-content-center" id="animelist">
<?php     
    # we use method get cards fv.
    $plugins->plugin['favorite']['instance']->GetCards(); 

?>
        </div>
    </div>
</div>
<?php
 if(isset($morefv))
 {
    echo '<!--- pagination pages --->
    <div id="Title">
        <h4> الصفحات </h4>
    </div>
    <div id="Context" class="container">
      <div class="row col-12">
            <nav id="navg" aria-label="Page navigation example" style="width: 100%;">
                  <ul class="pagination justify-content-center">';
                  /*
                     #Use Plugin next pages.
                      # أضافة متغير عددي لحصولنا على عدد صفحات 
                      $page = 1;
    
                      # التاكد من أنه لا يستخدم عدد من قبل.
                      if(isset($_GET['page']))
                      {
                        # أضافة العدد بشكل رقمي لي منع الاختراق الانجكشين
                        $page = (int)$_GET['page'];
                      }
                      # أستخدام بلجن البار الذي برمجنا من قبل.
                      $plugins->plugin['favorite']['instance']->navigation($page); 
    
                  */
                  echo'</ul>
            </nav>
        </div>
    </div>
    <!--- end pagination pages --->';
 }
?>
</main>
<?php 


/* Includes Ended */
include_once("Includes/footer.php");
include_once('Includes/end.php');


?>
</body>
</html>