<?php include("includes/init.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");} ?>

<?php
    if(empty($_GET['user_id'])) {
        redirect("./users.php");
    }    

    $user = User::findById($_GET['user_id']);

    if($user) {
        $user->delete();
        redirect("users.php");
    } else {
        redirect("users.php");
    }
?>