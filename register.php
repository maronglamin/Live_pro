<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/schoolapp/core/init.php';

$reg_name = ((isset($_POST['name'])) ? sanitize($_POST['name']) : '');
$reg_user_name = ((isset($_POST['user_name'])) ? sanitize($_POST['user_name']) : '');
$reg_email = ((isset($_POST['email'])) ? sanitize($_POST['email']) : '');
$reg_roles = "2";
$reg_password = ((isset($_POST['password'])) ? sanitize($_POST['password']) : '');
$reg_password_confirm = ((isset($_POST['password_confirmed'])) ? sanitize($_POST['password_confirmed']) : '');

$reg_password = trim($reg_password);
$reg_password_confirm = trim($reg_password);

?>

<div class="login-container">
    <div class="card">
        <div class="card-header">
            <h3 class="text-center text-warning">SIGN UP</h3><br>
        </div>
        <div class="container">
            <?php
            if ($_POST) {

                $emailQuery = $db->query("SELECT * FROM users WHERE email = '{$reg_email}' ");
                $emailCount = mysqli_num_rows($emailQuery);

                $userQuery = $db->query("SELECT * FROM users WHERE `user_name` = '{$reg_user_name}'");
                $userCount = mysqli_num_rows($userQuery);

                if ($emailCount != 0) {
                    $errors[] = 'That email exist in our database';
                }

                if ($userCount != 0) {
                    $errors[] = 'That user name exist in our database';
                }

                $required = array('name', 'email', 'user_name', 'password', 'password_confirmed');
                foreach ($required as $fields) {
                    if ($_POST[$fields] == '') {
                        $errors[] = 'You must fill out all fields.';
                        break;
                    }
                }
                if (strlen($reg_password) < 6) {
                    $errors[] = 'The password must be at least 6 characters.';
                }
                if ($reg_password != $reg_password_confirm) {
                    $errors[] = 'Your password does not match the confirmation';
                }
                if (!empty($errors)) {
                    echo display_errors($errors);
                } else {
                    // add user
                    $hashed = password_hash($reg_password, PASSWORD_DEFAULT);
                    $db->query("INSERT INTO users (`full_name`, `email`, `user_name`, `password`, `user_role`) VALUES('$reg_name','$reg_email', '$reg_user_name', '$hashed', $reg_roles)");
                    $_SESSION['success_mesg'] = 'Registration successful.';
                    redirect(PROOT . 'login.php');
                }
            }
            ?>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group mt-3">
                    <input type="text" name="name" id="name" placeholder="Full name" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="user_name" id="user_name" placeholder="username" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <input type="email" name="email" id="email" placeholder="Email address" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="password_confirmed" id="password_confirmed" placeholder="Confirm password" class="form-control">
                </div>
                <div class="mt-2 mb-1">
                    <input class="btn btn-primary" type="submit" value="Register">
                    <a href="<?= PROOT ?>index.php" class="btn btn-danger">Cancel</a>
                    <p>Have an account! <a href="<?= PROOT ?>index.php">Sign in</a></p>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>


<div class="file-card">
    <div class="file-input">
        <input type="file" name="photo" id="photo">
        <button class="button">Select File</button>
    </div>
    <p class="info">Supported files PNG, JPEG, JPG </p>
</div>

<div class="col-md-12 user-img mt-5">
    <?php while ($photo = mysqli_fetch_assoc($photo_upload)) : ?>
        <img src="<?= PROOT ?>app/<?= $photo['stud_prof_photo_url'] ?>" class="user-img d-block m-auto mb-2" />
    <?php endwhile; ?>
</div>

.file-card {
background-color: #edf2f7;
border: 3px dashed #cbd5e0;
padding: 0.1em;
min-width: 280px;
min-height: 95px;
display: flex;
justify-content: center;
align-items: center;
flex-direction: column;
margin-bottom: 20px;
}
.file-input {
position: relative;
margin-bottom: 1.5rem;
}
input {
position: relative;
max-width: 200px;
height: 46px;
z-index: 2;
cursor: pointer;
opacity: 0;
}
button.button {
position: absolute;
top: 0;
left: 0px;
width: 100%;
height: 100%;
margin-top: 10px;
z-index: 1;
display: flex;
justify-content: center;
align-items: center;
color: #fff;
background-color: #f55e30;
font-size: 1.1rem;
cursor: pointer;
border-radius: 4px;
border: none;
transition: background-color 0.4s;
box-shadow: 0px 8px 24px rgba(149, 157, 165, 0.5);

}



<?php if ($photo_resp != NULL) : ?>
    