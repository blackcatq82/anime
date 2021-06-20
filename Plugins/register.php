<?php 
include_once("InterFaces.php");
class register implements Plugins
{
    public $title = "register";
    public $instance;
    public $Methods;

    public function Builder()
    {
        $this->Methods = $this->BuilderMethods();
        $array = array('instance' => $this->instance , 'Methods' =>  $this->Methods);
        return $array;
    }
    public function BuilderMethods()
    {
        $this->instance = $this;
        $methods = get_class_methods($this);
        $array = array();
        foreach($methods as $method){ $array += [$method => $method]; }
        return $array;
    }
    /* we use it function for login users as well. */
    public function login($username , $password , $error_boolean = false)
    {
        # we use a global database
        global $conn;
        global $dir_website;
        # we need to checking if there some row is null.
        if(empty($username) || empty($password))
        {
            # we need to return message about null values.
            if($error_boolean === true)
            {
                global $error;
                $error = '<div class="alert alert-danger" role="alert">
                أدخل جميع البيانات المطلوبة
              </div>';
            }
            else
            {
                echo 'danger=\'أدخل جميع البيانات المطلوبة.;';
                return;
            }
        }
        else
        {
            # first checking in data base if has rows.
            $QUERY = "SELECT * FROM users WHERE username = ? OR email = ? AND password = ?";
            $stmt = $conn->prepare($QUERY);
            $stmt->bind_param('sss', $username , $username , $password );
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                if($error_boolean === true)
                {
                    global $error;
                    $error = '<div class="alert alert-success" role="alert">
                    مرحبا بك  ' . $row['username'] . 'من جديد  جاري تحويلك خلال خمس ثواني<meta http-equiv="refresh" content="5; URL=' . $dir_website . '"> </a> .
                  </div>';
                }
                else
                {
                    echo 'success=\' مرحبا بك  ' . $row['username'] . 'من جديد  جاري تحويلك خلال خمس ثواني<meta http-equiv="refresh" content="5; URL=' . $dir_website . '"> ;';
                    
                }
            }
            else
            {
                if($error_boolean === true)
                {
                    global $error;
                    $error = '<div class="alert alert-danger" role="alert">
                    هتاك خطاء بالبيانات المدخلة  . <a href="forget-password.html"> هل نسيت كلمة المرور؟ </a> .
                  </div>';
                }
                else
                {
                    echo 'danger=\' هتاك خطاء بالبيانات المدخلة  . <a href="' . $dir_website . 'forget-password.html"> هل نسيت كلمة المرور؟</a> ;';
                }
            }
        }
    }
    /**
     * 1 - we need to checking if there user exsits.
     * 2 - if we have we should return message about it.
     * 3 - if not we will register the user and return massage.
     * 4 - and login faster and give user chance to refresh page.
     */# echo 'success=\' تم تسجيلك بنجاح يرجاء تحديث الصفحة او تسجيل الدخول . <a href=".">تحديث</a> ;';
    public function registe($username,$email,$password, $error_boolean = false)
    {
        # we use a global database
        global $conn;
        global $dir_website;
        # we need to checking if there some row is null.
        if(empty($username) || empty($email) || empty($password))
        {
            # we need to return message about null values.
            if($error_boolean === true)
            {
                global $error;
                $error = '<div class="alert alert-danger" role="alert">
                أدخل جميع البيانات المطلوبة
              </div>';
            }
            else
            {
                echo 'danger=\'أدخل جميع البيانات المطلوبة.;';
                return;
            }
        }
        else
        {
            # first convert password as md5.
            $password = md5($password);
            # first checking in data base if has rows.
            $QUERY = "SELECT * FROM users WHERE username = ? or email = ? ";
            $stmt = $conn->prepare($QUERY);
            $stmt->bind_param('ss', $username , $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0)
            {
                if($error_boolean === true)
                {
                    global $error;
                    $error = '<div class="alert alert-danger" role="alert">
                    الاسم او البريد مسجل بالفعل <a href="' . $dir_website . 'forget-password.html"> هل نسيت كلمة المرور؟ </a> .
                  </div>';
                }
                else
                {
                    echo 'danger=\' الاسم او البريد مسجل بالفعل <a href="' . $dir_website . 'forget-password.html"> هل نسيت كلمة المرور؟ </a> .;';

                }
            }
            else
            {
                $time = date ('Y-m-d H:i:s', time());
                $QUERY = "INSERT INTO `users`(`username`, `password`, `email` , `time_register`) VALUES ( ? , ? , ? , ?)";
                $stmt = $conn->prepare($QUERY);
                $stmt->bind_param('ssss', $username , $password, $email, $time);
                $stmt->execute();
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                if($error_boolean === true)
                {
                    $title = "قبول عضويتك كرتون عربي مدبلج !!";
                    $messagetouser = $template = file_get_contents("template/register.html");
                    $messagetouser = str_replace('[user]',$_SESSION['username'],$messagetouser);
                    $messagetouser = str_replace('[date]',$time ,$messagetouser);
                    global $plugins;
                    $plugins->plugin['email']['instance']->sendto($email,$title,$messagetouser);
                    global $error;
                    $error = '<div class="alert alert-success" role="alert">
                    تم تسجيلك بنجاح يرجاء تحديث الصفحة او تسجيل الدخول . <a href="' . $dir_website . '">تحديث</a> .
                  </div>';
                }
                else
                {
                    $title = "قبول عضويتك كرتون عربي مدبلج !!";
                    $messagetouser = $template = file_get_contents("template/register.html");
                    $messagetouser = str_replace('[user]',$_SESSION['username'],$messagetouser);
                    $messagetouser = str_replace('[date]',$time ,$messagetouser);
                    global $plugins;
                    $plugins->plugin['email']['instance']->sendto($email,$title,$messagetouser);
                    echo 'success=\' تم تسجيلك بنجاح يرجاء تحديث الصفحة او تسجيل الدخول . <a href="' . $dir_website . '">تحديث</a> ;';
                    session_regenerate_id(true);
                }
            }
        }
    }
}