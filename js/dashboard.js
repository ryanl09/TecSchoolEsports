//(function(){
let ACTIVE_BOX = 0;

let um=false,pm=false;

let selected_players = [];
let EVENT_ID=-1;

const players_cache=[];
const players_total=[];

const titles = [];

$(document).ready(function() {

    for (let i = 0; i < document.getElementsByClassName('mygamesbox').length; i++) {
        players_cache[i]=undefined;
        titles[i]=obj(`game${i}`).innerText;

        (function() {
            var j = i;
            document.getElementById(`game${j}`).addEventListener('click', function() {
                updatedashboard(j);
            });
        }());
    }
    /*
    <p id="rosterstatustext" class="rosterstatus">Roster: Not submitted</p>
    <button id="subtheroster" onclick="updateroster(0);" class="hollowbtn">Submit Now</button> */


    obj('upcomingmatches').addEventListener('click', function() {
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
    });

    obj('pastmatches').addEventListener('click', function() {
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
    });

    const modal = document.getElementById("myModal");

    var span = document.getElementsByClassName("closeModal")[0];
    span.addEventListener('click', function() {
        modal.style.display = "none";
        EVENT_ID=-1;
      });

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

    obj('playersearch').addEventListener('change', function() {
        //add suggestions, (5?)
    });

    obj('addplayer').addEventListener('click', function() {
        //add post meta to player

        let pl = '';
        const text = obj('playersearch').value.toLowerCase().trim();

        for(let i = 0; i < players_total.length;i++) { 
            if(players_total[i].name.toLowerCase().trim()===text){
                pl=players_total[i];
                break;
            }
        }

        if (!pl){
            Popup.show('[Error] Player not found.');
            return;
        }

        let flag='';

        verify:
        for(let i = 0; i < players_cache.length; i++) { 
            if(players_cache[i]===undefined) {
                continue;
            }
            for(let j = 0; j < players_cache[i].length; j++) {

                if(players_cache[i][j].name.toLowerCase().trim()===text){
                    if(i===ACTIVE_BOX) {
                        flag=`[Error] ${pl.name} is already on this team.`;
                        break verify;
                    }
                }
            }
        }

        if(flag) {
            Popup.show(flag);
        } else {
            //add player
            const row = create_player_row(pl.id, pl.name);
            players_cache[ACTIVE_BOX].push(pl);
            obj('playersbody').insertAdjacentElement('beforeend', row);
            obj('playersearch').value='';
            Popup.show(`[Success] ${pl.name} was added to ${titles[ACTIVE_BOX]}`);
        }
    });

    updatedashboard(ACTIVE_BOX);



    /*
    need to download the players when dashboard is switch
        -check if cached_players[index] is 'undefined', if it is then fetch
            -if not, then just reuse
        -refresh button in corner to refetch [current game only]
    
    */



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
        let bt = button(i, j, 'p', inf.events[i].past[0].roster!==0);
        html += tr(td(cur.past[j].opponent) + td(cur.past[j].date) + td(time) + td(bt));
    }
    let html2 = '';
    for (let j = 0; j < cur.future.length; j++) {
        var time = getpm(cur.future[j].time.split(':'));
        let bt = button(i, j, 'f', inf.events[i].future[0].roster!==0);
        html2 += tr(td(cur.future[j].opponent) + td(cur.future[j].date) + td(time) + td(bt));
    }
    
    return [html, html2];
}

function update_players() {
    obj('gametitle').innerHTML = titles[ACTIVE_BOX];
    const table = obj('playersbody');
    table.innerHTML = '';
    if (players_cache[ACTIVE_BOX]===undefined) {
        fetchPlayers(ACTIVE_BOX);
    } else {
        update_players_table(ACTIVE_BOX);
    }
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
    update_players();
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
    obj('mbheadertext').innerText = 'VS ' + ob.opponent + ' on ' + DateFormatter.date(ob.date) + ', ' + d.getFullYear() + ' @ ' + DateFormatter.time(ob.time);
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

function update_players_table(id) { 
    var html='';
    const table = obj('playersbody');
    for (let i = 0; i < players_cache[id].length; i++) {
        const pl = players_cache[id][i];
        const row = create_player_row(pl.id, pl.name);
        table.insertAdjacentElement('afterbegin', row);
    }
}

let create_player_row = (id,plname) => {
    const pl_options = document.createElement('div');
    pl_options.insertAdjacentElement('afterbegin', subtract(id));

    var td1 = document.createElement('td');
    td1.innerText = plname;

    var td2 = document.createElement('td');
    td2.insertAdjacentElement('afterbegin', pl_options);

    var row = document.createElement('tr');
    row.id=`plrow-${id}`;
    row.insertAdjacentElement('afterbegin', td1);
    row.insertAdjacentElement('beforeend', td2);
    return row;
}

let subtract = (id) => {
    var s = document.createElement('a');
    s.innerText = '➖';
    s.classList.add('ploption');
    s.addEventListener('click', function() {
        if (obj(`plrow-${id}`)) {
            obj(`plrow-${id}`).remove();
            for (let i = 0; i < players_cache[ACTIVE_BOX].length; i++) {
                if(players_cache[ACTIVE_BOX][i].id===id) {

                    players_cache[ACTIVE_BOX].splice(i, 1);
                    break;
                }
            }
        }
        //remove with ajax
        console.log(`Player [${id}] removed.`);
    });
    return s;
}

function fetchPlayers(id) {
    document.getElementById('playersloader').style.visibility='visible';
    $.ajax({
        type:'post',
        url:myAjax.ajaxurl,
        dataType: 'json',
        data: {action: 'fetch_players', 'game':titles[id]},
        success:function(response) {
            players_cache[id] = response;
            for (let i = 0; i < players_cache[id].length; i++) {
                players_total.push(players_cache[id][i]);
            }
            document.getElementById('playersloader').style.visibility='hidden';
            update_players_table(id);
        },
        error:function(xhr,response,error){
            console.log(`${error}: ${response}`);
        }
    });
} //})();