/* Login */
$(function() {
    /* Attempt to log user in when login button clicked */
    $('#login_form').on('submit', function(e) {
        /* Don't change page, just in case login fails */
        e.preventDefault();

        /* Pass username and password to php */
        $.post('/php/login.php', { user: $('#user').val(), pwd: $('#pwd').val() },
                function(data) {
                    /* Username not found in database */
                    if (data == 'User not found')
                        alert('User not found');
                    /* Username found BUT password incorrect */
                    else if (data == 'Password incorrect')
                        alert('Password incorrect');
                    /* Credentials correct, so log in user */
                    else
                        window.location.replace('/home.php');
                }
        );
    })
});

/* Using jquery's validation plugin for input validation
 * https://jqueryvalidation.org/
 */
function validate_form(id) {
    /* Store state in variable */
    var valid = $('#login_form').validate({
                rules: {
                    /* Username is required */
                    user: 'required',
                    /* Password is required with a minimum of three characters */
                    pwd: {
                        required: true,
                        minlength: 3
                    },
                }
    }).checkForm();

    /* Enable or disable login button based on validation state */
    if (valid) {
        $('#login').prop('disabled', false);
        $('#login').removeClass('isDisabled');
    } else {
        $('#login').prop('disabled', 'disabled');
        $('#login').addClass('isDisabled');
    }
}

/* Toggle password */
function toggle() {
    var field = document.getElementById('pwd');

    if (field.type === 'password') field.type = 'text';
    else field.type = 'password';
}

/* Login button disabled when page first loaded */
$('#login_form').on('blur keyup change', 'input', function(event) {
    validate_form('#login_form');
});
validate_form('#login_form');
