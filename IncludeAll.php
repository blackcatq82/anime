<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

// show php error in page for understand what happend.
// Report all PHP errors
// more exp : https://www.php.net/manual/en/function.error-reporting.php
error_reporting(E_ALL);
// this set display. ini_set("display_errors", 1);

// set the default timezone to use.
date_default_timezone_set('UTC');

function GetSiteUrl()
{                   
    // this oper if website use protocol ssl set https else set http
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    // get a domain name
    $domainName = $_SERVER['HTTP_HOST'].'/';
    //return porotocol and domain.
    return $protocol.$domainName;
}
$web_site = GetSiteUrl();
// just use it from more easy if we change folder name.
$dir_website = $web_site . "anime/";
// use var title website more easy for change name website.
$title_website = "كرتون مدبلج بالعربي";



// Date Build the website use for sitemap main pages.
$dayBuilder = "2021-6-20";
$tomorrow  = date('Y-m-d', strtotime("" . date("Y-m-d") . "-24 HOUR"));

// autoload this method for load undefined class
// more information : https://www.php.net/manual/en/function.autoload.php
function __autoload($className)
{
    // load database files.
    foreach (glob("db/*.php") as $filename)
    {
        if (strpos($filename, '.php') !== false)
        {
            include_once $filename;
        }
    }
    // load plugin files.
    foreach (glob("Plugins/*.php") as $filename)
    {
        if (strpos($filename, '.php') !== false)
        {
            include_once $filename;
        }
    }
    // load tools files.
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