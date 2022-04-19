$(document).ready(function(){

    var menu = document.getElementsByClassName('sp-league-menu')[0];
    var bar = document.createElement('div');
    bar.classList.add('rewnewbar');

    menu.insertAdjacentElement('afterend', bar);
});