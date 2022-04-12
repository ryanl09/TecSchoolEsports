$(document).ready(function() {
    document.getElementsByClassName('sp-player-details')[0].children[1].insertAdjacentHTML('afterend', `<dt>IGN</dt><dd>${playerinfo.ign}</dd>`);
    rcols();
});

function rcols() {
    var _t = document.getElementsByClassName('sp-template-player-statistics');
    for (var i = 0; i < _t.length; i++) {
        var t = _t[i].children[0];
        switch(t.innerHTML.toLowerCase()){
            case 'rocket league d1':
            case 'rocket league d2':
                rem(cols[2], i);
                break;
            case 'overwatch d1':
            case 'overwatch d2':
                rem(cols[1], i)
                break;
            case 'valorant d1':
            case 'valorant d2':
                rem(cols[3], i)
                break;
            case 'knockout city d1':
            case 'knockout city d2':
                rem(cols[0], i);
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
    var thead = document.getElementsByClassName('sp-template-player-statistics')[id].children[1].children[0].children[0].children[0].children;//header
    var trows = document.getElementsByClassName('sp-template-player-statistics')[id].children[1].children[0].children[0].children[1].children;//rows

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
//rem([0,1,2,3,4,5,6,7,8,9,10,11,16]);

function head(h, g) {
    switch(g){
        case 'rocket league d1':
        case 'rocket league d2':
            h.innerHTML = '';
            break;
        case 'overwatch':

            break;
        case 'valorant':

            break;
        case 'knockout city':

            break;
    }
}