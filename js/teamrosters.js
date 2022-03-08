function slide(id) {
    if (document.getElementById(`team-${id}-content`).style.display==='none'){
        $(`#team-${id}-content`).slideDown();
        document.getElementById(`${id}-header`).innerHTML = document.getElementById(`${id}-header`).innerHTML.replace('+', '-');
    } else {
        $(`#team-${id}-content`).slideUp();
        document.getElementById(`${id}-header`).innerHTML = document.getElementById(`${id}-header`).innerHTML.replace('-', '+');
    }
}