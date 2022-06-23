$('#actions').click(function() { open(); });

function open() {
    /* Expand nav */
    document.getElementById('nav').style.width = '23rem';

    /* Shift contents of page over */
    document.getElementById('header').style.marginLeft = '23rem';
    document.getElementById('main').style.marginLeft = '23rem';
}

function exit() {
    /* Contract nav */
    document.getElementById('nav').style.width = '0';

    /* Put contents back to normal */
    document.getElementById('header').style.marginLeft = '0';
    document.getElementById('main').style.marginLeft = '0';
}
