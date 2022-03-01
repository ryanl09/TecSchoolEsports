const GAMES = ['Knockout City', 'Overwatch', 'Rocket League', 'Valorant'];

$(document).ready(function() {

    let sct = obj('val10');
    sct.value = inf.schoolcode;
    if(inf.schoolcode) {
        if (inf.sug==-1) {
            sct.insertAdjacentHTML('afterend', '<p>We can\'t find a school with that code.</p>');
        } else {
            sct.disabled=true;
            sct.style.color="#bbb";
            sct.insertAdjacentHTML('afterend', `<p>School: ${inf.sug}. Click <a href="javascript:resetsc();">here</a> if this is incorrect.</p>`);
        }
    }

    let btn = obj('tmregister');
    btn.onclick=()=>{
        obj('tmregister').disabled = true;
        obj('loadingdots').style.visibility='visible';
        obj('loadingmessage').style.visibility='visible';

        $.ajax({
            url: inf.ajaxurl,
            type:'post',
            dataType:'text',
            data: {action:'student_register','name': fe(1),'ign': fe(2),'games': checkvals(),
            'pronouns': fe(4),'grade': selectedval('val5'),'email': fe(6),'username': fe(7),
            'pass': fe(8),'cpass': fe(9),'schoolcode': fe(10), 'gre_captcha': grecaptcha.getResponse()
            },
            success:function(response) {
                Popup.show(response);
                obj('loadingdots').remove();
                if (response.indexOf('[Success]')!==-1) {
                    obj('loadingdotsnotice').innerHTML='If you were not redirected, please click <a href="https://tecschoolesports.com/">here</a>';
                    //window.location="https://tecschoolesports.com/";
                } else {
                    obj('tmregister').disabled=false;
                }
            },
            error:function(xhr, response, error) {
                Popup.error(response);
            }
        });
    }
});

let obj=(t)=>{
    return document.getElementById(t);
}

let fe = (num) => {
    let val = obj(`val${num}`).value;
    return val;
}

let checkvals = () => {
    var arr=[];
    var cbxs = document.getElementsByName(`games`);
    for (let i = 0; i < cbxs.length; i++) {
          if(cbxs[i].checked) {
              arr[arr.length] = `${cbxs[i].value} D1`;
          }
    }
    return arr;
}

let selectedval=(id)=> {
    return obj(id).options[obj(id).selectedIndex].value;
}

function resetsc() {
    obj('val10').disabled=false;
    obj('val10').value='';
}