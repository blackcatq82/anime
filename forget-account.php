<?php


#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("IncludeAll.php");
include_once("Includes/start.php");

if(isset($_SESSION['username']))
{
    header("location: " . $dir_website . "index.php");
}

$userid = null;
if(isset($_POST['submit']))
{
    if(isset($_POST['email']))
    {
        $email = (string)$_POST['email'];
        #we needed to search in users where email as it email.
        $query = "SELECT * FROM `users` WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $results = $stmt->get_result();

        if($results->num_rows > 0)
        {
            $key = "8*oX-_¬¬!";
            #we need to building a random hash md5.
            $random = rand(0,999999999);
            $random = md5($random . $key);
            #we need a information about account.
            $row = $results->fetch_assoc();
            $email = $row['email'];
            $username = $row['username'];
            $time = $row['time_register'];
            $id = $row['ID'];
            $done = false;
            $hash_link = $dir_website . 'forget-account.html?hash=' . $random;
            #we need to destory all old hash here.
            $query = "DELETE FROM `forget_password` WHERE userid = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$id);
            $stmt->execute();
            #we need building a hash on database.
            $query = "INSERT INTO `forget_password`(`userid`, `hash`, `done`) VALUES ( ? , ? , ? )";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $id, $random,$done);
            if($stmt->execute())
            {
                #we need to building a message email with hash.
                $title = "تغير كلمة المرور لحسابك لدى موقعك كرتون مدبلج";
                $body = $template = file_get_contents("template/forget-account.html");

                $body = str_replace('[user]', $username ,$body);
                $body = str_replace('[link]',$hash_link ,$body);
                $body = str_replace('[date]',$time ,$body);
                $plugins->plugin['email']['instance']->sendto($email,$title,$body);

                #send message is done.
                $error = '<div class="alert alert-success" role="alert">
                تم ارسال رسالة الى بريدك الالكتروني يمكنك تغير كلمة المرور بها.
              </div>';
            }
            else
            {
                #send message we got error.
                $error = '<div class="alert alert-danger" role="alert">
                هناك خطاء ما حصل يرجاء المحاولة لاحقاً او التواصل مع إدارة الموقع.
              </div>';
            }
        }
        else
        {
            #send message we didn't found email or account
            $error = '<div class="alert alert-danger" role="alert">
            لم يجد النظام البريد الالكتروني مسجلاً لدينا يرجاء التاكد من البريد او مراجعة الادارة.
          </div>';
        }
    }
}
if(isset($_GET['hash'])  || isset($_POST['hash']))
{
    if(isset($_POST['hash']))
    {
        $hash = $_POST['hash'];
    }
    else
    {
        $hash = $_GET['hash'];
    }
    #here we will create a form for new password and update account.
    $query = "SELECT * FROM `forget_password` WHERE hash = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s',$hash);
    $stmt->execute();
    $results = $stmt->get_result();
    if($results->num_rows > 0)
    {
        $row = $results->fetch_assoc();
        $userid = $row['userid'];
    }
    else
    {
        $_GET['hash'] = null;
        $error = '<div class="alert alert-danger" role="alert">
        الرابط غير صالح!!
        </div>';
    }
}
if(isset($_POST['hash']) && isset($_POST['submit']))
{
    if(!empty($_POST['hash']))
    {
        if(isset($userid))
        {
            if(isset($_POST['password']) && isset($_POST['re-password']))
            {
                if(!empty($_POST['password']) && !empty($_POST['re-password']))
                {
                    if($_POST['password'] == $_POST['re-password'])
                    {
                        $password = md5($_POST['password']);

                        $query = "SELECT * FROM `users` WHERE ID = ? ";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('s',$userid);
                        if($stmt->execute())
                        {
                            $results = $stmt->get_result();
                            if($results->num_rows > 0)
                            {
                                $query = "UPDATE `users` SET `password`= ? WHERE ID = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('ss',$password,$userid);
                                if($stmt->execute())
                                {
                                    $query = "DELETE FROM `forget_password` WHERE userid = ?";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param('s',$userid);
                                    if($stmt->execute())
                                    {

                                        $error = '<div class="alert alert-success" role="alert">
                                        تم اعادة تعين كلمة المرور بنجاح.. سيتم تحويل لصفحة الدخول
                                        </div>
                                        <meta http-equiv="refresh" content="5; URL=' . $dir_website . 'login.html">
                                        ';
                                    }
                                }
                            }
                            else
                            {
                                $error = '<div class="alert alert-danger" role="alert">
                                يبدو ان انتهت صلاحية الرابط بالرجاء المحاولة مرة اخر او التواصل مع الادارة
                                </div>';
                            }
                        }
                    }
                    else
                    {
                        $error = '<div class="alert alert-danger" role="alert">
                        كلمة المرور غير متطابقة...
                        </div>';
                    }
                }
                else
                {
                    $error = '<div class="alert alert-danger" role="alert">
                    إدخل البيانات من فضلك.
                    </div>';
                }
            }
            else
            {
                $error = '<div class="alert alert-danger" role="alert">
                نعتذر منك هناك خطاء برجاء إعادة المحاولة.. passwords
                </div>';
            }
        }
        else
        {
            $error = '<div class="alert alert-danger" role="alert">
            نعتذر منك هناك خطاء برجاء إعادة المحاولة.. uesrid
            </div>';
        }
    }
    else
    {
        $error = '<div class="alert alert-danger" role="alert">
       نعتذر منك هناك خطاء برجاء إعادة المحاولة.. empty hash
      </div>';
    }
}
?>
<!DOCTYPE html>
<html>

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
<div id="Title">
    <h4> إسترجاع الحساب </h4>
</div>
<div id="Context">
    <?php if(isset($error)){echo $error;} ?>
    <?php
    if(!isset($_GET['hash']))
    {
        echo '    <form id="search-main" method="POST" action="forget-account.html">
        <input type="hidden" name="forget-account" value="true" />
        <input style="margin-top:12px;margin-bottom:12px;" class="form-control inline" type="text" name="email" placeholder="البريد الإكتروني"  />
        <small style="text-align:right;padding:4px;background:#161616;color:white;width:270px;margin-bottom:10px;">سيتم إرسال رسالة تغير كلمة مرور لي بريدك الخاص</small>
        <button class="btn btn-dark" type="submit" name="submit"> إسترجع حسابك </button>
    </form>';
    }
    else
    {
        echo '    <form id="search-main" method="POST" action="forget-account.html?hash=' . $_GET['hash'] . '">
        <input type="hidden" name="hash" value="' . $_GET['hash'] . '" />
        <input style="margin-top:12px;margin-bottom:12px;" class="form-control inline" type="password" name="password" placeholder=
        "كلمة المرور"  />
        <input style="margin-top:12px;margin-bottom:12px;" class="form-control inline" type="password" name="re-password" placeholder="إعادة كلمة المرور"  />

        <button class="btn btn-dark" type="submit" name="submit"> حفظ </button>
        </form>';
    }
    ?>
</div>
<!--- end search main --->
</main>
<?php include_once("Includes/footer.php");
include_once('Includes/end.php');
?>
</body>
</html>