$(document).ready(function() {
    obj('btnupdateprofile').onclick=()=>{
        const ign = obj('').value;
        const pronouns = obj('').value;

        $.ajax({
            type:'post',
            url:myAjax.adminurl,
            dataType:'text',
            data:{action:'update_profile', 'ign':ign, 'pronouns':pronouns},
            success:function(response){
                Popup.show(response);
            },
            error:function(error, xhr, response) {
                Popup.error(response);
            }
        });
    }
});

let obj=(t)=> {
    return document.getElementById(t);
}

