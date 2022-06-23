<?php
    # The recommended way to destroy a session, from php.net

    session_start();

    # Remove session variables with empty array
    $_SESSION = array();

    # Get session cookie
    if (ini_get('session.use_cookies')) {
        # Remove session and session data
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }

    # Destroy session
    session_destroy();
?>
