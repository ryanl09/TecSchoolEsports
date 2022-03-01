let ACTIVE_BOX = 0;

let um=false,pm=false;

let selected_players = [];
let EVENT_ID=-1;

var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

$(document).ready(function() {


    /*
    <p id="rosterstatustext" class="rosterstatus">Roster: Not submitted</p>
    <button id="subtheroster" onclick="updateroster(0);" class="hollowbtn">Submit Now</button> */

    obj('upcomingmatches').onclick = function() {
        if(um){
            obj('upcomingmatches').innerHTML = 'Upcoming Matches ⯆';
            $('#upcomingmatchesinfo').slideUp();
        } else {
            obj('upcomingmatches').innerHTML = 'Upcoming Matches ▲';
            if(pm){
                $('#pastmatchesinfo').slideUp();
                obj('pastmatches').innerHTML = 'Past Matches ⯆';
                pm=false;
            }
            $('#upcomingmatchesinfo').slideDown();
        }
        um=!um;
    }

    obj('pastmatches').onclick = function() {
        if (pm) {
            obj('pastmatches').innerHTML = 'Past Matches ⯆';
            $('#pastmatchesinfo').slideUp();
        } else {
            obj('pastmatches').innerHTML = 'Past Matches ▲';
            if(um) {
                $('#upcomingmatchesinfo').slideUp();
                obj('upcomingmatches').innerHTML = 'Upcoming Matches ⯆';
                um=false;
            }
            $('#pastmatchesinfo').slideDown();
        }
        pm=!pm;
    }

    const modal = document.getElementById("myModal");

    var span = document.getElementsByClassName("closeModal")[0];
    span.onclick = function() {
        modal.style.display = "none";
        EVENT_ID=-1;
      }

    window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
          EVENT_ID=-1;
        }
      }



    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    ACTIVE_BOX = urlParams.get('selection') ?? 0;
    if (ACTIVE_BOX > inf.events.length) {
        ACTIVE_BOX = 0;
    }
    updatedashboard(ACTIVE_BOX);
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
    let cur = inf.events[i];
    let html = '';
    for (let j = 0; j < cur.past.length; j++) {
        var time = getpm(cur.past[j].time.split(':'));
        let bt = inf.events[1].past[0].roster!==0 ? button(i, j, 'p', true) : button(i, j, 'p', false);
        html += tr(td(cur.past[j].opponent) + td(cur.past[j].date) + td(time) + td(bt));
    }
    let html2 = '';
    for (let j = 0; j < cur.future.length; j++) {
        var time = getpm(cur.future[j].time.split(':'));
        let bt = inf.events[1].future[0].roster!==0 ? button(i, j, 'f', true) : button(i, j, 'f', false);
        html2 += tr(td(cur.future[j].opponent) + td(cur.future[j].date) + td(time) + td(bt));
    }
    
    return [html, html2];
}

let getpm =(d)=> {
    var tdata = d;
    var h = parseInt(tdata[0]);
    h = ((h + 11) % 12 + 1);
    return h + ':' + tdata[1] + ' PM';
}

function updatedashboard(i) {
    boxselect(i);
    let tbh = tablehtml(i);
    obj('pastmatchesbody').innerHTML = tbh[0];//past
    obj('ucmatchesbody').innerHTML = tbh[1];//future
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

function updateroster(sub) {
    if (!sub) {
        obj('rostersubmit').style.backgroundColor='#f24033';
        obj('subtheroster').style.display='none';
        obj('rosterstatustext').innerHTML='Roster: Not submitted';
    } else {
        obj('rostersubmit').style.backgroundColor='#29e65b';
        obj('subtheroster').style.display='inline-block';
        obj('rosterstatustext').innerHTML='Roster: Submitted';
    }
}

let button = (n1, n2, l, st) => {
    let text = st ? 'Edit' : 'Submit';
    let color = st ? '#29e65b' : '#f24033';
    return `<button onclick="editroster(${n1}, ${n2}, '${l}')" class="hollowbtn" style="min-width:130px; color:${color}; border:solid 2px ${color}">${text}</button>`;
}

function editroster(i, j, l) {
    let ob = l==='p'?inf.events[i].past[j]:inf.events[i].future[j];
    let d = new Date(ob.date + ' ' + getpm(ob.time.split(':')));
    obj('mbheadertext').innerHTML = 'VS ' + ob.opponent + ' on ' + days[d.getDay()] + ' ' + months[d.getMonth()] +', ' + d.getFullYear() + ' @ ' + getpm(ob.time.split(':'));
    let checks='';
    for(let k = 0; k < ros[i].length; k++) {
        checks+=cb(ros[i][k].name, 'check'+k, ros[i][k].id);
    }
    obj('mbbodytext').innerHTML = checks;
    obj('mbfootertext').innerHTML = '<button class="hollowbtn" id="confirmroster" onclick="sendroster()" style="min-width:50px; margin-top:10px;">Confirm</button>';
    const modal = document.getElementById("myModal");
    modal.style.display = "block";
    
    EVENT_ID=ob.id;
}

let cb = (label, id, value) => {
    return '<input type="checkbox" id="' + id + '" name="rostercheck" value="'+ value +'"><label for="'+id+'">'+label+'</label>';
}

function sendroster() {
    let play = [];
    const c = document.getElementsByName('rostercheck');
    c.forEach(function(ch){
        if (ch.checked){
            play.push(ch.value);
        }
    });
    $.ajax({
        type: 'post',
        dataType: 'text',
        url: myAjax.ajaxurl,
        data: {action:'confirm_roster', 'players': play, 'eventid':EVENT_ID},
        success: function(response){
            c.forEach(function(ch){ch.checked=false;});
            if(response.startsWith('[Success]')) {
                refresh();
            }else {
                Popup.show(response);
            }
        },
        error:function(error, response, xhr) {
            Popup.error(response);
        }
    });
}

function refresh() {
    const url = window.location.href.split('?')[0];
    window.location=`${url}?selection=${ACTIVE_BOX}`;
}

function clearpl() {
    selected_players=[];
}

function addpl(id) {
    selected_players[selected_players.length]=id;
}


