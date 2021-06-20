<?php 

 $nav_rows =  $plugins->plugin['websetting']['instance']->navbar();

?>
<!--- start navbar --->
<nav class="navbar navbar-expand-lg navbar-dark bg-me">
  <a class="navbar-brand" href="/anime/index.html">LOGO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse " id="navbarSupportedContent">
    <ul class="navbar-nav pull-right">
      <?php

      foreach($nav_rows as $navtop)
      {
        if($navtop['side'] == 'TOP-SIDE')
        {
            if(strpos($navtop['title'], '<i class') === false)
            {
              echo
              '<li class="nav-item">
                <a class="nav-link" href="' . $dir_website . '' . $navtop["href"] . '" class="Pointer" title="'. $navtop['title'] . '">' . $navtop["title"] . '</a>
            </li>';
            }
            else
            {
              echo
              '<li class="nav-item">
                <a class="nav-link" href="' . $dir_website . '' . $navtop["href"] . '" class="Pointer">' . $navtop["title"] . '</a>
            </li>';
            }
        }
      }

      ?>
      <div class="navbar-nav pull-left">
      <?php
      if(!isset($_SESSION['username']))
      {
        echo '        <button class="btn btn-mystyles my-2 my-sm-0" id="btn-register" type="submit" onclick="show(\'register\');"><i class="fa fa-users" aria-hidden="true"></i> التسجيل</button>
        <button class="btn btn-mystyles my-2 my-sm-0" id="btn-login" type="submit" onclick="show(\'login\');"><i class="fa fa-sign-in" aria-hidden="true"></i> تسجيل دخول</button>';
      }else
      {
        echo '<button class="btn btn-mystyles my-2 my-sm-0" id="btn-profile" type="submit" onclick="show(\'profile\');"><i class="fa fa-users" aria-hidden="true"></i>' . $_SESSION['username'] . '</button>';
        echo '<a class="btn btn-mystyles my-2 my-sm-0" id="btn-logout" type="submit" href="' . $dir_website . 'logout.php"><i class="fa fa-users" aria-hidden="true"></i>تسجيل الخروج</a>';
      }
      ?>
    </div>
    </ul>
  </div>
</nav>
<!--- end navbar -->