<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

error_reporting(E_ALL);
ini_set("display_errors", 1);
function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}
$web_site = siteURL();
$dir_website = $web_site . "anime/";
$title_website = "كرتون مدبلج بالعربي";



function __autoload($className)
{
    foreach (glob("db/*.php") as $filename)
    {
        if (strpos($filename, '.php') !== false)
        {
            include_once $filename;
        }
    }
    foreach (glob("Plugins/*.php") as $filename)
    {
        if (strpos($filename, '.php') !== false)
        {
            include_once $filename;
        }
    }
    foreach (glob("Tools/*.php") as $filename)
    {
        if (strpos($filename, '.php') !== false)
        {
            include_once $filename;
        }
    }
}
/// we building database connection as well.
/* سيتم إستخدام الاتصال بالقاعدة من هذا المتغير */
$conn  = new db();
$conn = $conn->Connect();

/// we building stage tools as well.
/* سيتم أستخدام الاوامر المساعدة من هذا المتغير */
$tools = new BUILDERTOOLS();
$tools->Running();

/// we building Plugins as well.
$plugins = new BUILDERPLUGINS();
$plugins->Running();
?>