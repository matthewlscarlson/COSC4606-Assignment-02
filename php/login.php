<?php
    if (!isset($_SERVER['HTTP_REFERER'])){
        header('location: /index.php');
        exit;
    }

    session_start();

    $root = realpath($_SERVER['DOCUMENT_ROOT']);
    include "$root/php/db.php";

    function connect() {
        # POST via HTML form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            # Connect using root, user will have a "session"
            $db = Database::get_connection();

            verify_user($db);
        }
    }

    # See if user even exists in database
    function verify_user($db) {
        # Fetch user from Users table
        $user_query = "SELECT Username FROM Users WHERE UserName='$_POST[user]'";
        $get_user = mysqli_query($db, $user_query);

        # User exists if row returned
        $user_rows = mysqli_num_rows($get_user);
        if ($user_rows > 0) verify_pass($db); else echo 'User not found';
    }

    # Verify the password stored using BCRYPT hash algorithm
    function verify_pass($db) {
        # Get password hash associated with the user
        # Stored as CHAR(61) in the database and is generated when somebody with administrator privileges creates user
        $pass_query = "SELECT Password FROM Users WHERE UserName = '$_POST[user]'";
        $get_pass = mysqli_query($db, $pass_query);
        $result = mysqli_fetch_assoc($get_pass);
        $hash = $result['Password'];

        # Verify the hash using password_verify
        if (password_verify($_POST['pwd'], $hash)) {
            # We can now store POST variables as SESSION
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['pwd']  = $_POST['pwd'];

            # User is now logged in
            # Keep this in session variable so we can skip login page if already logged in
            $_SESSION['is_logged_in'] = 1;
        }
        else echo 'Password incorrect';
    }

    connect();
?>
