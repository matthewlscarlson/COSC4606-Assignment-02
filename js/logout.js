/* Logout */
$('#logout').click(function() {
    /* Send confirm alert before logging out */
    if (confirm('Are you sure you want to log out?')) {
        $.ajax({
            type: 'POST',
            url: '/php/logout.php'
        });
        window.location.replace('/index.php');
    }
});
