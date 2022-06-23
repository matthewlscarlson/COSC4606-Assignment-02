/* Show action */
$(document).ready(function() {
    $('.action').click(function() {
        switch (this.id) {
            case 'my_summary': my_summary(this.id);
                               break;
            case 'view_users': view_users(this.id);
                               break;
            default:           if (this.id == 'my_courses') ext='php';
                               else                         ext='html';

                               /* Actions contained in /actions/ */
                               let form = '../actions/' + this.id + '.' + ext;
                               /* Load html into main div */
                               $('#main').load(form);
        }
    });
});

/* Student transcript */
$(document.body).on('submit', '.action_form', function(e) {
    /* Don't change page, just in case login fails */
    e.preventDefault();

    switch (this.id) {
        case 'my_courses_form':           my_courses(this.id);
                                          break;

        /* Forms */
        case 'add_faculty_form':          add_faculty(this.id);
                                          break;
        case 'register_student_form':     register_student(this.id);
                                          break;
        case 'assign_faculty_form':       assign_faculty(this.id);
                                          break;
        case 'enroll_form':               enroll(this.id);
                                          break;
        case 'drop_form':                 drop(this.id);
                                          break;
        case 'change_grade_form':         change_grade(this.id);
                                          break;

        /* Reports */
        case 'student_transcript_form':   student_transcript(this.id);
                                          break;
        case 'class_list_form':           class_list(this.id);
                                          break;
        case 'students_in_degree_form':   students_in_degree(this.id);
                                          break;
        case 'students_instructors_form': students_instructors(this.id);
                                          break;
        case 'courses_taught_form':       courses_taught(this.id);
                                          break;

        /* Manage Users */
        case 'add_user_form':             add_user(this.id);
                                          break;
        case 'delete_user_form':          delete_user(this.id);
                                          break;
        case 'modify_user_form':          modify_user(this.id);
                                          break;
    }
})

/* Academic summary for students */
function my_summary(task) {
   $.post('/php/actions.php', { action : task },
       function(url) { open_url(url); }
   );
}

/* Class lists for instructors */
function my_courses(task) {
    $.post('/php/actions.php', { action : task,
                                 course : $('#course').val() },
        function(url) { open_url(url); }
    );
}

/* Forms */
function add_faculty(task) {
    $.post('/php/actions.php', { action         : task,
                                 faculty_id     : $('#faculty_id').val(),
                                 name           : $('#name').val(),
                                 surname        : $('#surname').val(),
                                 home_phone_num : $('#home_phone_num').val() },
        function(msg) { alert(msg); }
    );
}
function register_student(task) {
    if ($('#coop').attr('type') === 'checkbox' )
        is_in_coop = +$('#coop').is(':checked');

    $.post('/php/actions.php', { action     : task,
                                 student_id : $('#student_id').val(),
                                 name       : $('#name').val(),
                                 surname    : $('#surname').val(),
                                 phone_num  : $('#phone_num').val(),
                                 coop       : is_in_coop,
                                 degree     : $('#degree').val() },
        function(msg) { alert(msg); }
    );
}
function assign_faculty(task) {
    $.post('/php/actions.php', { action    : task,
                                 faculty_id : $('#faculty_id').val(),
                                 code       : $('#code').val(),
                                 section    : $('#section').val(),
                                 term       : $('#term').val(),
                                 year       : $('#year').val() },
        function(msg) { alert(msg); }
    );
}
function enroll(task) {
    $.post('/php/actions.php', { action     : task,
                                 student_id : $('#student_id').val(),
                                 code       : $('#code').val(),
                                 section    : $('#section').val(),
                                 term       : $('#term').val(),
                                 year       : $('#year').val() },
        function(msg) { alert(msg); }
    );
}
function drop(task) {
    $.post('/php/actions.php', { action     : task,
                                 student_id : $('#student_id').val(),
                                 code       : $('#code').val(),
                                 section    : $('#section').val(),
                                 term       : $('#term').val(),
                                 year       : $('#year').val() },
        function(msg) { alert(msg); }
    );
}
function change_grade(task) {
    $.post('/php/actions.php', { action : task,
                                student_id : $('#student_id').val(),
                                code       : $('#code').val(),
                                section    : $('#section').val(),
                                term       : $('#term').val(),
                                year       : $('#year').val(),
                                grade      : $('#grade').val() },
        function(msg) { alert(msg); }
    );
}

/* Reports */
function class_list(task) {
    $.post('/php/actions.php', { action  : task,
                                 code    : $('#code').val(),
                                 section : $('#section').val(),
                                 term    : $('#term').val(),
                                 year    : $('#year').val() },
        function(url) { open_url(url); }
    );
}
function student_transcript(task) {
    $.post('/php/actions.php', { action : task,
                                 id     : $('#student_id').val() },
        function(url) { open_url(url); }
    );
}
function students_in_degree(task) {
    $.post('/php/actions.php', { action : task,
                                 degree : $('#degree').val() },
        function(url) { open_url(url); }
    );
}
function students_instructors(task) {
    $.post('/php/actions.php', { action     : task,
                                 student_id : $('#student_id').val(),
                                 term       : $('#term').val() },
        function(url) { open_url(url); }
    );
}
function courses_taught(task) {
    $.post('/php/actions.php', { action     : task,
                                 faculty_id : $('#faculty_id').val(),
                                 term       : $('#term').val() },
        function(url) { open_url(url); }
    );
}

/* Manage Users */
function add_user(task) {
    $.post('/php/actions.php', { action : task,
                                 uid    : $('#uid').val(),
                                 user   : $('#user').val(),
                                 pwd    : $('#pwd').val(),
                                 role   : $('#role').val() },
        function(msg) { alert(msg); }
    );
}
function delete_user(task) {
    $.post('/php/actions.php', { action : task,
                                 uid    : $('#uid').val() },
        function(msg) { alert(msg); }
    );
}
function modify_user(task) {
    $.post('/php/actions.php', { action : task,
                                 uid    : $('#uid').val(),
                                 user   : $('#user').val(),
                                 pwd    : $('#pwd').val(),
                                 role   : $('#role').val() },
        function(msg) { alert(msg); }
    );
}
function view_users(task) {
    $.post('/php/actions.php', { action : task },
        function(url) { open_url(url); }
    );
}

/* Open a url in a new tab */
function open_url(url) {
    Object.assign(document.createElement('a'), {
    target: '_blank',
    href: url,
    }).click();
}
