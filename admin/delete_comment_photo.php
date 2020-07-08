<?php include("includes/init.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");} ?>

<?php
    if(empty($_GET['comment_id'])) {
        redirect("./comments.php");
    }    
 
    $comment = Comment::findById($_GET['comment_id']);

    if($comment) {
        $comment->delete();
        redirect("comment_photo.php?photo_id={$comment->photo_id}");
    } else {
        redirect("comment_photo.php?photo_id={$comment->photo_id}");
    }
?>