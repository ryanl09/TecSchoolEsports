/*
var listener = function(event) {
    if (typeof event.data !== undefined && event.data !== undefined) {
        console.log(JSON.stringify(event.data));
    }
}
*/


$(document).ready(function() {
    if (document.getElementsByClassName('header-inner')) {
        
        var link = document.getElementsByClassName('menu-image-title-hide')[0];
        if (thisuser.hideteam) {
            document.getElementsByClassName(thisuser.hideteam)[0].remove();
        }
        if (thisuser.msg>0){//thisuser.msg) {
            var notif = document.getElementById('menu-item-1729');
            notif.innerHTML = `<div><span class="noti" id="msgnotif">${thisuser.msg}</span></div>` 
            + notif.innerHTML;
            var inbox = document.getElementById('menu-item-2740');
            inbox.innerHTML = `<div><span id="inboxnotif">${thisuser.msg}</span></div>` 
            + inbox.innerHTML;

            notif.onmouseenter = () => {
                document.getElementById('inboxnotif').classList.add('noti2');
                document.getElementById('msgnotif').hidden=true;
                //document.getElementById('msgnotif').classList.remove('noti');
            }

            notif.onmouseleave = () => {
                //document.getElementById('msgnotif').classList.add('noti');
                document.getElementById('msgnotif').hidden = false;
                document.getElementById('inboxnotif').classList.remove('noti2');

            }
        }
        var username = thisuser.name;
        if(username) {
            link.href="https://tecleagues.com/player/" + username;
        }
        var e = document.getElementsByClassName('button mp-hide-pw');
        for (var i = 0; i < e.length; i++) {
            e[i].style.display='block';
            e[i].style.minWidth='100px';
        }
        
    }

    /*

    if(!!window.EventSource) {
        const es = new EventSource('https://tecleagues.com/wp-content/plugins/TheEsportCompany/inbox.php');
        es.addEventListener('message', listener);
    } else {
        console.log('not allowed');
    }

    */
});
    
