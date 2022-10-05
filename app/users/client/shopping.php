<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './harbStore/core/connection/init.php';

if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Shopping cart page");
}
if ($user_data['user_role'] !== CLIENT_USER) {
    login_error_redirect(PROOT . "index.php", "Client Pages");
}
include(ROOT . DS . 'nav.php');
$id = $user_data['user_id'];

$carts = $db->query("SELECT `h`.`name`, `h`.`remedy`, `h`.`price`, `h`.`descr`, `h`.`photo_url`,`h`.`id`, `s`.`paid`, `s`.`date_added` FROM `herbs` `h`, `shopping_cart` `s` WHERE `s`.`user_id` = '{$id}' AND `h`.`id` = `s`.`herb_id`");

?>
<br><br>
<div class="container-fuid">
    <div class="container">
        <h2 class="text-secondary">Harbical Drug Store</h2>
        <p text-primary>Herbical drugs that are effective in curing a described disease</p>
        <div class="col">
            <div class="grid">
                <div class="well" style="background-color: #fff;">
                    <h2 class="text-center">Your Shopping Cart</h2>
                    <div class="row">
                        <?php while ($cart = mysqli_fetch_assoc($carts)) :
                            $hid = $cart['id'];
                            $uid = $user_data['user_id'];
                            $checks = $db->query("SELECT * FROM `shopping_cart` WHERE `herb_id` = '{$hid}' AND `user_id` = '{$uid}' AND `paid` = '1'");
                            $checked = mysqli_fetch_assoc($checks);
                        ?>
                            <div class="col">
                                <div class="col-md-4">
                                    <h3 class="text-center fst-bold"><?= $cart['name'] ?></h3>
                                    <div>
                                        <img class="herb-img-detail" src="<?= PROOT . 'app/' . $cart['photo_url'] ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3 class="text-center">Description</h3>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><Strong>Herb's Name</Strong>: <?= $cart['name'] ?><span class="badge pull-right">Price: <?= $cart['price'] ?></span> </li>
                                        <li class="list-group-item"><Strong>Remedy For: </Strong> <?= $cart['remedy'] ?></li>
                                        <li class="list-group-item"><Strong>Date Added to Shopping cart:</Strong> <?= month_format($cart['date_added']) ?></li>
                                        <li class="list-group-item"><Strong>Description:</Strong><br>
                                            <?= $cart['descr'] ?><br><br>
                                            <?php if ($checked == EMPTY_VALUE) : ?>
                                                <form class="pay" action="<?= PROOT ?>vendor/process.php?id=<?= $cart['id'] ?>&userid=<?= $id ?>" method="POST">
                                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?= STRIPE_PKEY ?>" data-amount="<?= ((int)$cart['price'] * 100) ?>" data-name="Herbical Products" data-description="<?= $cart['name'] ?>" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto" data-zip-code="true" data-currency="usd">
                                                    </script>
                                                </form>
                                            <?php else : ?>
                                                <button class="btn btn-success">Product Charged</button>
                                                <span>Paid on <strong><?= time_mm($cart['date_added']) ?></strong></span>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(ROOT . DS . "core" . DS . "resource" . DS . "script.php");
