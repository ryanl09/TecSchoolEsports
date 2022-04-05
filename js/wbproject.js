function Emailer() {

}

Emailer.prototype = {
    sendEmail: function(e) {
        $.ajax({
            type:'post',
            dataType:'text',
            data:{action:'send_me_email', 'emailto':e},
            url:'https://tecschoolesports.com/wp-admin/admin-ajax.php',
            success:function(response) {
                console.log(response);
            },
            error:function(error,xhr,response) {
                console.error(`${error}: ${response}`);
            }
        });
    }
}