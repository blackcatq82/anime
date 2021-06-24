<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022













# we needed to checking if guest use a title cartoon
# then we will start else we need to location to index
# we needed to includes same index do for keep everything as well.

# we need to import system plugin and tools.
include_once("IncludeAll.php");
include_once("Includes/start.php");

    # It's var we needed to set a count of items we will query in mysql data.
    $countItems = 0;
    # It's var for know if there data or not.
    $anime = null;
    # It's var for register a results founded in mysql data.
    $results = null;
    # It's const of limited items we will show in one page.
    $limited = 10;
    # It's varr type of int we will set a id items we will found it in database.
    $ItemId;

    # we want to know if we imported systems from file IncludeAll.php.
    if(!isset($dir_website))
    {
        # we can't use tools here 
        # bcuz this didn't import a file IncludeAll.php.
        # so we want to use header and move him to dir website
        header('location: ../index.php'); 
        # we needed to exit there for more protected.
        exit;
    }
    # we want to know if we imported systems from file IncludeAll.php.
    if(!isset($title_website))
    {
        # we can't use tools here 
        # bcuz this didn't import a file IncludeAll.php.
        # so we want to use header and move him to dir website
        header('location: ../index.php'); 
        # we needed to exit there for more protected.
    }

if(isset($_GET['title']))
{
    # we needed to take value and checking 
    # if on database title same the value.
    $Title = (string)$_GET['title'];

    # we needed to remove - on title first by tools we building.
    $Title = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($Title);

    # did we should build plugin for the? nope.
    global $conn;

    # we needed to make query for search on database.
    # we needed to find id on database for searching by int.
    $query = "SELECT * FROM anime WHERE Title = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $Title);
    $stmt->execute();

    # we needed to get results.
    $num = $stmt->get_result();

    # we needed to checking if we found rows.
    if($num->num_rows > 0)
    {
        $anime = $num->fetch_assoc();
        $Id = $anime['ID'];

        # we needed to found rows by id,
        # first build the query.
        $query = "SELECT * FROM `movies` WHERE NumberAnime = ? ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$Id);
        $stmt->execute();

        # we needed to checking if we found row or 0
        $num = $stmt->get_result();
        # we needed to fetch results.
        $result = $num->fetch_assoc();
        # set id item on varr.
        $ItemId =  $result['NumberAnime'];

        # check if we found items by id item.
        if($num->num_rows > 0)
        {
            # we need to take results for using as well.
            $countItems = $num->num_rows;

            # check if items count bigger then limited = 10
            # this mean we will add more pages every one page has 10 rows.
            if($countItems > $limited)
            {
                # check if hes didn't use get varr page this mean he goin to next page.
                if(!isset($_GET['page']))
                {
                    # we will set a query by page number and max rows.
                    $query = "SELECT * FROM `movies` WHERE NumberAnime = ? limit 0 , ?";
                    $stmt = $conn->prepare($query);
                    # we here set a bind param id item and limited rows in one page.
                    $stmt->bind_param('ss', $ItemId,    $limited);
                    # execute the query.
                    $stmt->execute();
                    # get results and set on while items.
                    $results = $stmt->get_result();
                }
                else
                {
                    # if number page = 1 this mean we need number row for checking
                    # if there rows on the number we needed to * by $limited = num rows 
                    # and we needed to check num rows is not bigger then countItems.;

                    # here we will try to get id page as int.
                    $page = (int)$_GET['page'];
                    # we will remove one from value we found.
                    $page = $page - 1;
                    # here we want to check if value smaller then 1 this mean 
                    # he didn't set page on next page hes on main item page.
                    # we should reset value to 0 mean this main page.
                    if($page < 1)
                    {
                        # Reset to 0
                        $page = 0;
                    }

                    # now we want to get calcuter page * limted 
                    # example if this page = 2 mean value we will return is 20
                    $num_rows = $page * $limited;

                    # if this bigger then countItems this mean he put a wrong value in method get.
                    if($num_rows > $countItems)
                    {
                        # this mean we didnt have more rows.
                        # we need to back to front page.
                        # this more safety.
                        header('location: ' . $dir_website . 'cartoon/' . $Title . '.html');
                        exit;
                    }

                    # now we will selected all rows by page value to found 10 rows.
                    $query = "SELECT * FROM `movies` WHERE NumberAnime = ? limit ? , ?";
                    $stmt = $conn->prepare($query);
                    # we here set bind the id item and num of rows 10 by 1 page, and limited rows in page = 10.
                    $stmt->bind_param('sss', $Id,   $num_rows,  $limited);
                    $stmt->execute();
                    $results = $stmt->get_result();

                }
            }
            # check if items count bigger then 0 mean we found items low then 10.
            elseif($countItems > 0)
            {
                    # now we will selected all rows by page value to found 10 rows.
                    $query = "SELECT * FROM `movies` WHERE NumberAnime = ? limit ? , ?";
                    $stmt = $conn->prepare($query);
                    # we here set bind the id item and num of rows 10 by 1 page, and limited rows in page = 10.
                    $stmt->bind_param('sss', $Id,   $num_rows,  $limited);
                    $stmt->execute();
                    $results = $stmt->get_result();
            }
        }
        else
        {
            # we needed to back to index.
            header('location: ../index.php');
            # use exit for keep website at safe side.
            exit;
        }


    }
    else
    {
            # we needed to back to index.
            header('location: ../index.php'); 
            # use exit for keep website at safe side.
            exit;
    }
}
else
{
            # we needed to back to index.
            header('location: ../index.php'); 
            # use exit for keep website at safe side.
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

<body>
<!--- start main --->
<main id="page">
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<div id="Title">
    <h4> معلومات عن الكرتون </h4>
    <?php

        # we use system guest live watch its page.
        $CountViewOnline = $plugins->plugin['online_views']['instance']->GetCountView($ItemId); 

        # check if there someone watching the same page.
        if($CountViewOnline > 0)
        {
            echo '<h5 style="font-size:12px;"> مشاهدين الان : <font style="font-size:12px; color:red;display:inline;">' . $CountViewOnline .'</font></h5>';
        }

        # we will use plugin online views here.
        # we set at last behinded becuz we didn't show him in numbers.
        # and keep it 0 when if just him watching it page.
        $plugins->plugin['online_views']['instance']->set_online($ItemId);

    ?>
</div>
<div id="Context" style="background:#161616;">
    <!--- name cartoon --->
    <h5 class="cartoon-pong title-cartoon">  <?php if(isset($Title)){echo $Title;}else{header('location: ../index.php');exit;}?> </h5>
        <div class="cartoon-pong-base con-cartoon">
            <!--- img --->
            <h5 class="cartoon-pong"> الصورة </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-img">
                    <img src = "<?php  echo $dir_website; ?>images/<?php if(isset($Title)){echo $Title;}else{header('location: ../index.php');exit;}?>.png" wdith="200px" height="200px"/>
                </div>
            </div>
            <!--- story --->
            <h5 class="cartoon-pong"> القصة </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-date">
                    <p id="story" style="background:#e22882;" >
                    <?php
                    
                    #check if we found item 
                     if(isset($anime))
                     {
                         # check if we has story table.
                         if(isset($anime['Story']))
                         {
                            # print story in html code.
                            echo $anime['Story']; 
                         }
                         else
                         {
                            # we needed to back to index.
                            # use method gotoMain for return him to main page.
                            $tools->tools['BaseTools']['instance']->gotoMain();
                            exit;
                         }
                     }
                     else
                     {
                        # we needed to back to index.
                        # use method gotoMain for return him to main page.
                        $tools->tools['BaseTools']['instance']->gotoMain();
                        exit;
                     }
                     ?></p>
                </div>
            </div>
            <!--- date --->
            <!--<h5 class="cartoon-pong"> التاريخ </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-date">
                    <span id="time">                    
                    <?php
                    # we didn't use it's for movement bcuz didn't has date register.
                     if(isset($anime))
                     {
                         # check if we has a time on database item
                         if(isset($anime['time']))
                         {
                            # print date timer
                            echo $anime['time']; 
                         }
                         else
                         {
                             # we adding a date.
                             echo '2018/2/2';
                         }
                     }
                     else
                     {
                        # we needed to back to index.
                        # use method gotoMain for return him to main page.
                        $tools->tools['BaseTools']['instance']->gotoMain();
                        exit;
                     }
                     ?></span>
                </div>
            </div>-->
            <!--- ep count --->
            <h5 class="cartoon-pong"> عدد الحلقات </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-eps-count">
                    <span id="count"><?php 
                    # check if we set a count item.
                    if(isset($countItems))
                    {
                        # print count in html code.
                        echo $countItems;
                    }
                    else
                    {
                        # use method gotoMain for return him to main page.
                        $tools->tools['BaseTools']['instance']->gotoMain();
                        exit;
                    } ?>
                    </span>
                </div>
            </div>
            <!--- tags
            <h5 class="cartoon-pong"> التاق </h5>
            <div class="cartoon-pong-base">
                <div class="cartoon-tags">
                    <span> action </span>
                </div>
            </div> ---->
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
        # here we will check if found data from items.
        if(isset($results) && $results != null)
        {  
            # While items and add in html code.
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
        else
        {
            #TODO: we needed to build system tell us about items didn't has eps
            # for more know about items didnt adding any eps on database.
            # keep website status in micro.
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

                        # Get as global plugin
                        global $plugins;

                        # check if has varr in get method name page.
                        if(isset($_GET['page']))
                        {
                            # set a value as int.
                            $page = (int)$_GET['page'];
                        }
                        else
                        {
                            # set a base value 1 becuz we started on 1 to limited items 1 by 10 rows.
                            $page = 1;
                        }

                        # Call method to building a nav bar with number page and count items.
                        $plugins->plugin['navpages']['instance']->navigation_view($page,    $countItems);

                ?>
              </ul>
        </nav>
    </div>
</div>
<!--- end pagination pages --->
</main>
    <?php 
        # Imported a footer and system end page.
        include_once("Includes/footer.php");
        include_once('Includes/end.php');
    ?>
</body>

</html>
</html>