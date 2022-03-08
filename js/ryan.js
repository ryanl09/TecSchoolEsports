$(document).ready(function(){
    document.getElementById('addstudent').onclick=()=>{
        $.ajax({
            type:'post',
            url:myAjax.ajaxurl,
            dataType:'text',
            data:{action:'ryan_add_player', 'studentname':va('studentname'), 'studentign':va('studentign'), 'gamesel':selva('gamesel'), 
            'dsel':selva('dsel'), 'schoolsel':selva('schoolsel')},
            success:function(response) {
                Popup.show(response);
            },
            error:function(a, b, c){
                Popup.error(`${a}: ${b}`);
            }
        });
    }

    document.getElementById('studentname').onchange=()=>{
        document.getElementById('studentnamei').value=document.getElementById('studentname').value;
    }

    document.getElementById('studentign').onchange=()=>{
        document.getElementById('studentigni').value=document.getElementById('studentign').value;
    }

    document.getElementById('ignstudent').onclick = () => {

        $.ajax({
            type:'post',
            url:myAjax.ajaxurl,
            dataType:'text',
            data:{action:'update_player_ign', 'studentname':va('studentnamei'), 'studentign':va('studentigni')},
            success:function(response) {
                Popup.show(response);
            },
            error:function(a, b, c){
                Popup.error(`${a}: ${b}`);
            }
        });
    }
});

let va = (id) => {
    return document.getElementById(id).value;
}

let selva = (id) => {
    const o = document.getElementById(id);
    return o.options[o.selectedIndex].value;
}