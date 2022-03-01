var last = []; //compare last query to current so we dont waste time getting same info

var _sorting=-1; //method of sorting used. < 0 = alphabetical, > 0 = any numerical sorting

var lastsort = ''; //know if we should reverse the order

let nfo;

const DEFAULT_SORT = () => { //alphabetical sort to start
    sorting=-1;
    for (var i = 0; i < nfo.length; i++) {
        for (var j = 0; j < nfo.length-1; j++) {
            if (nfo[j]['name'].toLowerCase() > nfo[j+1]['name'].toLowerCase()) {
                var temp = nfo[j];
                nfo[j] = nfo[j+1];
                nfo[j+1] = temp;
            }
        }
    }
}

$(document).ready(function() {
    var button = object('getstats');
    button.onclick = () => {
            var game=object('game').options[object('game').selectedIndex].text.toLowerCase();
            var now = [game];
            if(last!==now) {
                $.ajax({
                    type: "post",
                    url: myAjax.ajaxurl,
                    data: {action: 'getstats', 'game': game},
                    dataType: 'json',
                    success: function(response){
                        nfo = response;
                        last=now;

                        console.log(JSON.stringify(nfo));

                        if (!JSON.stringify(nfo).toLowerCase().includes('[error]')) {
                            //DEFAULT_SORT();
                            make_table();
                        } else {
                        }
                    },
        
                    error: function(xhr, status, error) {
                        alert('error');
                        console.error(status, error);
                    }
                });
            } 
        
    }

    var b = object('getstatsu');
    b.onclick = () => {
        var p = object('statuser').value;
        var sm = object('byign').checked?'ign':'name';
        $.ajax({
            type: "post",
            url: myAjax.ajaxurl,
            data: {action: 'getstatsu', 'player': p, 'searchmethod': sm},
            dataType: 'text',
            success: function(response){
                object('userstatblock').innerHTML = response;
                rcols();
            },

            error: function(xhr, status, error) {
                alert('error');
                console.error(status, error);
            }
        });
        
    }
    
});

let object = (oname) => {
    return document.getElementById(oname);
}

function sort_stuff(sortby) {
    if (lastsort===sortby) {
        nfo = nfo.reverse();
        make_table();
        return;
    }
    _sorting=1;
    for (var i = 0; i < nfo.length; i++) {
        for (var j = 0; j < nfo.length-1; j++) {
            if (nfo[j][sortby] < nfo[j+1][sortby]) {
                var temp = nfo[j];
                nfo[j] = nfo[j+1];
                nfo[j+1] = temp;
            }
        }
    }
    lastsort = sortby;
    update_sort(sortby);
    make_table();
}

function cap(word) {
    let lcWord = word.toLowerCase();
    return lcWord.charAt(0).toUpperCase() + lcWord.slice(1);
}

let t_header = (data) => {
    var headers = data.split('|');
    var temp = '';
    for (let i = 0; i < headers.length; i++) {
        if (headers[i]==='player'||headers[i]==='team'||headers[i]==='name') {
            if (headers[i]==='player') { headers[i] = 'rank'; }
            temp += td(cap(headers[i]));
        }  else {
            temp += td(`<a href="javascript:sort_stuff('` + headers[i].trim() + `')">` + cap(headers[i]) + `</a>`);
        }
    }
    return tr(temp);
}

let tr = (data) => {
    return `<tr>${data}</tr>`;
}

let td = (data, head=false) => {
    return `<td` + (head ? ' id="tblheader"' : '') +  `>${data}</td>`;
}

function update_sort(key) {
    let label = object('sortingby');
    label.innerText = "Currently sorting by: " + key;
}

function make_table() {
    var data=nfo;
    var i = 0;
    var table = '';
    var header = 'player|';
    
    for (var key in data) {
        var current = td(parseInt(key)+1);
        if (i>=0&&_sorting<0) {
            current=td('-');
        }
        for (var info in data[key]) {
            if (info==='team') { //trim off game+division in display text
                current += td(format_team(data[key][info]));
                //current += td(data[key][info]);
            } else {
                current += td(data[key][info]);
            }
            //user: key
            //value: data[key][info];
            if (i<1) { 
                header += info + '|';
            }
        }
        if (i<1) {
            header = t_header(header.substring(0, header.length-1));
        }
        i++;
        table += tr(current);
    }

    table = '<p id="sortingby" style="text-align:center;">Currently sorting by: alphabetical order</p><table id="massivetable"><tbody style="display:table; width:100%;">' + header + table + '</tbody></table>';

    var block = object('tecstatblock');
    block.innerHTML = table;
    //let table = t_header(data);
}

let format_team = (data) => {
    data = replaceAll(data, ' &#8211; ', '|');
    var index = data.indexOf('>')+1;
    var index2 = data.indexOf('<', index);
    var sub = data.substring(index, index2);
    var team = sub.split('|')[0];
    return data.replace(sub, team);
}

let replaceAll = (text, replace, w) => {
    while (text.includes(replace)) {
        text = text.replace(replace, w);
    }
    return text;
}


function rcols() {
    var _t = document.getElementsByClassName('sp-template-player-statistics');
    for (var i = 0; i < _t.length; i++) {
        var t = _t[i].children[0];

        switch(t.innerHTML.toLowerCase()){
            case 'rocket league d1':
            case 'rocket league d2':
                rem(myAjax.cols[2], i);
                break;
            case 'overwatch':
                rem(myAjax.cols[1], i)
                break;
            case 'valorant':
                rem(myAjax.cols[3], i)
                break;
            case 'knockout city':
                rem(myAjax.cols[0], i);
                break;
        }
    }
}

let c = (o, n) => {
    var r='';
    for (var i = 0; i < o.children.length; i++) {
        if(o.children[i].classList.indexOf(n)!=-1) {
            r=o[i]
            break;
        }
    }
    return r;
}

function rem(vals, id) {
    //console.log(id);
    var thead = document.getElementsByClassName('sp-template-player-statistics')[id].children[1].children[0].children[0].children[0].children;//header
    var trows = document.getElementsByClassName('sp-template-player-statistics')[id].children[1].children[0].children[1].children;//rows

    for (var i = 0; i < 1; i++) {
        var j = 1;
        var tl = document.getElementsByClassName('sp-template-player-statistics')[id].children[1].children[0].children[0].children[0].children.length;
        while (j < tl) {
            if(vals.indexOf(thead[j].innerHTML.toLowerCase()) != -1) {
                j++;
            } else {
                thead[j].remove();
                for (var k = 0;k < trows.length; k++) {
                    trows[k].children[j].remove();
                }
            }
            tl = document.getElementsByClassName('sp-template-player-statistics')[id].children[1].children[0].children[0].children[0].children.length
        }
    }
}
