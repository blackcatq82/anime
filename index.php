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
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<!--- start anime list --->
<div id="Title">
    <h4> كرتون مدبلجة ! </h4>
</div>
<!--- start search ajax --->
<div id="Context-plus">
    <div id="search-ajax">
            <div id="search-ajax-input">
                <input type="text"  class="inline" id="search-input-ajax" name="q" placeholder="البحث السريع!" />
            </div>
    </div>
    <div id="btns-search-ajax">
        <!--- form search by high views--->
        <button onclick="high_view();" class="btn btn-danger my-sm-0" title="الإعلى مشاهدة"  name="high_views" value="true" type="submit">
                <i id="high_view" class="fa fa-eye-slash" aria-hidden="true"></i>
        </button>
        <!--- form search by low views--->
        <button onclick="low_view();" class="btn btn-warning my-sm-0" title="الاقل مشاهدة"  name="low_views" value="true" type="submit">
                <i id="low_view" class="fa fa-eye-slash" aria-hidden="true"></i>
        </button>
        <!--- form search by A_z--->
        <button id="btn_az" onclick="A_z();" class="btn btn-dark my-sm-0" title="ترتيب الأبجدي"  name="A_z" value="true" type="submit">
            <i id="az" class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
        </button>
    </div>
</div>
<!--- end search ajax --->
<div id="Context">
    <div class="body-blocker">
        <div class="row justify-content-center" id="animelist">
<?php     

        // here we use plugin cards for show rows.
        // هنا نظهر العناصر او المسلسلات عن طريق البلجن
        $plugins->plugin['Cards']['instance']->GetCards(); 

?>
        </div>
    </div>
</div>
<!--- pagination pages --->
<div id="Title">
    <h4> الصفحات </h4>
</div>
<div id="Context" class="container">
  <div class="row col-12">
        <nav id="navg" aria-label="Page navigation example" style="width: 100%;">
              <ul class="pagination justify-content-center">
              <?php 
                  /* Use Plugin next pages. */
                  # أضافة متغير عددي لحصولنا على عدد صفحات 
                  $page = 1;

                  # التاكد من أنه لا يستخدم عدد من قبل.
                  if(isset($_GET['page']))
                  {
                    # أضافة العدد بشكل رقمي لي منع الاختراق الانجكشين
                    $page = (int)$_GET['page'];
                  }
                  # أستخدام بلجن البار الذي برمجنا من قبل.
                  $plugins->plugin['navpages']['instance']->navigation($page); 
                ?>
              </ul>
        </nav>
    </div>
</div>
<!--- end pagination pages --->
</main>
<?php 


/* Includes Ended */
include_once("Includes/footer.php");
include_once('Includes/end.php');


?>
</body>
</html>