const GAMES = ['Knockout City', 'Overwatch', 'Rocket League', 'Valorant'];

$(document).ready(function() {

    var pc = obj('primarycolor');
    var sc = obj('secondarycolor');
    var p=obj('val11');
    p.value="#000000";
    var s=obj('val12');
    s.value="#000000";

    pc.onchange=(e)=>{ p.value=pc.value; }
    pc.oninput=(e)=>{ p.value=pc.value; }
    sc.onchange=(e)=>{ s.value=sc.value; }
    sc.oninput=(e)=>{ s.value=sc.value; }
    p.onfocusout=()=>{ try{ pc.value=p.value; } catch(e){ console.log('[e] invalid color.'); } };
    s.onfocusout=()=>{ try{ sc.value=s.value; } catch(e){ console.log('[e] invalid color.'); } };

    let btn = obj('tmregister');
    btn.onclick=()=>{
        obj('tmregister').disabled = true;
        obj('loadingdots').style.visibility='visible';
        obj('loadingmessage').style.visibility='visible';
        /*team records
standings

pronouns

match history
event links*/
        $.ajax({
            url: inf.ajaxurl,
            type:'post',
            dataType:'text',
            data: {action:'tm_register','school': fe(1),'teamname': fe(2),'mascot': fe(3),
            'pcperson': fe(4),'pctitle': fe(5),'pcemail': fe(6),'pcphone': fe(7),
            'pcdiscord': fe(8),'team1games': checkvals(1),'team2games': checkvals(2),
            'primarycolor': fe(11),'secondarycolor': fe(12),'username': fe(13),'pass': fe(14),
            'cpass': fe(15),'socialmedia': fe(16), 'gre_captcha': grecaptcha.getResponse()
            },
            success:function(response) {
                Popup.show(response);
                obj('loadingdots').remove();
                if (response.indexOf('[Success]')!==-1) {
                    obj('loadingdotsnotice').innerHTML='If you were not redirected, please click <a href="https://tecschoolesports.com/tmdashboard">here</a>';
                    window.location="https://tecschoolesports.com/tmdashboard";
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

let cd=(i, a)=>{
    var e = document.createElement('input');
    e.type='color';
    e.id=i;
    var b = obj(a);
    b.parentNode.insertBefore(e, b.nextSibling);
    return obj(i);
}

let fe = (num) => {
    return obj(`val${num}`).value;
}

let checkvals = (d) => {
    var arr=[];
    var cbxs = document.getElementsByName(`t${d}games`);
    for (let i = 0; i < cbxs.length; i++) {
          if(cbxs[i].checked) {
              arr[arr.length] = `${cbxs[i].value} D${d}`;
          }
    }
    return arr;
}