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

# check if we get method with values.
if(isset($_GET['q']) && isset($_GET['submit']) && !isset($_GET['Ajax']))
{
    if(isset($_GET['Ajax']))
    {
        #TODO: we needed to protect search ajax
        # with sha-1 key hash so we want to register one befor
        # he use search in database and remove the key if he move to next page
        # or if he searching and rebuild one on data base.
        # this imported to protect kids want to stopped website.
    }

    # check if he set submit value nullable.
    if(empty($_GET['submit']))
    {
        # return him to main base.
        header("Location: index.html");
    }

    # check if he change value submit.
    if($_GET['submit'] !== 'search')
    {
        # return him to main page.
        header("Location: index.html");
    }

    # check if he put a nullable value.
    if(!empty($_GET['q']))
    {
        # set a varr search with value.
        $search = $_GET['q'];
    }
    else
    {
        # return him to main page when he set nullabe value he didn't needed to searching.
        header("Location: index.html");
    }
}
else if (isset($_GET['q']) && isset($_GET['submit']) && isset($_GET['Ajax']))
{
    # check if he set submit value nullable.
    if(empty($_GET['submit']))
    {
        # return him to main base.
        exit;
    }

    # check if he change value submit.
    if($_GET['submit'] !== 'search')
    {
        # return him to main page.
        exit;
    }

    # check if he put a nullable value.
    if(!empty($_GET['q']))
    {
        # set a varr search with value.
        $search = $_GET['q'];

        # print results.
        $plugins->plugin['research']['instance']->ResearchByTitle($search);
        exit;
    }
    else
    {
        # return him to main page when he set nullabe value he didn't needed to searching.
        exit;
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
    <h4> النتائج البحث </h4>
</div>
<!--- end search ajax --->
<div id="Context">
    <div class="body-blocker">
        <div class="row justify-content-center" id="animelist">
<?php     

    #check if we get a some value for test's
    if(isset($search))
    {
        # Show results in html code.
        $plugins->plugin['research']['instance']->ResearchByTitle($search);
    }
?>
        </div>
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