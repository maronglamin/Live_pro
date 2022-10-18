<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';

if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Admission letter");
}
if (!($auth_user_role == ADMISSION_USER || $auth_user_role == PRINCIPAL_USER)) {
    login_redirect();
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");
if (isset($_GET['view'])) {

?>
<div class="container-fluid">
<br><br><br>
<section>
    <div class="col">
        <div class="container">
            <div class="col-md-6">
                <h2 class="text-secondary">School Offer letter</h2>
                <p>Register your students on the currently opened academic
                    admission year.To enroll a student in a different academic
                    year, re-open the perticular admission date.</p>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="card p-5">
        <div id="page-layout" style="margin: 25px auto;">
            <h3 class="text-center text-secondary">Admission letter</h3>
            <h5 class="text-end text-secondary">Yalding Basic Cycle school</h5>
            <h5 class="text-start text-secondary">Sept 12, 2022</h5><br>
            <p class="text-secondary">Student Name <br> Student Number</p>
            <h5 class="text-center text-secondary text-underlined">OFFER OF ADMISSION</h5>

            <p class="text-secondary">
                I write to inform you that you are enrolled as a student in <strong>Yalding Basic Cycle School In farato.</strong>
            </p>
            <p class="text-secondary">
                You are admitted to class/grade and school will commence on 22 sept 2022.
            </p>
        </div>
            <button class="btn btn-outline-dark" type="button" onClick="printElement('page-layout', 'Afang School app')">Enroll</button>
    </div>
</div>
</div>

<?php } ?>


<script>
    function printElement(elem, title) {
        // var css = '<link rel="stylesheet" href="schoolapp/css/custom.min.css">';
        var popup = window.open('', '_blank', `width=${window.innerWidth}, height=${window.innerHeight}`);

        popup.document.write('<html><head><link rel="stylesheet" href="css/custom.min.css"><title>' + title + '</title>');
        popup.document.write('<style></style>');
        popup.document.write('</head><body>');
        popup.document.write(document.getElementById(elem).innerHTML);
        popup.document.write('</body></html>');

        popup.document.close();
        popup.focus();

        popup.print();
        popup.close();

        return true;
    }
</script>