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
if(isset($_POST['ordername']) && isset($_POST['orderemail']))
{  

    // وضع القيمة في متغير
    $nameOrder = $_POST['ordername'];
    // وضع القيمة في متغير
    $emailOrder = $_POST['orderemail'];

    // التاكد من انه ليست فارغة.
    if(!empty($nameOrder) && !empty($emailOrder))
    {
        // أستخدام بلجن صنع الطلب.
        $plugins->plugin['order']['instance']->create_order($nameOrder, $emailOrder);
    }
    else
    {
        // ارسال رسالة ان البيانات ليست كامله
        echo 'danger=\'أدخل جميع البيانات المطلوبة.;';
    }

    
}

/* Include Ended */
include_once("Includes/end.php");