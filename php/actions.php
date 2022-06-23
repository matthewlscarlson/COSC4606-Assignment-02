<?php
    # TODO: Remove code duplication if time permits
    #       This is difficult to do because prepared
    #       statements have different inputs
    session_start();

    $root = realpath($_SERVER['DOCUMENT_ROOT']);
    include "$root/php/db.php";

    require('fpdf.php');

    # Form input passed in as POST variables
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $db = Database::get_connection();

        # Special variable passed in that tells what action to do
        $action = $_POST['action'];

        switch ($action) {
            # Summaries for Students and Instructors
            case 'my_summary':                my_summary($db);
                                              break;
            case 'my_courses_form':           my_courses($db);
                                              break;
            # Forms for Registrars/Admins
            case 'add_faculty_form':          add_faculty($db);
                                              break;
            case 'register_student_form':     register_student($db);
                                              break;
            case 'assign_faculty_form':       assign_faculty($db);
                                              break;
            case 'enroll_form':               enroll($db);
                                              break;
            case 'drop_form':                 drop($db);
                                              break;
            case 'change_grade_form':         change_grade($db);
                                              break;

            # Reports for Registars/Admins
            case 'student_transcript_form':   student_transcript($db);
                                              break;
            case 'class_list_form':           class_list($db);
                                              break;
            case 'students_in_degree_form':   students_in_degree($db);
                                              break;
            case 'students_instructors_form': students_instructors($db);
                                              break;
            case 'courses_taught_form':       courses_taught($db);
                                              break;

            # User Management for Admins
            case 'add_user_form':             add_user($db);
                                              break;
            case 'delete_user_form':          delete_user($db);
                                              break;
            case 'modify_user_form':          modify_user($db);
                                              break;
            case 'view_users':                view_users($db);
                                              break;
        }
    }

    function my_summary($db) {
        $stmt = $db -> prepare("SELECT ID FROM Users WHERE UserName=?;");

        $stmt->bind_param('s', $_SESSION['user']);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($rows = mysqli_fetch_assoc($result))
            $uid = $rows['ID'];

        $stmt = $db -> prepare("SELECT * FROM Enrollments WHERE StudentID=?;");

        $stmt->bind_param('i', $uid);

        $stmt->execute();

        report($stmt, "Summary for $_SESSION[user]");
    }

    function my_courses($db) {
        $stmt = $db -> prepare("SELECT Enrollments.StudentID, Students.GivenName, Students.Surname, Enrollments.CourseCode, Enrollments.Section, Enrollments.Term, Enrollments.Year, Students.InCOOP FROM Enrollments, Students WHERE Enrollments.CourseCode = ? AND Enrollments.Section = ? AND Enrollments.Term = ? AND Enrollments.Year = ? AND Enrollments.StudentID = Students.StudentID ORDER BY Students.Surname;");

        # Convert course data into variables
        $full_code = $_POST['course'];
        $tokens = explode(' ', $full_code);
        $array = array();
        $i = 0;
        foreach($tokens as $token){
            $array[$i] = $token;
            $i++;
        }
        $code    = $array[0];
        $section = $array[1];
        $term    = $array[2];
        $year    = $array[3];

        $stmt->bind_param('sssi', $code, $section, $term, $year);

        report($stmt, "Class List for $code$section-$term");
    }

    # Forms
    function add_faculty($db) {
        $stmt = $db -> prepare("INSERT INTO Faculty (FacultyID, GivenName, Surname, HomePhoneNum) VALUES (?, ?, ?, ?);");

        $faculty_id = $_POST['faculty_id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $home_phone_num = $_POST['home_phone_num'];

        $stmt->bind_param('isss', $faculty_id, $name, $surname, $home_phone_num);

        $stmt->execute();

        $full_name = "$name $surname";

        $msg = '';
        # If table was actually modified, it means that the SQL query ran successfully
        if ($db->affected_rows > 0)
            $msg=$full_name.' added to faculty';
        else
            $msg='Failed to add to faculty';

        echo $msg;
    }
    function register_student($db) {
        $stmt = $db -> prepare("INSERT INTO Students (StudentID, GivenName, Surname, PhoneNumber, InCOOP, Degree) VALUES (?, ?, ?, ?, ?, ?);");

        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone_num = $_POST['phone_num'];
        $coop = $_POST['coop'];
        $degree = $_POST['degree'];

        $stmt->bind_param('isssis', $student_id, $name, $surname, $phone_num, $coop, $degree);

        $stmt->execute();

        $full_name = "$name $surname";

        $msg = '';
        if ($db->affected_rows > 0)
            $msg=$full_name.' registered into system';
        else
            $msg='Failed to register into system';

        echo $msg;
    }
    function assign_faculty($db) {
        $stmt = $db -> prepare("INSERT INTO Instructors (FacultyID, CourseCode, Section, Term, Year) VALUES (?, ?, ?, ?, ?);");

        $faculty_id = $_POST['faculty_id'];
        $code = $_POST['code'];
        $section = $_POST['section'];
        $term = $_POST['term'];
        $year = $_POST['year'];

        $stmt->bind_param('isssi', $faculty_id, $code, $section, $term, $year);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0) {
            $msg=$faculty_id." is now instructor for $code$section-$term";

            # Update Users table to reflect this change
            $stmt = "UPDATE Users SET Role = 'Instructor' WHERE ID=$faculty_id;";
            $query = $db->query($stmt);
        }
        else
            $msg="Failed to make instructor";

        echo $msg;
    }
    function enroll($db) {
        $stmt = $db -> prepare("INSERT INTO Enrollments (StudentID, CourseCode, Section, Term, Year, Mark, Status) VALUES (?, ?, ?, ?, ?, 0, 'In Progress');");

        $student_id = $_POST['student_id'];
        $code = $_POST['code'];
        $section = $_POST['section'];
        $term = $_POST['term'];
        $year = $_POST['year'];

        $stmt->bind_param('isssi', $student_id, $code, $section, $term, $year);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0)
            $msg=$student_id." enrolled in $code$section-$term";
        else
            $msg='Failed to enroll';

        echo $msg;
    }
    function drop($db) {
        $stmt = $db -> prepare("DELETE FROM Enrollments WHERE StudentID = ? AND CourseCode = ? AND Section = ? AND Term = ? AND Year = ?;");

        $student_id = $_POST['student_id'];
        $code = $_POST['code'];
        $section = $_POST['section'];
        $term = $_POST['term'];
        $year = $_POST['year'];

        $stmt->bind_param('isssi', $student_id, $code, $section, $term, $year);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0)
            $msg=$student_id." dropped from $code$section-$term";
        else
            $msg='Failed to drop';

        echo $msg;
    }
    function change_grade($db) {
        $stmt = $db -> prepare("UPDATE Enrollments SET Mark = ?, STATUS = ? WHERE StudentID = ? AND CourseCode = ? AND Section = ? AND Term = ? AND Year = ?;");

        $grade = $_POST['grade'];

        if ($grade < 50)
            $status = 'Failed';
        else
            $status = 'Passed';

        $student_id = $_POST['student_id'];
        $code = $_POST['code'];
        $section = $_POST['section'];
        $term = $_POST['term'];
        $year = $_POST['year'];

        $stmt->bind_param('isisssi', $grade, $status, $student_id, $code, $section, $term, $year);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0)
            $msg='Grade changed for '.$student_id;
        else
            $msg='Grade failed to be changed';

        echo $msg;
    }

    # Reports
    function class_list($db) {
        $stmt = $db -> prepare("SELECT Enrollments.StudentID, Students.GivenName, Students.Surname, Enrollments.CourseCode, Enrollments.Section, Enrollments.Term, Enrollments.Year, Students.InCOOP FROM Enrollments, Students WHERE Enrollments.CourseCode = ? AND Enrollments.Section = ? AND Enrollments.Term = ? AND Enrollments.Year = ? AND Enrollments.StudentID = Students.StudentID ORDER BY Students.Surname;");

        $code = $_POST['code'];
        $section = $_POST['section'];
        $term = $_POST['term'];
        $year = $_POST['year'];

        $stmt->bind_param('sssi', $code, $section, $term, $year);

        report($stmt, "Class List for $code$section-$term");
    }
    function student_transcript($db) {
        $stmt = $db -> prepare("SELECT * FROM Enrollments WHERE StudentID=?;");

        $id = $_POST['id'];

        $stmt->bind_param('i', $id);

        report($stmt, "Summary for Student $id");
    }
    function students_in_degree($db) {
        $stmt = $db -> prepare("SELECT * FROM Students WHERE Students.Degree = ?;");

        $degree = $_POST['degree'];

        $stmt->bind_param('s', $degree);

        report($stmt, "Students in $degree");
    }
    function students_instructors($db) {
        $stmt = $db -> prepare("SELECT Instructors.FacultyID, Instructors.CourseCode, Faculty.GivenName, Faculty.Surname, Faculty.HomePhoneNum FROM Instructors, Faculty, Enrollments WHERE Instructors.FacultyID = Faculty.FacultyID AND Instructors.Term = ? AND Enrollments.StudentID = ? AND Instructors.CourseCode = Enrollments.CourseCode;");
        $student_id = $_POST['student_id'];
        $term = $_POST['term'];

        $stmt->bind_param('si', $term, $student_id);

        report($stmt, "Instructors for Student $student_id in $term");
    }
    function courses_taught($db) {
        $stmt = $db -> prepare("SELECT Instructors.*, Faculty.GivenName, Faculty.Surname FROM Instructors, Faculty WHERE Instructors.FacultyID = Faculty.FacultyID AND Instructors.FacultyID = ? AND Instructors.Term = ? ORDER BY Instructors.CourseCode;");

        $faculty_id = $_POST['faculty_id'];
        $term = $_POST['term'];

        $stmt->bind_param('is', $faculty_id, $term);

        report($stmt, "Courses Taught by Faculty Member $faculty_id in $term");
    }

    function report($stmt, $title) {
        # Execute SQL and get result
        $stmt->execute();
        $result = $stmt->get_result();

        # Create PDF with one page (just one should suffice for our purposes)
        $pdf = new FPDF();
        $pdf->AddPage();

        # Convert results into columnar array
        $columns=array();
        while ($rows = mysqli_fetch_assoc($result)) {
            $attrs = array_keys($rows);
            for ($i = 0; $i < count($attrs); $i++) {
                $temp = $rows[$attrs[$i]];
                $columns[$i]=$columns[$i].$temp."\n";
            }
        }

        # Display title
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(80);
        $pdf->Cell(30, 10, $title, 0 , 0, 'C');
        $pdf->Ln(20);

        $pdf->SetFont('Arial', 'B', 12);

        # Print column attributes
        for ($i = 0; $i < count($attrs); $i++) {
            $pdf->SetY(20);
            $pdf->SetX($i * 31);
            $pdf->MultiCell(31, 10, $attrs[$i], 1);
        }

        # Print actual column values
        for ($i = 0; $i < count($columns); $i++) {
            $pdf->SetY(30);
            $pdf->SetX($i * 31);
            $pdf->MultiCell(31, 10, $columns[$i], 1);
        }

        # Save pdf to php server and echo URL
        # URL is then opened in new tab by JavaScript
        $pdf->Output('../report.pdf', 'F');
        $url = "http://".$_SERVER["HTTP_HOST"]."/report.pdf";
        echo $url;
    }

    # Manage Users
    function add_user($db) {
        $stmt = $db -> prepare("INSERT INTO Users (ID, UserName, Password, Role) VALUES (?, ?, ?, ?);");

        $uid = $_POST['uid'];
        $user = $_POST['user'];

        $pwd = $_POST['pwd'];
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);

        $role = $_POST['role'];

        $stmt->bind_param('isss', $uid, $user, $pwd, $role);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0)
            $msg=$user.' added to the system';
        else
            $msg='User failed to be added to the system';

        echo $msg;
    }
    function delete_user($db) {
        $stmt = $db -> prepare("DELETE FROM Users WHERE ID = ?;");
        $uid = $_POST['uid'];

        $stmt->bind_param('i', $uid);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0)
            $msg="ID $uid deleted from the system";
        else
            $msg='User failed to be removed from the system';

        echo $msg;
    }
    function modify_user($db) {
        $stmt = $db -> prepare("UPDATE Users SET ID = ?, UserName = ?, Password = ?, Role = ? WHERE ID = ?");

        $uid = $_POST['uid'];
        $user = $_POST['user'];

        $pwd = $_POST['pwd'];
        # Hash password using BCRYPT
        # Admin does not actually know user's password --- this is good for security
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);

        $role = $_POST['role'];

        $stmt->bind_param('isssi', $uid, $user, $pwd, $role, $uid);

        $stmt->execute();

        $msg = '';
        if ($db->affected_rows > 0)
            $msg='Information changed for '.$uid;
        else
            $msg='Information failed to be changed';

        echo $msg;
    }
    function view_users($db) {
        $stmt = $db -> prepare("SELECT ID, UserName, Role FROM Users;");

        report($stmt, 'Users');
    }
?>
