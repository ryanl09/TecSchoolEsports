var c = [];

$(document).ready(function() {
    document.getElementsByClassName('content-wrapper')[0].style.width='90%';

    //console.log(JSON.stringify(data));

    var ev = [1];
    var c = [];

    if (data.ecode) {
        obj('castermatchupwrapper').innerHTML += `<p style="text-align:center;">There are no matches today!</p>`
    } else {
        for(i=1;i<data.length+1;i++) {
            c[i]=false;
            tableObject(i-1);
            obj("eh"+i).onclick=(event)=>{
                var j = parseInt(event.target.id.replace('eh', ''));
                if(c[j]) {
                    $('#'+event.target.id.replace('eh', 'event')).slideUp();
                    obj('eh'+j).innerHTML = obj('eh'+j).innerHTML.replace('▲','⯆');

                } else {
                    $('#'+event.target.id.replace('eh', 'event')).slideDown();
                    obj('eh'+j).innerHTML = obj('eh'+j).innerHTML.replace('⯆','▲');
                }
                c[j]=!c[j];
            }
        }
    }
});

let obj=(t)=>{
    return document.getElementById(t);
}

function tableObject(index) {
    var team1=data[index].team[0].name;
    var team2=data[index].team[1].name;
    var str ='<div class="castermatchup">'

    str += `<div class="casterheader"><h5 class="casterh" id="eh${index+1}">[ ${cTime(data[index].time)} ] - ${team1} vs ${team2} ⯆</h5></div>`;

    str += `<div class="cmbody" id="event${index+1}" style="display:none;">`;

    str += '<div id="cmteam1" class="tbox">';
    str += '<div class="titlecontainer">';
    //str += '<img src="' + data[index].team[0].img + '" height="50" width="50">';
    str += data[index].team[0].img;
    str += `<h3 class="tboxhead">${team1}</h3>`;
    str += '</div>';

    str += '<div class="cmplinfo">'
    for (let i = 0; i < data[index].team[0].players.length; i++) {
        let pl = data[index].team[0].players[i];
        str += '<p>' + pl.name + '</p>';
        str += stattable(pl);
    }
    str += '</div>';

    str += '</div>';

    str += '<div id="cmteam2" class="tbox">';
    str += '<div class="titlecontainer">';
    //str += '<img src="' + data[index].team[1].img + '" height="50" width="50">';
    str += data[index].team[1].img;
    str += `<h3 class="tboxhead">${team2}</h3>`;
    str += '</div>';

    str += '<div class="cmplinfo">'
    for (let i = 0; i < data[index].team[1].players.length; i++) {
        let pl = data[index].team[1].players[i];
        str += '<p>' + pl.name + '</p>';
        str += stattable(pl);
    }
    str += '</div>';

    str += '</div>';

    str += '</div>'
    str += '</div>'

    let o = obj('castermatchupwrapper');
    o.innerHTML += str;
}

let stattable = (arr) => {
    let html = '<table><thead>';
    let c = getcols(arr.leagueid);
    let keys = Object.keys(arr.stats);
    let keep = [];
    let hrow = '';
    for (let i = 0; i < keys.length; i++) {
        if (c.indexOf(keys[i]) === -1) continue;

        keep[keep.length]=arr.stats[keys[i]];
        hrow += '<th>' + keys[i] + '</th>';
        
    }
    html += '<tr>' + hrow + '</tr><tbody>';

    let brow = '';
    for (let i = 0; i < keep.length; i++) {
        brow += '<td>' + keep[i] + '</td>';
    }

    html +=  '<tr>' + brow + '</tr></tbody></table>';
    return html;
}

let getcols = (leagueid) => {
    let cols = [];
    switch (leagueid) {
        case 1360://rocketleague
        case 1364:
            cols = ['shots', 'assists', 'saves', 'goals'];
            break;
        case 1361://overwatch
            cols = ['herodamage', 'finalblows', 'healsdealt', 'deaths'];
            break;
        case 0://valorant
            cols =['kills', 'deaths', 'defuses', 'plants', 'firstbloods', 'econrating', 'assists'];
            break;
        case 0://knockout city
            cols=['', '', '', ''];
            break;
    }
    return cols;
}

let cTime = (t) => {
    var hours=parseInt(t.split(':')[0]);
    suffix = (hours >= 12)? 'PM' : 'AM';
    hours = (hours > 12)? hours -12 : hours;
    hours = (hours == '00')? 12 : hours;
    return `${hours}:${t.split(':')[1]} ${suffix}`;
}