//everything we need from PHP 
var stuff;
//done

var game;
var team;
var div;
var week;


var incl_game = false;
var incl_div = false;

var choice = '';

const MAX_TABLE_SIZE=20;//?

$(document).ready(function() {
    var button=object('makeschedule');
    button.onclick = () => {
        game=object('game').options[object('game').selectedIndex].text.toLowerCase();
        choice=game;
        $.ajax({
            type: "post",
            url: myAjax.ajaxurl,
            data: {action: 'getschedule', 'game': game},
            dataType: 'json',
            success: function(response){
                stuff=response.ret;
                //console.log(JSON.stringify(response.ret));
                make_table(response.ret);
            },
            error: function(xhr, status, error) {
                Popup.error(error);
            }
        });

    }
});

let object = (oname) => {
    return document.getElementById(oname);
}

function cap(word) {
    let c = word.split(' ');
    let s = '';
    for (var i = 0; i < c.length; i++) {
        s += c[i].charAt(0).toUpperCase() + c[i].slice(1) + (i<c.length-1 ? ' ' : '');
    }
    return s;
}

/*
function make_table(newstuff) {
    var html = '<table border="1" id="scheduleTable">' + t_header(false, false); 
    
    var added = 0;
    var event_day=0;
    var event_month=0;
    var event_year=0;
    var added_index=-1;
    alert(newstuff.length);

    for (var i = 0; i < newstuff.length; i++) {
        var temp = '';

        var t=newstuff[i]['title'];
        
        temp += td(`<a href="${newstuff[i]["link"]}">${cap(t.split(' ')[0]) + ' ' + cap(t.split(' ')[1])}</a>`);
        //epi = stuff[i]["id"];
        var ddata = newstuff[i]["date"].split('-');
        event_day=parseInt(ddata[2]);
        event_month=parseInt(ddata[1]);
        event_year=parseInt(ddata[0]);
        var date = ddata[1] + '/' + ddata[2] + '/' + ddata[0];
        var tdata = newstuff[i]["time"].split(':');
        
        var time = (tdata[0].startsWith('0') ? tdata[0].substring(1) : tdata[0]) + ':' + tdata[1];
        temp += td(date);
        temp += td(time + " PM");
        html += tr(temp);
        added++;
        added_index=i;
    }
    
    html += '</table>';
    
    var today = new Date();
    var t_day = today.getDate();
    var t_month = today.getMonth() + 1;
    var t_year = today.getFullYear();
    var pastevent=false;
    
    if (added === 0) {
        html = '<h4><center>No events found!</center></h4>';
    }
    
    if (added === 1) {
        if ((t_day > event_day && t_month >= event_month && t_year >= event_year) || 
        (t_day >= event_day && t_month > event_month && t_year >= event_year) || 
        (t_day >= event_day && t_month >= event_month && t_year > event_year)) {
            pastevent = true;
        }
        if (!pastevent) {
            html += newstuff[added_index]["results"];
            html += newstuff[added_index]["boxscore"];
        }
    }
    
    
    var block = object('scheduleblock');
    block.innerHTML = html;

}

*/

function make_table(newstuff) {
    var html = '<table border="1" id="scheduleTable">' + t_header(false, false); 

    var gamelist = ['rocket league d1', 'rocket league d2', 'overwatch', 'valorant'];
    
    var added = 0;
    var event_day=0;
    var event_month=0;
    var event_year=0;
    var added_index=-1;
    var str = '';

   for (var j in newstuff) {
        var i = parseInt(j);
        var temp = '';

        var t=newstuff[i]['title'];
        while (t.includes('&#8211;') || t.includes('–')) {
            t = t.replace('&#8211;', '-');
            t=t.replace('–', '-');
        }

        var b = 0;
        if (game==='any') {
            for (var a = 0; a < gamelist.length; a++) {
                if (t.includes(` - ${gamelist[a]}`)) {
                    b=a;
                    while (t.includes(` - ${gamelist[a]}`)) {
                        t = t.replace(` - ${gamelist[a]}`, '');
                    }
                }
            }
        } else {
            while (t.includes(` - ${game}`)) {
                t = t.replace(` - ${game}`, '');
            }
        }
        
        temp += td(`<a href="${newstuff[i]["link"]}">${cap(t.split(' vs ')[0]) + ' vs ' + cap(t.split(' vs ')[1])}</a>`);
        //epi = stuff[i]["id"];
        var ddata = newstuff[i]["date"].split('-');
        event_day=parseInt(ddata[2]);
        event_month=parseInt(ddata[1]);
        event_year=parseInt(ddata[0]);
        if(event_year<2021) {
            continue;
        }
        if(game==='any') {
            temp += td(cap(gamelist[b]));
        }
        var date = ddata[1] + '/' + ddata[2] + '/' + ddata[0];
        var tdata = newstuff[i]["time"].split(':');
        var h = parseInt(tdata[0]);
        h = ((h + 11) % 12 + 1);

        var time = h + ':' + tdata[1];
        temp += td(date);
        temp += td(time + " PM");
        html += tr(temp);
        added++;
        added_index=i;
   }
    
    html += '</table>';
    
    var today = new Date();
    var t_day = today.getDate();
    var t_month = today.getMonth() + 1;
    var t_year = today.getFullYear();
    var pastevent=false;
    
    if (added === 0) {
        html = '<h4><center>No events found!</center></h4>';
    }
    
    if (added === 1) {
        if ((t_day > event_day && t_month >= event_month && t_year >= event_year) || 
        (t_day >= event_day && t_month > event_month && t_year >= event_year) || 
        (t_day >= event_day && t_month >= event_month && t_year > event_year)) {
            pastevent = true;
        }
        if (!pastevent) {
            html += newstuff[added_index]["results"];
            html += newstuff[added_index]["boxscore"];
        }
    }
    
    
    var block = object('scheduleblock');
    block.innerHTML = html;

}

let t_header = (g, d) => {
    var temp = '';
    temp += td('Teams');
    temp += choice==='any' ? td('Game') : '';
    temp += td('Date');
    temp += td('Time')
    return tr(temp);
}

let tr = (data) => {
    return `<tr>${data}</tr>`;
}

let td = (data) => {
    return `<td>${data}</td>`;
}

let z = (n) => {
    return (n<10&&n>0 ? `0${n}` : `${n}`);
}

//mm/dd/yyyy
let f_date = (m, d) => {
    return `${z(m)}/${z(d)}/${YEAR}`;
}

function days(m) {
    return new Date(YEAR, m, 0).getDate();
}

function init_data (a) {
    stuff = a;
}