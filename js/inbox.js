$(document).ready(function() {
    var trash = $('[id^="trash"]');
    for (var i = 0; i < trash.length; i++) {
        trash[i].href=`javascript:deletemsg('${trash[i].id}');`;
    }
    
    updatemsgs();
});

function updatemsgs() {
    $.ajax({
        type:'post',
        url:myAjax.ajaxurl,
        data:{action:'update_messages'},
        dataType:'text',
        success:function(response) {

        },
        error:function(xhr, error, response) {

        }
    });
}

function deletemsg(id) {
    id = id.split('-')[1];
    document.getElementById(`msg-${id}`).remove();
    $.ajax({
        type:'post',
        url:myAjax.ajaxurl,
        data:{action:'delete_message', 'id':id},
        dataType:'text',
        success:function(response) {
            if(response.startsWith('[Success]')) {
                response = response.replace('[Success] ', '');
                alertify.set({ delay: 5000 }); 
                alertify.success(response); 
            } else if (response.startsWith('[Error]')) {
                response = response.replace('[Error] ', '')
                alertify.set({ delay: 5000 }); 
                alertify.error(response);
            } else {
                alertify.set({ delay: 5000 }); 
                alertify.success(response); 
            }
        },
        error:function(xhr,response,error) {
            alertify.set({ delay: 5000 }); 
            alertify.error(response);
        }
    });
}