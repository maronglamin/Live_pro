<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
// include(ROOT . DS . 'nav.php');
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");

?>
<br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <?php if ($auth_user_role == ADMISSION_USER):?>
                    <?php include(ADMISSION_OFFICER_DASHBOAD); ?>
                <?php endif;?> 
                <?php if ($auth_user_role == PRINCIPAL_USER):?>
                    <?php include(ADMISSION_PRINCIPAL_DASHBOAD); ?>
                <?php endif;?> 
                <?php if ($auth_user_role == TEACHER_USER):?>
                    <?php include(TEACHER_DASHBOAD); ?>
                <?php endif;?> 
            </div>
        </div>
    </div>
</div>
