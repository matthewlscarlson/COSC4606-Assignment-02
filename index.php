<?php
    session_start();

    # Check to see if user is already logged in
    # TODO: is there a better way to do this?
    if (isset($_SESSION['is_logged_in'])) {
        if ($_SESSION['is_logged_in'] == 1) {
            # Redirect to user's home if so; no need to login again
            echo "<script type='text/javascript'>
                    window.location.replace('home.php');
                    </script>";
        }
    } else {
        # If variable is not set, set it with value 0
        $_SESSION['is_logged_in'] = 0;
    }
?>

<!DOCTYPE html>
<html lang='en-CA'>
    <head>
        <title>COSC4426AE-21F: Assignment II - Login</title>
        <?php include 'import/head.html'; ?>
    </head>

    <body>
        <header id='login_header'>
            <h1>COSC4606 Assignment II</h1>
        </header>

        <main>
            <!--<form id='login_form' action='login.php' method='POST'>-->
            <form id='login_form' action=''>
                <label for='user'>Username:</label><br>
                <input type='text' id='user' name='user'><br>
                <label for='pwd'>Password:</label><br>
                <input type='password' autocomplete='off' id='pwd' name='pwd'>
                <input type='checkbox' onclick='toggle()'>Show Password<br>
                <input type='submit' value='Login' id='login'>
            </form>
        </main>
    </body>
    <?php include 'import/js.html'; ?>
    <script type='text/javascript' src='/js/login.js'></script>
</html>
