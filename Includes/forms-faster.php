<div id="Question" class="Question hide-class"> 
<div class="QuestionFormTitle">
        أطلب كرتون !
    </div>
<div class="QuestionExit Pointer" onclick="OpenQuestionForm();">
    <i class="fa fa-window-close" aria-hidden="true"></i>
</div>
<div id="QuestionTitle">
<h3> يمكنك هنا تقديم طلب إي كرتون وسيتم إضافة في اقرب وقت ممكن! </h3>
</div>
<div id="order-message-info" class="alert alert-danger hide-class" role="alert">
</div>
<form id="QuestionForm" autocomplete="off">
<input id="order-name" class="form-control Question-item" type='text' placeholder="أدخل أسم الكرتون" />
    <small style="text-align:right;"> أدخل أسم الكرتون من فضلك! </small>
<input id="order-email" class="form-control Question-item" type='email' placeholder="أدخل بريدك الإلكتروني" />
    <small style="text-align:right;"> ستصلك رسالة عند إضافة طلبك </small>
    <a class="btn btn-dark Question-item" id="order-btn" style="color:white;" onclick='order();'> أرسل الطلب! </a>
</form>
<div id="order-waiting" class="hide-class">
    <p style="    text-align: right;">  جاري تنفيذ طلبك انتظر من فضلك...   </p>
    <div class="spinner-border" style="float:right;" role="status">
    <span class="sr-only">Loading...</span>
    </div>
</div>
</div>
<!--- end navbar --->
<div id='from-reigster-faster' class="from-reigster-faster hide-class">
    <div class="register-exit Pointer" onclick="show('register');">
        <i class="fa fa-window-close" aria-hidden="true"></i>
    </div>
    <div class="title">
        <h4> سجل معنا ! </h4>
    </div>
    <div id="register-message-info" class="alert alert-danger hide-class" role="alert">
      
    </div>
    <form class="form">
      <input class="form-control mr-sm-2" id="register-username" type="username" placeholder="الاسم المستخدم" aria-label="الاسم المستخدم">
      <input class="form-control mr-sm-2" id="register-email" type="email" placeholder="البريد الإلكتروني" aria-label="البريد الإلكتروني" autocomplete="current-email">
      <input class="form-control mr-sm-2" id="register-password" type="password" placeholder="كلمة المرور" aria-label="كلمة المرور" autocomplete="current-password">
      <input class="form-control mr-sm-2" id="register-repassword" type="password" placeholder="تأكيد كلمة المرور" aria-label="تأكيد كلمة المرور" autocomplete="current-password">
      <label class="form-check-label" for="gridCheck" style="margin: auto;margin-top: 40px;background: aliceblue;float: right;">
          الموافقة على <a href="<?php  echo $dir_website; ?>terms-and-conditions.html"> الشروط والأحكام </a>
      </label>
      <input class="form-control mr-sm-2" id="register-terms-register" style="width: 20px;display: inline;float: none;margin-top: 32px;" type="checkbox" id="gridCheck">
      <a class="btn btn-dark" id="register-btn" style="color:white" onclick='register();'>سجل!</a>
    </form>
    <div id="register-waiting" class="hide-class" style="padding:5px; margin:5px;">
        <p style=" color:white;   text-align: right;">  جاري تنفيذ طلبك انتظر من فضلك...   </p>
        <div class="spinner-border" style="" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </div>
    
</div>

<!--- login faster --->
<div id='from-login-faster' class="from-reigster-faster hide-class">
    <div class="register-exit Pointer" onclick="show('login');">
        <i class="fa fa-window-close" aria-hidden="true"></i>
    </div>
    <div class="title">
        <h4> الدخول! </h4>
    </div>
    <div id="login-message-info" class="alert alert-danger hide-class" role="alert">
      
    </div>
    <form class="form">
      <input class="form-control mr-sm-2" id="login-username" type="username" placeholder="الاسم المستخدم او البريد الإلكتروني" aria-label="username" autocomplete="login-username">
      <input class="form-control mr-sm-2" id="login-password" type="password" placeholder="كلمة المرور" aria-label="password" autocomplete="login-password">
        <label class="form-check-label" for="gridCheck" style="
    /* margin: auto; */
    margin-top: 9px;
    margin-left: 105px;
    background: aliceblue;
    float: left;
    ">
            <a href="<?php  echo $dir_website; ?>forget-account.html" style="background:white"> هل نسيت كلمة المرور؟ </a>
        </label>
              <label class="form-check-label" for="gridCheck" style="
    margin: auto;
    margin-top: 38px;
    background: aliceblue;
    float: right;
    ">
         تذكرني؟ 
      </label>
      <input class="form-control mr-sm-2" id="register-terms" style="    width: 20px;
    display: inline;
    float: none;
    margin-top: 32px;" type="checkbox" name="keepalive"  id="gridCheck">
      <a class="btn btn-dark" id="login-btn" style="color:white" onclick='login()'>دخول!</a>
    </form>
    <div id="login-waiting" class="hide-class" style="padding:5px; margin:5px;">
    <p style=" color:white;   text-align: right;">  جاري تنفيذ طلبك انتظر من فضلك...   </p>
    <div class="spinner-border" style="" role="status">
    <span class="sr-only">Loading...</span>
    </div>
</div>
</div>
<!--- end login --->
<!--- btn report and order and ask! --->
<button id="all-btn" onclick="OpenQuestionForm();">
            <i id="chat" class="fa fa-question-circle" aria-hidden="true"></i>
</button>
