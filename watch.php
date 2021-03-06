<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
# this page we need research about function and all it code we created.
# POWERD BY BLACKCAT 2021 - 2022

include_once("IncludeAll.php");
include_once("Includes/start.php");


/* هنا نصنع مجموعة من الاسماء الكلاسات من اجل ان نستخدمة في تغير شكل الازرار */
/* here we build a array for names classes for buttons or input style */
$random_Btn = [[0 => 'dark'],[1 => 'dark'],[2 => 'primary'],[3 => 'secondary'],[4 => 'success'],[5 => 'primary'],[6 => 'info'],[7 => 'light']];


/* here we has a array for rows videos from database */
/* هنا مجموعات من نتائج البحث من قاعدة البيانات */
$videos = array();


/* here we set id from database for a row anime */
/* هنا يتم وضع رقم الملف او المسلسل الذي هو مسجل بقاعدة البيانات */
$Id = null;


/* here we checking the page has title for row */
/* هنا نتاكد من أن الصفحة تحتوي على اسم المسلسل او الملف */
if(isset($_GET['title']))
{


    /* here we remove a char encod to use string as well for lang arabic */
    /* هنا نمسح بعض الاحرف الذي تعارض اللغة العربية من الرابط وناخذ الاسم الصحيح */
    $title = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($_GET['title']);
    $Title = $_GET['title'];



    /* set query for search a title on database. */
    $sql = "SELECT * FROM `episodes` WHERE Title = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $Title);

    /* if stmt execute this mean we has connection */
    if($stmt->execute())
    {


        /* here we set result from stmt to varrbale. */
        $result = $stmt->get_result();


        /* we checking if we found a rows on database */
        if($result->num_rows > 0)
        {

            /* here we fetch assoc a row anime to use as well. */
            $item = $result->fetch_assoc();


            /* here we set id anime from fetch row */
            $Id = $item['IdMovie'];


            /* here we set a anime id for all tables. */
            $IdAnime = $item['IdAnime'];


            /* we set query to founds a videos links by title id */
            $sql = "SELECT * FROM episodes WHERE NumberMovies = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $item['NumberMovies']);


            if($stmt->execute())
            {
                $result = $stmt->get_result();
                if($result->num_rows > 0)
                {
                    # while item and insert to array videos.
                    while($item = $result->fetch_assoc())
                    {
                        $videos[] = $item;
                    }


                    # Start to found if there more pages.
                    # 
                    # Get next row in mysql by ID col.
                    $IdNext =  (int)($Id + 1);


                    # Create query selected by ID.
                    $sql = "SELECT * FROM `Movies` WHERE ID = ? AND IdAnime = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $IdNext, $IdAnime);
                    $stmt->execute();


                    # Get results.
                    $results = $stmt->get_result();
                    $NextPageRow = $results->fetch_assoc();
                    # Check if we set var id anime.
                    if(isset($IdAnime))
                    {

                        # Check if there rows and isset id anime on them.
                        if($results->num_rows > 0 && isset($NextPageRow['IdAnime']))
                        {
                            # when id rows == anime id 
                            # this mean we has next eps and more page.
                            if($NextPageRow['IdAnime'] == $IdAnime)
                            {
                                # Set next page enable.
                                $nextPage = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($NextPageRow['Title']);
                            }

                        }

                    }

                    # Start to found if there more pages.
                    # 
                    # Get back row in mysql by ID col.
                    $id_next =  (int)($Id - 1);

                    # Create query selected by ID.
                    $sql = "SELECT * FROM `Movies` WHERE ID = ? AND IdAnime = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $IdNext, $IdAnime);
                    $stmt->execute();


                    # Get results.
                    $results = $stmt->get_result();
                    $BackPageRow = $results->fetch_assoc();
                    # Check if we set var id anime.
                    if(isset($IdAnime))
                    {
                        # Check if there rows and isset id anime on them.
                        if($results->num_rows > 0 && isset($BackPageRow['IdAnime']))
                        {
                            # when id rows == anime id 
                            # this mean we has next eps and more page.
                            if($BackPageRow['IdAnime'] == $IdAnime)
                            {
                                # Set back page enable.
                                $backPage = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($BackPageRow['Title']);
                            }
                        }
                    }

                        # TODO : Read writer the plugin.
                        # use system count view for insert a new row.
                        $pluginView = $plugins->plugin['views']['instance'];
                        $pluginView->SetView($_GET['title']);
                }
                else
                {
                    # Return to main page.
                    $tools->base->gotoMain();
                }
            }
            
        }
        else
        {
            # Return to main page.
            $tools->base->gotoMain();
        }
    }
}

# This Post a comment guest and users.
if(isset($_POST['submit']))
{
    # if there post a data username comment.
    if(isset($_POST['username-comment']))
    {
        # check if hes a users.
        if(isset($_POST['id']))
        {
            # if there post a data comment text.
            if(isset($_POST['comment']))
            {

                # Check the values didn't send empty.
                if(!empty($_POST['id']) && !empty($_POST['comment']) && !empty($_POST['username-comment']))
                {

                    # Get a sender ip address.
                    $ip_address = $tools->tool['BaseTools']['instance']->get_ip();

                    # check if he didn't users set name input.
                    if(!isset($_SESSION['username']))
                    {
                        $name = $_POST['username-comment'];
                    }
                    else
                    {
                        $name = $_SESSION['username'];
                    }

                    # Take comment as text.
                    $comment = (string)$_POST['comment'];

                    # Take video id
                    $video_id = (int)$_POST['id'];

                    # Set status false for more controls 
                    $done = false;

                    # Set date now as format 1994-1-27 01:32:21
                    $time = date ('Y-m-d H:i:s', time());

                    # Check if there rows in table has same values.
                    $sql = "SELECT * FROM `comment` WHERE name = ? AND comment = ? AND video_id = ? ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sss', $name, $comment, $video_id);
                    $stmt->execute();
                    $results = $stmt->get_result();

                    # Check if there rows mean he send before and we didn't needed more then comment in one video.
                    if($results->num_rows > 0)
                    {
                        $error = '<div class="alert alert-warning" role="alert">
                        نعتذر منك تم قبول تعليقك ولا يمكنك ان تعلق نفس نص التعليق مرتين وشكراً
                       </div>';
                    }
                    else
                    {
                        # Set Sql insert a new row.
                        $sql = "INSERT INTO `comment`(`name`, `comment`, `ipaddress`, `done`, `time`, `video_id`) VALUES ( ? , ? , ? , ? , ? , ? )";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('ssssss', $name,  $comment,   $ip_address,    $done,  $time,  $video_id);

                        # invoke execute method if done send message success else send message danger or error. 
                        if($stmt->execute())
                        {
                            $error = '<div class="alert alert-success" role="alert">
                            تمت إضافة تعليقكم بنجاح شكراً لكم...
                           </div>';
                        }
                        else
                        {
                            $error = '<div class="alert alert-danger" role="alert">
                            هناك خطاء ما حدث يرجاء المحاولة مره اخر او التواصل مع الادارة.
                           </div>';
                        }
                    }
                }
                else
                {
                    $error = '<div class="alert alert-danger" role="alert">
                   من فضلك سجل جميع البيانات الصحيحة.
                  </div>';
                }
            }
            else
            {
                $error = '<div class="alert alert-danger" role="alert">
               من فضلك ضع نص التعليق في صندوق التعليق.
              </div>';
            }
        }
        else
        {
            $error = '<div class="alert alert-danger" role="alert">
           هناك خطاء برقم الصفحة يرجاء مراجعة الادارة لحل المشكلة.
          </div>';
        }
    }
    else
    {
        $error = '<div class="alert alert-danger" role="alert">
        أرجو أدخل الاسم المراد التعليق به.
      </div>';
    }
}
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

</button>
<main id="page">
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<script>
function resrc_iframe($url)
{
    var iframe = document.getElementById('iframe_videos');
    iframe.src = $url;
    console.log(iframe.src);
}
</script>
    <div id="Title">
        <h4> <?php if(isset($title)){ echo $title; }?> </h4>
    </div>
    <div id="Context">
        <div class="body-blocker">
            <div class="row justify-content-center" id="animelist">
                <div class="row video" style="display: contents;">
                <div class="col-12"> 
                    <div class="alert alert-success hide-class" role="alert" id="report-message-info">
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-danger" style="font-size:9px; margin:4px;" onclick="report('<?php if(isset($id)){echo $id;}else{echo 'null';}?>','<?php if(isset($dir_website)){echo $dir_website.'report.html';}else{echo 'null';}?>');"> تبليغ </button>
                     <button type="submit" class="btn btn-sm btn-warning" style="font-size:9px; margin:4px;" onclick="expirelinks('<?php if(isset($id)){echo $id;}else{echo 'null';}?>','<?php if(isset($dir_website)){echo $dir_website.'expirelinks.html';}else{echo 'null';}?>');"> الرابط لا يعمل </button>
                        <div class="col-12" style="padding:20px;">
                            <?php 

                                # Set a base started link.
                                $linkStarted = '';

                                # insert a count links.
                                $count = 1;
                                # foreach a link videos.
                                foreach($videos as $video)
                                {
                                    # Set Anylink in started.
                                    $linkStarted = $video['Link'];

                                    # Missed a value link for handl
                                    # information contains : https://www.php.net/manual/en/function.str-contains.php
                                    if(isset($video['Link']) && $video != null && $video['Link'] != null 
                                                             && strlen($video['Link']) > 12)
                                    {
                                        if (!function_exists('str_contains')) 
                                        {
                                            function str_contains(string $haystack, string $needle): bool
                                            {
                                                return '' === $needle || false !== strpos($haystack, $needle);
                                            }

                                            if(str_contains($video['Link'], 'arteenz'))
                                            {
                                                // skipped danger links.
                                                # we should remove item from database.
                                                continue;
                                            }
                                        }
                                        else
                                        {
                                            if(str_contains($video['Link'], 'arteenz'))
                                            {
                                                // skipped danger links.
                                                # we should remove item from database.
                                                continue;
                                            }
                                        }
                                    }


                                    # we ues $random for get a random number between 0 - 7
                                    $random = rand(0,7);

                                    # take a style btn in array by random index number.
                                    $btn = (string)implode($random_Btn[$random]);
                                    echo '<button type="submit" class="btn btn-xl btn-' . (string)$btn . '" style="font-size:9px padding:10px;"
                                    value="' . $video['Link'] . '"
                                    onclick="Play_Iframe(\'' . $video['Link'] . '\');"
                                    > Server-' . $count. ' </button>';
                                    $count++;
                                }

                            ?>
                        </div>
                    <div class="col-2"></div>
                      <div class="col-8 embed-responsive embed-responsive-16by9  test-iframe-base" id="baseVideo">
                          <iframe
                                             class="embed-responsive-item" 
                                             id = "iframe_videos"
                                             src="<?php echo $linkStarted; ?>" 
                                             frameborder="0" allowfullscreen="true">
                          </iframe>
                          <!-- 
                            When we download all anime we can use it best video base.
                          <video class="embed-responsive-item"  id ="iframe_videos" height="100%" weight="100%" controls>
                            <source src="/anime/video/0.mp4">
                          </video>
                          -->
                      </div>
                    <div class="col-2"></div>
                     <div class="col-4 col-sm-4 col-md-2 co-lg-2 col-xl-2">
                     <?php 
                                # Check if isset varrable $backPage mean we found eps (-) ID has same number anime.
                                if(isset($backPage))
                                {
                                    echo '<li type="button" class="page-item" style="margin-bottom:20px;">';
                                    echo '<a class="page-link" style="font-size:9px;" href="' . $dir_website .'view/'. $backPage . '.html">السابق</a>';
                                }
                                else
                                {
                                    echo '<li type="button" class="page-item disabled" style="margin-bottom:20px;">';
                                    echo '<a class="page-link" style="font-size:9px;" href="#">السابق</a>';

                                }
                     ?>
                        </li>
                    </div>
                    <div class="col-4 col-sm-4 col-md-8 co-lg-8 col-xl-8"></div>
                    <div class="col-4 col-sm-4 col-md-2 co-lg-2 col-xl-2">
                          <?php 

                          # Check if isset varrable $nextPage mean we found eps (+) ID has same number anime.
                          if(isset($nextPage))
                          {
                            echo '<li type="button" class="page-item" style="margin-bottom:20px;">';
                            echo '<a class="page-link" style="font-size:9px;" href="' . $dir_website .'view/'. $nextPage . '.html">التالي</a>';
                          }
                          else
                          {
                            echo '<li type="button" class="page-item disabled" style="margin-bottom:20px;">';
                            echo '<a class="page-link" style="font-size:9px;" href="#">التالي</a>';

                          }
                          ?>
                        </li>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 id="Title"> تعليقاتكم <a style="color:red;">❤</a> </h4>
            <div id="Comm" style="border:0px;background: #e5c4d6;margin-top: -8px;">
                <div class="row">
<?php 
                        
                          # We started to found any comments in this video to insert to the box comments.
                          $sql = "SELECT * FROM `comment` WHERE video_id = ?";
                          $stmt = $conn->prepare($sql);
                          $stmt->bind_param('s', $Id);


                          # Execute or invoke query.
                          if($stmt->execute())
                          {
                              $results = $stmt->get_result();

                              # check if the found rows.
                              if($results->num_rows > 0)
                              {
                                  # while the rows in html code.
                                  while($row = $results->fetch_assoc())
                                  {
                                    echo '<div class="col-12" style="padding: 10px;margin-top:10px;margin-right:auto;margin-left:auto;background: white;border: 1px solid;">
                                    <div class="col-12 user-comment">
                                        <strong> ' . $row['name'] . ' </strong>
                                    </div>
                                    <div class="comment-date">
                                        <span style="
                                        width: 100%;
                                    " class="date">' . $row['time'] . '</span>
                                    </div>
                                    <div class="col-12 card-comment">
                                        <p> ' . $row['comment'] . ' </p>
                                    </div>
                                </div>';
                                  }
                              }
                          }
?>
                </div>
            </div>
        <h4 id="Title"> إضافة تعليق </h4>
        <div id="Comm" style="border:0px;background: white;margin-top: -8px;">
        <?php if(isset($error)){echo $error;} ?>
            <form action="" method="POST" class="add-comment" style="    display: grid;">
                <input type="hidden" name="id" value="<?php if(isset($Id)){echo $Id;} ?>">
                <input style="margin:5px;width:100%;" name="username-comment" <?php
                
                # Check if client has session username.
                # if he has we will hidden input username.
                if(isset($_SESSION['username']))
                {
                    $username = $_SESSION['username']; 
                    echo 'type="hidden"';
                    echo 'value="'.$username.'"'; 
                }
                else
                {
                    echo 'type="text"';
                    echo 'placeholder="أدخل الاسم"';
                }
                ?> />
                <textarea style="margin:5px; width:100%; height:140px;" name="comment"> </textarea>
                <button type="submit" class="btn btn-dark" name="submit"> أضف تعليقك ! </button>
            </form>
        </div>
    </div>
</main>
<?php 
include_once("Includes/footer.php");
include_once('Includes/end.php');
?>
</body>
</html>