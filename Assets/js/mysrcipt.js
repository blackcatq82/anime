/*
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#   * I Hate Js.
# POWERD BY BLACKCAT 2021 - 2022
*/
var class_danger = 'alert-danger';
var class_success = 'alert-success';
var class_btn_block = 'disabled';
var isregister = false;
var posts = null;
var can_use_ajax = true;
/* we need function onclick */

function register()
{
    var username = document.getElementById('register-username').value;
    var email = document.getElementById('register-email').value;
    var password = document.getElementById('register-password').value;
    var repassword = document.getElementById('register-repassword').value;
    var message_info = document.getElementById('register-message-info');
    /* register-terms */
    var terms = document.getElementById('register-terms-register').checked;

    if(terms == false)
    {
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'اذا لم توافق على الشروط والاحكام لا يمكنك التسجيل...';
        return;
    }
    var message_info = document.getElementById('register-message-info');
    var checking = validateEmail(email);
    
    if(checking == true)
    {
        if(password == repassword)
        {
            post(username,password,email,message_info);
        }
        else
        {
            if(message_info.classList.contains(class_danger))
            {
                message_info.classList.remove(class_danger);
            }
            if(message_info.classList.contains(class_hide))
            {
                message_info.classList.remove(class_hide);
            }
            if(!message_info.classList.contains(class_danger))
            {
                message_info.classList.add(class_danger);
            }
            if(!message_info.classList.contains(class_show))
            {
                message_info.classList.add(class_show);
            }
            message_info.innerHTML = 'كلمة المرور ليست متطابقة';
            return;
        }
    }
    else
    {
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'البريد ليس صحيحاً..';
        return;
    }
}
/* use ajax method post */
function post(username,password,email,message_info)
{
    if(can_use_ajax == false)
    {
        /* we need to send msg still working on something. */
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'هناك امر قدمته قبل قليل ويعمل عليه انتظر قليلاً من فضلك او حدث الصفحة';
        return;
    }
    can_use_ajax = false;

    if(posts != null)
    {
        posts.abort();
    }

    if(isregister){return;}
    var waiting = document.getElementById('register-waiting');
    var btn = document.getElementById('register-btn');

    if(btn.classList.contains(class_btn_block))
    {
        btn.classList.remove(class_btn_block);
        btn.classList.add(class_btn_block);
    }
    else
    {
        btn.classList.add(class_btn_block);
    }

    if(waiting.classList.contains(class_hide))
    {
        waiting.classList.remove(class_hide);
        waiting.classList.add(class_show);
    }
    else
    {
        waiting.classList.remove(class_show);
        waiting.classList.add(class_show);
    }
    /* we can use var to abort when we want use again. */
    posts = $.ajax(
        {
            url:"register.html",
            method:"post",
            data:
            {
                username:username
                ,
                password:password
                ,
                email:email
                ,
                ajax:'true'
            },
            success:function(data)
            {
                waiting.classList.remove(class_show);
                waiting.classList.add(class_hide);
                btn.classList.remove(class_btn_block);
                /* we will use methods includes to checking if has danger or success? */
                if(data.includes('danger'))
                {

                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_danger))
                    {
                        message_info.classList.add(class_danger);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  = message;
                }
                else if(data.includes('success'))
                {
                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_success))
                    {
                        message_info.classList.add(class_success);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  =   message ; 
                    isregister = true;
                }
            },
            error: function(data)
            {
                waiting.classList.remove(class_show);
                waiting.classList.add(class_hide);
                btn.classList.remove(class_btn_block);
            }
            
        });
}
/* use for checking if email is valid */

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
  
/* login faster */
function login()
{
    var username = document.getElementById('login-username').value;
    var password = document.getElementById('login-password').value;
    var message_info = document.getElementById('login-message-info');
    login_post(username,password,message_info);
}
/* use ajax method post */
function login_post(username,password,message_info)
{
    if(can_use_ajax == false)
    {
        /* we need to send msg still working on something. */
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'هناك امر قدمته قبل قليل ويعمل عليه انتظر قليلاً من فضلك او حدث الصفحة';
        return;
    }
    can_use_ajax = false;

    if(posts != null)
    {
        posts.abort();
    }

    var waiting = document.getElementById('login-waiting');
    var btn = document.getElementById('login-btn');

    if(btn.classList.contains(class_btn_block))
    {
        btn.classList.remove(class_btn_block);
        btn.classList.add(class_btn_block);
    }
    else
    {
        btn.classList.add(class_btn_block);
    }

    if(waiting.classList.contains(class_hide))
    {
        waiting.classList.remove(class_hide);
        waiting.classList.add(class_show);
    }
    else
    {
        waiting.classList.remove(class_show);
        waiting.classList.add(class_show);
    }
    /* we can use var to abort when we want use again. */
    posts = $.ajax(
        {
            url:"login.html",
            method:"post",
            data:
            {
                username:username
                ,
                password:password
                ,
                ajax:'true'
            },
            success:function(data)
            {
                waiting.classList.remove(class_show);
                waiting.classList.add(class_hide);
                btn.classList.remove(class_btn_block);
                /* we will use methods includes to checking if has danger or success? */
                if(data.includes('danger'))
                {

                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_danger))
                    {
                        message_info.classList.add(class_danger);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  = message;
                }
                else if(data.includes('success'))
                {
                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_success))
                    {
                        message_info.classList.add(class_success);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  =   message ; 
                }
            },
            error: function(data)
            {
                waiting.classList.remove(class_show);
                waiting.classList.add(class_hide);
                btn.classList.remove(class_btn_block);
            }
            
        });
}
function order()
{
    var name = document.getElementById('order-name').value;
    var email = document.getElementById('order-email').value;
    var message_info = document.getElementById('order-message-info');


    var checking = validateEmail(email);
    
    if(checking == true)
    {
        order_anime(name,email,message_info)
    }
    else
    {
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'البريد ليس صحيحاً..';
        return;
    }
    order_anime(name,email,message_info)
}
/* order anime */
function order_anime(name,email,message_info)
{
    if(can_use_ajax == false)
    {
        /* we need to send msg still working on something. */
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'هناك امر قدمته قبل قليل ويعمل عليه انتظر قليلاً من فضلك او حدث الصفحة';
        return;
    }
    can_use_ajax = false;
    
    if(posts != null)
    {
        posts.abort();
    }

    var waiting = document.getElementById('order-waiting');
    var btn = document.getElementById('order-btn');

    if(btn.classList.contains(class_btn_block))
    {
        btn.classList.remove(class_btn_block);
        btn.classList.add(class_btn_block);
    }
    else
    {
        btn.classList.add(class_btn_block);
    }
    
    if(waiting.classList.contains(class_hide))
    {
        waiting.classList.remove(class_hide);
        waiting.classList.add(class_show);
    }
    else
    {
        waiting.classList.remove(class_show);
        waiting.classList.add(class_show);
    }
    /* we can use var to abort when we want use again. */
    posts = $.ajax(
        {
            url:"order.html",
            method:"post",
            data:
            {
                ordername:name
                ,
                orderemail:email
                ,
                ajax:'true'
            },
            success:function(data)
            {
                waiting.classList.remove(class_show);
                waiting.classList.add(class_hide);
                btn.classList.remove(class_btn_block);

                /* we will use methods includes to checking if has danger or success? */
                if(data.includes('danger'))
                {

                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_danger))
                    {
                        message_info.classList.add(class_danger);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  = message;
                }
                else if(data.includes('success'))
                {
                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_success))
                    {
                        message_info.classList.add(class_success);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  =   message ; 
                }
            },
            error: function(data)
            {
                waiting.classList.remove(class_show);
                waiting.classList.add(class_hide);
                btn.classList.remove(class_btn_block);
                /* we needed msg tell them something wrong happend. */
            }
            
        });
}
function report(link,url)
{

    var message_info = document.getElementById('report-message-info');

    if(can_use_ajax == false)
    {
        /* we need to send msg still working on something. */
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'هناك امر قدمته قبل قليل ويعمل عليه انتظر قليلاً من فضلك او حدث الصفحة';
        return;
    }
    can_use_ajax = false;
    
    if(posts != null)
    {
        posts.abort();
    }
    /* we need to send msg still working on something. */
    if(message_info.classList.contains(class_danger))
    {
        message_info.classList.remove(class_danger);
    }
    if(message_info.classList.contains(class_hide))
    {
        message_info.classList.remove(class_hide);
    }
    if(!message_info.classList.contains(class_danger))
    {
        message_info.classList.add(class_danger);
    }
    if(!message_info.classList.contains(class_show))
    {
        message_info.classList.add(class_show);
    }
    message_info.innerHTML = 'جاري إرسال التبليغ إنتظر من فضلك';
    /* we can use var to abort when we want use again. */
    posts = $.ajax(
        {
            url:url,
            method:"post",
            data:
            {
                link:link
                ,
                report:'true'
            },
            success:function(data)
            {

                /* we will use methods includes to checking if has danger or success? */
                if(data.includes('danger'))
                {

                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_danger))
                    {
                        message_info.classList.add(class_danger);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  = message;
                }
                else if(data.includes('success'))
                {
                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_success))
                    {
                        message_info.classList.add(class_success);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  =   message ; 
                }
            },
            error: function(data)
            {
                /* we needed msg tell them something wrong happend. */
            }
            
        });
}
function expirelinks(vide_id,url)
{

    var message_info = document.getElementById('report-message-info');

    if(can_use_ajax == false)
    {
        /* we need to send msg still working on something. */
        if(message_info.classList.contains(class_danger))
        {
            message_info.classList.remove(class_danger);
        }
        if(message_info.classList.contains(class_hide))
        {
            message_info.classList.remove(class_hide);
        }
        if(!message_info.classList.contains(class_danger))
        {
            message_info.classList.add(class_danger);
        }
        if(!message_info.classList.contains(class_show))
        {
            message_info.classList.add(class_show);
        }
        message_info.innerHTML = 'هناك امر قدمته قبل قليل ويعمل عليه انتظر قليلاً من فضلك او حدث الصفحة';
        return;
    }
    can_use_ajax = false;
    
    if(posts != null)
    {
        posts.abort();
    }
    /* we need to send msg still working on something. */
    if(message_info.classList.contains(class_danger))
    {
        message_info.classList.remove(class_danger);
    }
    if(message_info.classList.contains(class_hide))
    {
        message_info.classList.remove(class_hide);
    }
    if(!message_info.classList.contains(class_danger))
    {
        message_info.classList.add(class_danger);
    }
    if(!message_info.classList.contains(class_show))
    {
        message_info.classList.add(class_show);
    }
    message_info.innerHTML = 'جاري إرسال لي تحقق من الروابط إنتظر من فضلك';
    /* we can use var to abort when we want use again. */
    posts = $.ajax(
        {
            url:url,
            method:"post",
            data:
            {
                vide_id:vide_id
                ,
                expirelinks:'true'
            },
            success:function(data)
            {

                /* we will use methods includes to checking if has danger or success? */
                if(data.includes('danger'))
                {

                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_danger))
                    {
                        message_info.classList.add(class_danger);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  = message;
                }
                else if(data.includes('success'))
                {
                    if(message_info.classList.contains(class_danger))
                    {
                        message_info.classList.remove(class_danger);
                    }
                    if(message_info.classList.contains(class_hide))
                    {
                        message_info.classList.remove(class_hide);
                    }
                    if(!message_info.classList.contains(class_success))
                    {
                        message_info.classList.add(class_success);
                    }
                    if(!message_info.classList.contains(class_show))
                    {
                        message_info.classList.add(class_show);
                    }
                    var message = data.substring(data.lastIndexOf("'") + 1, data.lastIndexOf(";"));
                    message_info.innerHTML  =   message ; 
                }
            },
            error: function(data)
            {
                /* we needed msg tell them something wrong happend. */
            }
            
        });
}
/* this for checking if someone fun is started. */
$(document).ajaxStart(function()
{
    /* we can use ajax again if all is done. */
    can_use_ajax = false;    
});
/* this for checking if someone fun is stop */
$(document).ajaxStop(function()
{
    /* we can use ajax again if all is done. */
    can_use_ajax = true;    
});
/* this for checking if someone fun is complete */
$(document).ajaxComplete(function()
{
    /* we can use ajax again if all is done. */
    can_use_ajax = true;    
});

function resrc_iframe($url)
{
    var iframe = document.getElementById('iframe_videos');
    iframe.src = $url;
}