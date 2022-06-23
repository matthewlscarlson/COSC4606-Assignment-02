<?php
    session_start();

    $root = realpath($_SERVER['DOCUMENT_ROOT']);
    include "$root/php/db.php";

    # Here, check to see if user is NOT logged in
    if (isset($_SESSION['is_logged_in'])) {
        if ($_SESSION['is_logged_in'] == 0) {
            # Redirect to login screen if not; access to home is forbidden
            echo "<script type='text/javascript'>
            window.location.replace('index.php');
            </script>";
        }
    } else {
        echo "<script type='text/javascript'>
            window.location.replace('index.php');
            </script>";
    }

    $db = database::get_connection();

    function get_role($db) {
        $stmt = $db -> prepare("SELECT Role FROM Users WHERE UserName=?;");

        $stmt->bind_param('s', $_SESSION['user']);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($rows = mysqli_fetch_assoc($result))
            $role = $rows['Role'];

        return $role;
    }

    $_SESSION['role'] = get_role($db);

?>

<!DOCTYPE html>
<html lang='en-CA'>
    <head>
        <title>COSC4426AE-21F: Assignment II - Home</title>
        <?php include 'import/head.html'; ?>
        <!--Get role as JS var so we can display the appropriate actions for user-->
        <script type='text/javascript'>
            role = "<?php echo $_SESSION['role']; ?>";
        </script>
    </head>

    <body>
        <header id='header'>
        <h1>Welcome, <?php echo "$_SESSION[user]"; ?>!</h1>
            <div id='header_options'>
                <a href='#' id='actions'>Actions</a>
                <a href='#' id='logout'>Logout</a>
            </div>
        </header>

        <main>
            <div id='nav' class='nav'>
                <a href='javascript:void(0)' class='exit' onclick='exit()'>&times;</a>
                <ul>
                    <!--Students can view their academic summary-->
                    <?php if ($_SESSION['role'] == 'Student') { ?>
                        <li>
                            <h1>Reports</h1>
                            <ul>
                                <a href='#' class='action' id='my_summary'><li>My Summary</li></a>
                            </ul>
                        </li>
                    <?php } ?>

                    <!--Instructors can view their courses-->
                    <?php if ($_SESSION['role'] == 'Instructor') { ?>
                        <li>
                            <h1>Reports</h1>
                            <ul>
                                <a href='#' class='action' id='my_courses'><li>My Courses</li></a>
                            </ul>
                        </li>
                    <?php } ?>

                    <!--Both admins and registrars can access the forms and reports-->
                    <?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Registrar') { ?>
                        <li>
                            <h1>Forms</h1>
                            <ul>
                                <a href='#' class='action' id='add_faculty'><li>Add Faculty Member</li></a>
                                <a href='#' class='action' id='register_student'><li>Register Student</li></a>
                                <a href='#' class='action' id='assign_faculty'><li>Assign Faculty Member to Teach</li></a>
                                <a href='#' class='action' id='enroll'><li>Enroll Student in Course</li></a>
                                <a href='#' class='action' id='drop'><li>Drop Student from Course</li></a>
                                <a href='#' class='action' id='change_grade'><li>Change Grade</li></a>
                            </ul>
                        </li>

                        <li>
                            <h1>Reports</h1>
                            <ul>
                                <a href='#' class='action' id='class_list'><li>Class List</li></a>
                                <a href='#' class='action' id='student_transcript'><li>Student Transcript</li></a>
                                <a href='#' class='action' id='students_in_degree'><li>Students in Degree Program</li></a>
                                <a href='#' class='action' id='students_instructors'><li>Student's Instructors</li></a>
                                <a href='#' class='action' id='courses_taught'><li>Courses Taught by Instructor</li></a>
                            </ul>
                        </li>
                    <?php } ?>

                    <!--Only admins can manage user accounts -->
                    <?php if ($_SESSION['role'] == 'Admin') { ?>
                        <li>
                            <h1>Manage Users</h1>
                            <ul>
                                <a href='#' class='action' id='add_user'><li>Add User</li></a>
                                <a href='#' class='action' id='delete_user'><li>Delete User</li></a>
                                <a href='#' class='action' id='modify_user'><li>Modify User</li></a>
                                <a href='#' class='action' id='view_users'><li>View Users</li></a>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div id='main'>
            <!--Form inserted here via JavaScript-->
            </div>
        </main>

        <footer>
        </footer>
    </body>

    <?php include 'import/js.html'; ?>
    <script type='text/javascript' src='/js/actions.js'></script>
    <script type='text/javascript' src='/js/logout.js'></script>
    <script type='text/javascript' src='/js/nav.js'></script>
</html>
