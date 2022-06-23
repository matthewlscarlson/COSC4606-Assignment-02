<html lang='en-CA'>
    <h1>My Courses</h1>
    <form class='action_form' id='my_courses_form' action=''>
        <label for='course'>Course:</label><br>

        <?php
            session_start();

            $root = realpath($_SERVER['DOCUMENT_ROOT']);
            include "$root/php/db.php";

            $db = database::get_connection();

            # Don't care about prepared statements here since no input
            $stmt = "SELECT ID From Users WHERE UserName='$_SESSION[user]'";
            $query = $db->query($stmt);
            $result = mysqli_fetch_assoc($query);

            # Get courses taught by instructor
            $stmt = "SELECT CourseCode, Section, Term, Year FROM Instructors WHERE FacultyID=$result[ID];";
            $query = $db->query($stmt);
            while ($results[] = mysqli_fetch_object($query));
            array_pop($results);
        ?>

        <!--Show instructor's courses in drop-down-->
        <select id='course' name='course'>
            <?php foreach ( $results as $option ) : ?>
                <option value="<?php echo "$option->CourseCode $option->Section $option->Term $option->Year"; ?>"><?php echo "$option->CourseCode$option->Section-$option->Term"; ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type='submit' value='Generate Class List'>
    </form>
</html>
