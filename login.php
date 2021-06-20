<?php
include_once("IncludeAll.php");
include_once("Includes/start.php");
if(isset($_SESSION['username']) && isset($_POST['ajax']))
{
    echo 'danger=\'انت مسجل بالفعل وانت في حسابك الان.;';
    exit;
}
else if(isset($_SESSION['username']))
{
    header('location: ' . $dir_website . 'index.php');
    exit;
}
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['ajax']))
{
    $username = (string)$_POST['username'];
    $password = md5($_POST['password']);
    $plugins->plugin['register']['instance']->login($username,$password);
    session_regenerate_id(true);
}
else
{
    if(isset($_SESSION['username']))
    {
        header('location: index.php');
    }
    if(isset($_POST['submit']))
    {
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            if(empty($_POST['username']) || empty($_POST['password']))
            {
                $error = '<div class="alert alert-danger" role="alert">
                ستكمل جميع الحقول من فضلك !!
            </div>';
            }
            else
            {
                $username = (string)$_POST['username'];
                $password = md5($_POST['password']);
                $plugins->plugin['register']['instance']->login($username,$password , true);
                session_regenerate_id(true);
            }
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
<?php include_once("Includes/forms-faster.php") ?>
<?php include_once("Includes/navbar.php") ?>
<?php include_once("Includes/gallery.php") ?>
<?php include_once("Includes/Masterweb-Message.php") ?>
<?php include_once("Includes/MainSearch.php") ?>
<div id="Title">
    <h4> تسجيل دخول </h4>
</div>
<div id="Context" class="container">
  <div class="row">
      <div class="col-3"></div>
        <form class="form col-6" method="post" action="login.html" autocomplete="off">
            <?php if(isset($error)){echo $error;} ?>
          <input class="form-control mr-sm-2" name="username" type="username" placeholder="الاسم المستخدم" aria-label="الاسم المستخدم">
          <input class="form-control mr-sm-2" name="password" type="password" placeholder="كلمة المرور" aria-label="كلمة المرور">
          <button class="btn btn-dark" type="submit" name="submit">تسجيل دخول!</button>
        </form>
      <div class="col-3"></div>
    </div>
</div>
</main>
<?php include_once("Includes/footer.php");
include_once('Includes/end.php');
?>
</body>

</html>
<?php
}
?>