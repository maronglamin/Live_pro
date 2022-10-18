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
   $id = (int)sanitize($_GET['view']);

   $enrolled_data = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$id}'");
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
    <div class="card pt-1 ps-5 px-5" style="margin: 2px auto;">
        <?php while($enrolled = mysqli_fetch_assoc($enrolled_data)):?>
        <div id="page-layout">
            <h3 class="text-center text-secondary">Yalding Basic Cycle School <br>Kombo South, Farato</h3>
            <h5 class="text-start text-secondary">Enrolled Date: <br><?=mm_yy($enrolled['stud_enroll_yr'])?></h5><br>
            <p class="text-secondary"><?=cap($enrolled['stud_name'])?> <br> SN<?=$enrolled['stud_id']?> </p>
            <h5 class="text-center text-secondary"><strong>OFFER OF ADMISSION</strong></h5>

            <p class="text-secondary">
                I write to inform you that you are enrolled as a student in <strong>Yalding Basic Cycle School In farato.</strong>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores tenetur explicabo voluptatem possimus? Aut aliquid distinctio alias iste,
                necessitatibus autem impedit, modi perferendis quo saepe error, iure id natus officia.
            </p>
            <p class="text-secondary">
                You are admitted to <Strong>grade Seven</Strong>  of the school. Dolores tenetur explicabo voluptatem possimus? Aut aliquid distinctio alias iste,
                necessitatibus autem impedit, modi perferendis quo saepe error, iure id natus officia.
            </p>
            <p class="text-secondary">
                please accept my congraduations. Dolores tenetur explicabo voluptatem possimus? Aut aliquid distinctio alias iste,
                necessitatibus autem impedit, modi perferendis quo saepe error, iure id natus officia.
            </p>
            <p class="text-secondary">
                Yours sincerely, <br><br>
                ........................ <br>
                Principal.
            </p>
        </div>
        <div class="col">
        <button class="btn btn-outline-dark" type="button" onClick="printElement('page-layout', '<?=$enrolled['stud_name'] .'__SN'. $enrolled['stud_id'] .'__Admission__letter'?>')">Print</button>
        </div>
        <?php endwhile;?>
        </div>
</div>
</div>

<?php } ?>


<script>
    function printElement(elem, title) {
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