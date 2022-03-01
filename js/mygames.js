let ACTIVE_BOX = 0;

let header = '';

$(document).ready(function() {
    console.log(JSON.stringify(inf));

    let img = [];
    for (let i = 0; i < inf.length; i++) {
        img[img.length]=inf[i].img;
    }
    let html = '<div class="mygamesheader">';
    for (let i = 0; i < img.length; i++) {
        html += '<button id="game' + i + '" class="mygamesbox" onclick="updatetable(' + i + ')">' + img[i] + '</button>';
    }
    html += '</div>';

    html += '<div class="mygamesmain"><table id="mygamesschedule"><thead id="mygamesthead">';
    header = tr(th('<p style="vertical-align: bottom;">Opponent</p>', 70) + th('<p style="vertical-align: bottom;">Date</p>', 15) + th('<p style="vertical-align: bottom;">Time</p>', 15));
    header += '</thead>';
    html += header + '<tbody id="mygamestbody">';
    
    /*
    html += header;
    for (let i = 0; i < inf.length; i++) {
        let cur = inf[i].events;
        for (let j = 0; j < cur.length; j++) {
            var tdata = cur[j].time.split(':');
            var h = parseInt(tdata[0]);
            h = ((h + 11) % 12 + 1);
    
            var time = h + ':' + tdata[1];

            html += tr(td(cur[j].title) + td(cur[j].date) + td(time));
        }
    }*/

    html += tablehtml(ACTIVE_BOX);
    html += '</tbody></table></div>';

    obj('mygameswrapper').innerHTML = html;
    boxselect(ACTIVE_BOX);
});

let obj=(t)=>{
    return document.getElementById(t);
}

function boxselect(i) {
    obj("game" + ACTIVE_BOX).style.border="none";
    obj("game" + ACTIVE_BOX).style.background = "none";

    obj("game" + i).style.border = "solid 1px white";
    obj("game" + i).style.background = "#222";
    ACTIVE_BOX = i;


}

function tablehtml(i) {
    let cur = inf[i].events;
    let html = '';
    for (let j = 0; j < cur.length; j++) {
        var tdata = cur[j].time.split(':');
        var h = parseInt(tdata[0]);
        h = ((h + 11) % 12 + 1);
        var time = h + ':' + tdata[1] + ' PM';
        html += tr(td(cur[j].title) + td(cur[j].date) + td(time));
    }
    return html;
}

function updatetable(i) {
    boxselect(i);
    obj('mygamestbody').innerHTML = tablehtml(i);
}

let tr=(t)=>{
    return '<tr>' + t + '</tr>';
}

let td=(t, w)=>{
    if (w===undefined) {
        return '<td class="trleftalign">' + t + '</td>';
    } else {
        return '<td width="' + w + '%" class="trleftalign">' + t + '</td>';
    }
}

let th=(t, w)=>{
    if (w===undefined) {
        return '<th class="trleftalign">' + t + '</th>';
    } else {
        return '<th width="' + w + '%" class="trleftalign">' + t + '</th>';
    }
}
