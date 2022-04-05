$(document).ready(function(){
    const entry =document.getElementsByClassName('entry-header');
    if (entry && entry.length) {
        document.getElementsByClassName('entry-header')[0].remove();
    }
});