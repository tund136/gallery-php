<?php require_once("init.php"); ?>

<?php
    $user = new User();
    if(isset($_POST['image_name'])) {
        $user->ajaxSaveUserImage($_POST['image_name'], $_POST['user_id']);
    }
?>
