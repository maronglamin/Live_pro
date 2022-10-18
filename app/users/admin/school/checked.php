<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
$json_pri = [];
$json_sec = [];

if(isset($POST['assigned'])) {
    foreach($_POST['checked-class-id'] as $primary) {
        $json_pri[] .= $primary;
    }
    foreach($_POST['checked-class'] as $secondary) {
        $json_sec[] .= $secondary;
    }
    dnd($json_pri);
}
?>