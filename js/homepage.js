let slide_pos=0;
let SLIDES=[];
var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

$(document).ready(function() {
    document.getElementsByClassName('header-area-custom')[0].style.backgroundImage='';
    document.getElementById('hpregister').onclick=()=>{
        window.location='https://tecschoolesports.com/register';
    }

    console.log(events[0].img[0]);
    var html = `<div id="mcslider" class="matchcontentslider">
    <a href="javascript:slideMatch(-1);" class="btnS btnL">⏴</a>
    <a href="javascript:slideMatch(1);" class="btnS btnR">⏵</a>
    
        <div class="matchcontentbox">
            <div class="matchboxheader">
                <p>${events[0].date}</p>
            </div>
            <div class="matchboxbody">
                ${events[0].img[1]}

                <p class="mphp">${events[0].teams[0]}</p>

                ${events[0].img[1]}
                <p class="mphp">${events[0].teams[1]}</p>
            </div>

            
        </div>
    
    </div>`;
    
    ob('content').insertAdjacentHTML('beforebegin', html);
});

let ob=(t)=>{
    return document.getElementById(t);
}

function slideMatch(direction) {
    slide_pos += direction;

}

let datestr = (date) => {
    let d = new Date(ob.date + ' ' + getpm(ob.time.split(':')));
    obj('mbheadertext').innerHTML = 'VS ' + ob.opponent + ' on ' + days[d.getDay()] + ' ' + months[d.getMonth()] +', ' + d.getFullYear() + ' @ ' + getpm(ob.time.split(':'));
}
