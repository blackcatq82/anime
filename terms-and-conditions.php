<?php
include_once("IncludeAll.php");
include_once('Includes/start.php');

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
<body>
<main id="page">
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<div id="Title">
    <h4> الشروط والأحكام </h4>
</div>
<div id="Context">
    <div class="body-blocker">
        <div class="row justify-content-center" id="terms">
            <div class="col-sm-12 col-lg-12">
                <div  id="Title-terms" >
                    <h5 style="text-align:center;"> تنطبق هذه الشروط والأحكام على استخدامك للموقع الإلكتروني. </h5>
                    <h4> باستخدام موقع فأنت توافق على الالتزام بهذه الشروط والأحكام. وفي حال عدم موافقتك على الشروط والأحكام يتعين عليك عدم استخدام الموقع. </h4>
                    <ul id="marks-terms">
                        <li id="marks-terms-item">*  يوفر لك الموقع حرية الرأي فأنت وحدك المسؤول عن رأيك وقراراتك التي تتخذها داخل الموقع ولا يجبرك الموقع بأي شكلٍ كان على تغيير رأيك او فرض رأي فئة معينة عليك </li>
                        <li id="marks-terms-item"> *  يوفر الموقع امكانية التعليق على التدوينات للجميع ولكن يحق لنا ان نمسح أي تعليق ضارًا، غير مشروع، تشهيري، مخالف، مسيء، محرض، قذر، مضايق أو ما شابه ذلك. أنت وحدك المسؤول عن التعليقات التي تشارك بها. </li>
                        <li id="marks-terms-item"> * حقوق الملكية الفكرية للتعليقات مسجلة لك أنت وحدك , ولكن يحق لنا اعادة استخدام التعليق في اي نشاط متعلق بالموقع دون الرجوع لصاحبه بشرط أن يتم ذكر اسم صاحب التعليق وعدم التغيير او التلاعب محتوي التعليق بأي شكلٍ كان. </li>
                        <li id="marks-terms-item"> * تقوم المدونة بجمع بعض البيانات الخاصة بك، مثل نوع المتصفح، نظام التشغيل، رقم IP… . الهدف من جمع هذه البيانات هو تحسين مستوى الخدمة فقط وتقديم بيانات دقيقة ولا نقوم ببيع او اعادة استخدام هذه البيانات الا في حالة عدم قيامنا بالربط بين هذه البيانات وهويتك الشخصية. </li>
                        <li id="marks-terms-item"> * لا نتعمد ابداً حرق الأحداث على متابعين الأنمي وانما نضع دائماً  تحذير اذا حرقت الأحداث عليك بعد ضغطك على التحذير فلسنا مسؤولين عن ذلك. </li>
                    </ul>
                    <h5 id="Title-terms" style="text-align:center;"> اخلاء مسؤولية  </h5>
                     <ul id="marks-terms">
                         <li id="marks-terms-item"> * نشر إعلانات المنتجات أو الخدمات والروابط الدعائية لا يعني تزكيتي لها، ولا أقدم أي ضمانات جودة بخصوصها.</li>
                         <li id="marks-terms-item"> * نعرض تحميل لبعض الأنميات والتي قد لا يكون بعضها مناسب لجميع الفئات العمرية ولكن دائماً ما نقوم بذكر الفئة العمرية المناسبة لمشاهدة الأنمي وانصحكم بالالتزام بالأعمار فهذا افضل بالنسبة لكم ولكننا غير مسؤولين تماماً عن عدم التزامك بالتصنيف العمري.</li>
                    </ul>
                    
                    <h5 class = "message-p"> إن وجد خلاف على هذي الاحكام يرجاء التواصل معنا مع كامل الاحترام والمحبه لكم❤ </h5>
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