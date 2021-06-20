<?php
# we needed to checking if guest use a title cartoon
# then we will start else we need to location to index
# we needed to includes same index do for keep everything as well.

include_once("IncludeAll.php");
include_once("Includes/start.php");
$count_eps = 0;
$anime = null;
$results = null;
$limited = 10;
$animeid;
if(isset($dir_website)){}else{header('location: ../index.php'); exit;}
if(isset($title_website)){}else{header('location: ../index.php'); exit;}

if(isset($_GET['title']))
{
    # we needed to take value and checking 
    # if on database title same the value.
    $title = (string)$_GET['title'];
    # we needed to remove - on title first by tools we building.
    $title = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($title);
    # did we should build plugin for the? nope.
    global $conn;
    # we needed to make query for search on database.
    # we needed to find id on database for searching by int.

    $query = "SELECT * FROM anime WHERE Title = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $title);
    $stmt->execute();
    # we needed to get results.
    $num = $stmt->get_result();
    # we needed to checking if we found rows.
    if($num->num_rows > 0)
    {
        $anime = $num->fetch_assoc();
        $id = $anime['ID'];
        # we needed to found rows by id,
        # first build the query.
        $query = "SELECT * FROM `movies` WHERE NumberAnime = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();

        # we needed to checking if we found row or 0
        $num = $stmt->get_result();
        $animeid = $num->fetch_assoc();
        $animeid =  $animeid['ID'];
        if($num->num_rows > 0)
        {
            # we need to take results for using as well.
            $count_eps = $num->num_rows;
            if($count_eps > $limited)
            {
                if(!isset($_GET['page']))
                {
                    $query = "SELECT * FROM `movies` WHERE NumberAnime = ? limit 0 , 10";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('s', $id);
                    $stmt->execute();
                    $results = $stmt->get_result();
                }
                else
                {
                    # if number page = 1 this mean we need number row for checking
                    # if there rows on the number we needed to * by $limited = num rows 
                    # and we needed to check num rows is not bigger then count_eps.;
                    $page = (int)$_GET['page'];
                    $page = $page - 1;
                    if($page < 1)
                    {
                        $page = 0;
                    }
                    $num_rows = $page * $limited;
                    if($num_rows > $count_eps)
                    {
                        # this mean we didnt have more rows.
                        # we need to back to front page.
                        # this more safety.
                        //header('location: ' . $dir_website . 'cartoon/' . $title . '.html');
                        exit;
                    }

                    $query = "SELECT * FROM `movies` WHERE NumberAnime = ? limit ? , 10";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ss', $id, $num_rows);
                    $stmt->execute();
                    $results = $stmt->get_result();
                }
            }
            # $results = $num;
            //now we done.
        }
        else
        {
            # we needed to back to index.
            header('location: ' . $dir_website . 'index.php');
            exit;
        }


    }
    else
    {
        # we needed to back index.
        header('location: ' . $dir_website . 'index.php');
        exit;
    }
}
else
{
    header('location: ' . $dir_website . 'index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

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

<body><!--- start main --->
<main id="page">
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<div id="Title">
    <h4> معلومات عن الكرتون </h4>
    <?php

        $count_view_online = $plugins->plugin['online_views']['instance']->GetCountView($animeid); 
        if($count_view_online > 0)
        {
            echo '<h5 style="font-size:12px;"> مشاهدين له الان : <font style="font-size:12px; color:red;display:inline;">' . $count_view_online .'</font></h5>';
        }
        # we will use plugin online views here.
        $plugins->plugin['online_views']['instance']->set_online($animeid);
    ?>
</div>
<div id="Context" style="background:#161616;">
    <!--- name cartoon --->
    <h5 class="cartoon-pong title-cartoon">  <?php if(isset($title)){echo $title;}else{header('location: ../index.php');exit;}?> </h5>
        <div class="cartoon-pong-base con-cartoon">
            <!--- img --->
            <h5 class="cartoon-pong"> الصورة </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-img">
                    <img src = "<?php  echo $dir_website; ?>images/<?php if(isset($title)){echo $title;}else{header('location: ../index.php');exit;}?>.png" wdith="200px" height="200px"/>
                </div>
            </div>
            <!--- story --->
            <h5 class="cartoon-pong"> القصة </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-date">
                    <p id="story" style="background:#e22882;" >
                    <?php
                     if(isset($anime))
                     {
                         if(isset($anime['Story']))
                         {
                            echo $anime['Story']; 
                         }
                         else
                         {
                             header('location: ../index.php');
                             exit;
                         }
                     }
                     else
                     {
                        header('location: ../index.php');
                        exit;
                     }
                     ?></p>
                </div>
            </div>
            <!--- date --->
            <h5 class="cartoon-pong"> التاريخ </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-date">
                    <span id="time">                    <?php
                     if(isset($anime))
                     {
                         if(isset($anime['time']))
                         {
                            echo $anime['time']; 
                         }
                         else
                         {
                             echo '2018/2/2';
                         }
                     }
                     else
                     {
                        header('location: ../index.php');
                        exit;
                     }
                     ?></span>
                </div>
            </div>
            <!--- ep count --->
            <h5 class="cartoon-pong"> عدد الحلقات </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-eps-count">
                    <span id="count"><?php if(isset($count_eps)){echo $count_eps;} else {header('location: ../index.php');exit;} ?></span>
                </div>
            </div>
            <!--- tags ---->
            <h5 class="cartoon-pong"> التاق </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-tags">
                    <span> action </span>
                </div>
            </div>
    </div>
</div>
<!--- start anime list --->
<div id="Title">
    <h4> الحلقات </h4>
</div>
<div id="Context">
    <div class="body-blocker">
        <div class="row justify-content-center" id="animelist">
<?php 

        /* fetch rows and make cards while */
        if(isset($results) && $results != null)
        {
            while($row = $results->fetch_assoc())
            {
                // set sotry  with low words use method tools.
                $Story = $tools->tool['BaseTools']['instance']->SmallContext($anime['Story']);
                // set Title without chars.
                $Title = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($row['Title']);
                // set link title with chars.
                $Link = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($row['Title']);
                // Get Path Image by title anime.
                $PathImage = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($anime['Title']);
                // get count views watch the anime before NOT LIVE.
                $CountViews = $tools->tool['BaseTools']['instance']->GetepsViewCount($row['ID']);
                echo
                '
                <!--- card basic --->
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="flip-card">
                        <h4 class="card-title-anime">' . $Title . '</h4>
                        <div class="flip-card-inner">                      
                            <!--- front --->
                            <div class="flip-card-front" style="
                                                                    background: url(' . $dir_website . 'images/' . $PathImage . '.png);
                                                                    background-position: center;
                                                                    background-size: 300px 300px;
                                                                    height: 300px;">               
                                <div class="icon">
                                    <a class="btn-watch" href="' . $dir_website . 'view/' . $Link . '.html">  مشاهدة  
                                        <i class="fa fa-play" aria-hidden="true"> </i>
                                    </a>
                                </div>
                            </div>
                            <!--- back side --->
                            <div class="flip-card-back" style="background:url(' . $dir_website . 'images/' . $PathImage . '.png);background-position: center;background-size: 300px 300px;    height: 300px;">
                                <div class="dec">
                                    <p class="story ps"> ' . $Story . ' </p>
                                </div>
                                <div class="icon">
                                    <a class="btn-watch backside-btn" href="' . $dir_website . 'view/' . $Link . '.html">  مشاهدة  
                                        <i class="fa fa-play" aria-hidden="true"> </i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- end card --->
                ';
            }
        }

?>
        </div>
    </div>
</div>
<!--- end anime list --->

<!--- pagination pages --->
<div id="Title">
    <h4> الصفحات </h4>
</div>
<div id="Context" class="container">
  <div class="row col-12">
        <nav id="navg" aria-label="Page navigation example" style="width: 100%;">
              <ul class="pagination justify-content-center">
<?php 

global $plugins;
if(isset($_GET['page']))
{
    $page = (int)$_GET['page'];
}
else
{
    $page = 1;
}

    $plugins->plugin['navpages']['instance']->navigation_view($page,$count_eps);

?>
              </ul>
        </nav>
    </div>
</div>
<!--- end pagination pages --->
</main>
<?php include_once("Includes/footer.php");
include_once('Includes/end.php');
?>
</body>

</html>
</html>