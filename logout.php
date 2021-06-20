<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

    /* تغعيل السكشن من اجل الحصول على البيانات المطلوبه */
    # -- creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
    session_start();

    /* تدمير السكشن بشكل كامل */
    session_destroy();

    /* التخلص من السكشن و متغيراته بشكل كامل */
    session_abort();

    /* تحويل الى الرئيسية */
    header('location: index.php');
?>