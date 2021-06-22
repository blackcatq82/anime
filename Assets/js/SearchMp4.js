






// we needed to execute as request get for return a data html.
// needed more thinks for work as well. 
// i will skipped to last think.
function RequestGET(url)
{
    Get = $.ajax(
        {
            url:url,
            method:"get",
            beforeSend: function(request) 
            {
            },
            success:function(data)
            {
                html = document.getElementById('baseVideo');
                console.log(html.innerHTML);
            },
            error: function(data)
            {
                console.log("error get method");
               console.log(data);
            }
        });
}