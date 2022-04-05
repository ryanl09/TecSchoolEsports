let slide_pos=0;
let SLIDES=[];
var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

$(document).ready(function() {
    document.getElementsByClassName('header-area-custom')[0].style.backgroundImage='';
    document.getElementById('hpregister').onclick=()=>{
        window.location='https://tecschoolesports.com/register';
    }
    let matchbody = '';
    for (let i = 0; i < 10; i++) {
        let addStyle='';
        if (i%2==1) {
            addStyle=`style="background-color:#242428;"`;
        }
        matchbody += `<div class="matchcontentbox" ${addStyle}>
                        <div class="matchboxheader">
                            <a href="${events[i].url}"><p>${DateFormatter.date(events[i].date)}</p></a>
                        </div>
                        <div class="matchboxbody">
                            <div class="griditem">${events[i].img[0]}</div>
                            <div class="griditem"><p class="mphp">vs</p></div>
                            <div class="griditem">${events[i].img[1]}</div>
                        </div>
                    </div>`;
    }

    var html = `<div id="mcslider" class="matchcontentslider">
    <a id="buttonleft" class="btnS btnL">⏴</a>
    <a id="buttonright" class="btnS btnR">⏵</a>`;
    /*
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
        </div>*/
    
    html+=`${matchbody}</div>`;
    
    ob('content').insertAdjacentHTML('beforebegin', html);

    ob('buttonleft').onclick = () => {
        slideMatch(-5);
    }

    ob('buttonright').onclick = ()=> {
        slideMatch(5);
    }
});

let ob=(t)=>{
    return document.getElementById(t);
}

function slideMatch(direction) {
    const slider = document.getElementById('mcslider');
    
    slider.scroll({
        left:slider.scrollLeft+direction*100,
        top:0,
        behavior:'smooth'
    });
}

let datestr = (date) => {
    let d = new Date(ob.date + ' ' + getpm(ob.time.split(':')));
    obj('mbheadertext').innerHTML = 'VS ' + ob.opponent + ' on ' + days[d.getDay()] + ' ' + months[d.getMonth()] +', ' + d.getFullYear() + ' @ ' + getpm(ob.time.split(':'));
}
