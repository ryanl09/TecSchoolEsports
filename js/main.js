const theurl = (window.location.href.endsWith('/') ? window.location.href.slice(0, -1) : window.location.href);
let url_count = theurl.replace("https://", "http://").replace("http://", "").split('/');
const urlsuffix = url_count[url_count.length-1];
const pagedir = (theurl.includes('player') ? url_count[url_count.length-2] : urlsuffix);

var open = false;

var mobleague=false;
var mobmore=false;
var mobaccount=false;

$(document).ready(function(){

    /*DESKTOP MENU*/
    var leaguesubmenu = '<ul id="sub-menu-league" class="sub-menulist">';
    leaguesubmenu += subitem('leaguerules', ahref('https://tecschoolesports.com/rules', 'Rules'));
    leaguesubmenu += subitem('leagueschedule', ahref('https://tecschoolesports.com/schedule', 'Schedule'));
    leaguesubmenu += subitem('leaguestandings', ahref('https://tecschoolesports.com/standings', 'Standings'));
    leaguesubmenu += subitem('leaguestats', ahref('https://tecschoolesports.com/stats', 'Stats'));
    leaguesubmenu += subitem('leagueteams', ahref('https://tecschoolesports.com/teams', 'Teams'));
    leaguesubmenu += '</ul>';
    var league = item('menu-league', ahref('#', 'League') + leaguesubmenu);

    var art = item('menu-articles', ahref('https://tecschoolesports.com/articles', 'News'));

    var moresubmenu = '<ul id="sub-menu-more" class="sub-menulist">';
    moresubmenu += subitem('moreaboutus', ahref('https://theesportcompany.com/tec-high-school-league/','About us'));
    moresubmenu += subitem('morecontact', ahref('https://tecschoolesports.com/contactus', 'Contact'));
    moresubmenu += subitem('morefundraising', ahref('https://tecschoolesports.com/fundraising','Fundraising'));
    moresubmenu+='</ul>';
    var more = item('menu-more', ahref('#', 'More')+moresubmenu);

    var store = item('menu-store', ahref('https://theesportcompany.com/store', 'Store'));

    var prof='';
    if (info.loggedin) {
        var accsubmenu = '<ul id="sub-menu-account" class="sub-menulist">';
        accsubmenu += subitem('accountprofile', ahref('https://tecschoolesports.com', 'Profile'));
        if (info.role === 'tm' || info.role === 'admin') {
            accsubmenu += subitem('accountdashboard', ahref('https://tecschoolesports.com/tmdashboard', 'Dashboard'));
        }
        accsubmenu += subitem('accountinbox', ahref('https://tecschoolesports.com/inbox/', 'Inbox'));
        accsubmenu += subitem('accountmygames', ahref('https://tecschoolesports.com/mygames', 'My Games'));
        accsubmenu += subitem('accountsettings', ahref('https://tecschoolesports.com/settings', 'Settings'));
        accsubmenu += '</ul>';
        prof = item('menu-account',  ahref('https://tecschoolesports.com', 'Account')+accsubmenu);
    } else {
        prof = item('menu-signup', ahref('https://tecschoolesports.com/register', 'Sign up'));
        prof += item('menu-login', ahref('https://tecschoolesports.com/login', 'Log In'));
    }

    /*MOBILE MENU*/
    var mobdivs='<div class="mobiconwrapper" onclick="mobilemenu(this)"><div class="mob-bar1"></div><div class="mob-bar2"></div><div class="mob-bar3"></div></div>';
    var mobileicon = item('mobile-menu-icon', mobdivs);
    var mobmenu = '<div id="mobSideNav" class="mobsidenav">';
    mobmenu += `<a class="mobmenuheader" href="#" onclick="slide('mobleague')">League</a>`;
    mobmenu += '<ul id="mobleaguemenu" class="mobsubmenu">';
    mobmenu += msubitem('mleaguerules', mahref('https://tecschoolesports.com/rules', 'Rules'));
    mobmenu += msubitem('mleagueschedule', mahref('https://tecschoolesports.com/schedule', 'Schedule'));
    mobmenu += msubitem('mleaguestandings', mahref('https://tecschoolesports.com/standings', 'Standings'));
    mobmenu += msubitem('mleaguestats', mahref('https://tecschoolesports.com/stats', 'Stats'));
    mobmenu += msubitem('mleagueteams', mahref('https://tecschoolesports.com/teams', 'Teams'));
    mobmenu += '</ul>';

    mobmenu += '<a id="mmenu-articles" class="mobmenuheader" href="https://tecschoolesports.com/articles">News</a>';

    mobmenu += `<a class="mobmenuheader" href="#" onclick="slide('mobmore')">More</a>`;
    mobmenu += '<ul id="mobmoremenu" class="mobsubmenu">';
    mobmenu += msubitem('mmoreaboutus', mahref('https://theesportcompany.com/tec-high-school-league/','About us'));
    mobmenu += msubitem('mmorecontact', mahref('https://tecschoolesports.com/contactus', 'Contact'));
    mobmenu += msubitem('mmorefundraising', mahref('https://tecschoolesports.com/fundraising','Fundraising'));
    mobmenu += '</ul>';

    mobmenu += '<a class="mobmenuheader" href="https://theesportcompany.com/store">Store</a>';

    if (info.loggedin) {
        mobmenu += `<a class="mobmenuheader" href="#" onclick="slide('mobaccount')">Account</a>`;
        mobmenu += '<ul id="mobaccountmenu" class="mobsubmenu">';
        mobmenu += msubitem('maccountprofile', mahref('https://tecschoolesports.com', 'Profile'));
        if (info.role === 'tm' || info.role === 'admin') {
            mobmenu += msubitem('maccountdashboard', mahref('https://tecschoolesports.com/tmdashboard', 'Dashboard'));
        }
        mobmenu += msubitem('maccountinbox', mahref('https://tecschoolesports.com/inbox/', 'Inbox'));
        mobmenu += msubitem('maccountmygames', mahref('https://tecschoolesports.com/mygames', 'My Games'));
        mobmenu += msubitem('maccountsettings', mahref('https://tecschoolesports.com/settings', 'Settings'));
        mobmenu += '</ul>';
    } else {  
        mobmenu += '<a class="mobmenuheader" href="https://tecschoolesports.com/register">Sign Up</a>';
        mobmenu += '<a class="mobmenuheader" href="https://tecschoolesports.com/login">Log In</a>';
    }

    mobmenu += '</ul>';

    mobmenu += '</div>';

    /*COMBINE EVERYTHING*/
    var items = listwrap('menu-list', 'menulist', league+art+more+store+prof);
    var left = span('menu-logo-box', img('menu-logo', "https://tecschoolesports.com/wp-content/uploads/2022/01/tectr2.png", 64, 32), 'left');
    var n = nav('tec-nav', items);
    var right = span('menu-main', n + mobileicon+mobmenu, 'right');

    var sp = document.getElementsByClassName('sp-inner')[0];
    var add=left+right;
    sp.innerHTML = add;

    /*
    ********click events************
    */

    
    document.getElementById('menu-logo').onclick=()=>{
        window.location="https://tecschoolesports.com";
    };
});

let span=(id, text, side)=>{
    return '<div id="' + id + '" class="menuspan' + side + '">' + text + '</div>';
}

let item=(id,text)=>{
    return '<li id="' + id + '" class="menuitem">' + text + '</li>';
}  

let subitem=(id, text)=> {
    return '<li id="' + id + '" class="submenuitem">' + text + '</li>';
}

let msubitem=(id, text)=> {
    return '<li id="' + id + '" class="mobsubmenuitem">'+text+'</li>';
}

let icon=(id,src)=>{
    return '<img id="' + id + '" class="tecmenuicon" src="' + src + '">';
}

let listwrap=(id,cl,text)=>{
    return '<ul id="' + id + '" class="'+cl+'">' + text + '</ul>';
}

let ahref=(link, text)=>{
    return '<a class="menulink" href="' + link + '">' + text + '</a>';
}

let mahref=(link, text)=>{
    return '<a class="m-menulink" href="' + link + '">' + text + '</a>';
}

let wrapper=(id, content)=>{
    return '<div id="' + id + '">'+content+'</div>';
}

let img=(id, src,w,h)=>{
    return '<img id="'+id+'" src="' + src + '" width="' + w +'" height="' + h + '">';
}

let nav=(id,text)=>{
    return '<nav class="main-nav" id="' + id + '">' + text + '</nav>'
}

function mobilemenu(x) {
    open=!open;
    x.classList.toggle("mob-change");
    if(open){
        openMobNav();
    } else {
        closeMobNav();
    }
}

function openMobNav() {
    document.getElementById('mobSideNav').style.width="100%";
}

function closeMobNav() {
    document.getElementById('mobSideNav').style.width="0%";
    mobleague=false;
    mobmore=false;
    mobaccount=false;
    document.getElementById('mobleaguemenu').style.display='none';
    document.getElementById('mobmoremenu').style.display='none';
    document.getElementById('mobaccountmenu').style.display='none';
}

function slide(id){
    switch(id){
        case 'mobleague':
            if(mobleague){
                $('#mobleaguemenu').slideUp();
            } else {
                $('#mobleaguemenu').slideDown();
                if(mobmore){
                    $('#mobmoremenu').slideUp();
                    mobmore=false;
                }
                if(mobaccount) {
                    $('#mobaccountmenu').slideUp();
                    mobaccount=false;
                }
            }
            mobleague=!mobleague;
            break;
        case 'mobmore':
            if(mobmore){
                $('#mobmoremenu').slideUp();
            } else {
                $('#mobmoremenu').slideDown();
                if(mobleague) {
                    $('#mobleaguemenu').slideUp();
                    mobleague=false;
                }
                if(mobaccount) {
                    $('#mobaccountmenu').slideUp();
                    mobaccount=false;
                }
            }
            mobmore=!mobmore;
            break;
        case 'mobaccount':
            if(mobaccount) {
                $('#mobaccountmenu').slideUp();
            } else {
                $('#mobaccountmenu').slideDown();
                if(mobleague) {
                    $('#mobleaguemenu').slideUp();
                    mobleague=false;
                }
                if(mobmore){
                    $('#mobmoremenu').slideUp();
                    mobmore=false;
                }
            }
            mobaccount=!mobaccount;
            break;
    }
}


function imghover(img) {
    document.getElementById(img).style.transform="scale(1.1)";
}

function imgleave(img) {
    document.getElementById(img).style.transform="scale(1)";
}

function imgclick(ext) {
    window.location='https://tecschoolesports.com/team/' + ext;
}

function stdclick(ext) {
    window.location='https://tecschoolesports.com/table/' + ext;
}