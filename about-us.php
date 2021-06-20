<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("IncludeAll.php");

include_once('Includes/start.php');
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
<div id="Title">
    <h4> من نحن؟ </h4>
</div>
<div id="Context-About">
    <div class="body-blocker">
        <div class="row justify-content-center" id="terms">
            <div class="col-sm-12 col-lg-12">
                <div class="base-pinter">
                    <div class="About-us-Title">
                        <h5> بعض اهدافنا في صنع محتوى الموقع؟ </h5>
                    </div>
                    <div class="marks-point">
                        <ul class="marks-point-list">
                            <li class="marks-point-item"> الامتناع عن إضافة أي كرتون يخدش الحياة العام أو الاخلاقيات الاسلامية السليمة وإن وجد بشكل خاطىء أرجو من الجميع المساهمة بواسطة التبليغ الفوري له. </li>
                            <li class="marks-point-item"> الوصول لي أفضل جودة من حيث التصوير و الاتصال السريع. </li>
                            <li class="marks-point-item"> التحسين المستمر بأذن الله على الموقع و الوصول لي افضل تصميم العروض.</li>
                            <li class="marks-point-item">إستمرار في تقديم وتحسين جودة وإضافة الكرتوني حسب الطلب.</li>
                            <li class="marks-point-item"> تجنب وضع الاعلانات بتاتاً </li>
                        </ul>
                    </div>
                </div>
<!--
                <div class="BlackCatQ8">
                    <div class="BlackCatQ8-Title">
                        <h4> رسالة من أخوكم BlackCatQ8 </h4>
                    </div>
                    <div class="About-us-dec">
                        <p>
                        لقد فكرت في بناء هذا الموقع من اجل حبي للمسلسلات الكرتون القديمة والمدبلجة بوجهه أخص حيث اني عندما اشاهده اتذكر الماضي الجميل و له نكهة خاصة في ❤ لذا بدات في مشاهدة من بعض الموقع ولكن كان امر الإعلانات شي مزعج لي والسبب انه تقطع عني متعة المشاهدة و تعكر صفو الاثارة والتشويق فيه لي ذا فكرة في بناء موقع متواضع لبث أغلب المسلسلات الكرتوني القديمة و الحديث على حد سواء وهذا انا اكتب لكم وانا اكمل في تصميم الموقع وعمل افضل جودة للمشاهدين وأحاول ان اضيف لكم ما استطيع تصميم وبرمجته واتمنى لكم مشاهدة طيبة واذكروني من دعواتكم وشكرا لك يا من تقراء ❤
                        </p>
                    </div>
                </div>
-->
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