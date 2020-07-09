<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>

<?php if (!$session->isSignedIn()) {
    redirect("login.php");
} ?>

<?php
$message = "";

if (empty($_GET['user_id'])) {
    redirect("users.php");
}

$user = User::findById($_GET['user_id']);
if (isset($_POST['update'])) {
    if ($user) {
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];
        if (empty($_FILES['user_image'])) {
            $user->save();
        } else {
            $user->setFile($_FILES['user_image']);
            $user->saveUserAndImage();
            $user->save();

            redirect("edit_user.php?user_id={$user->id}");
        }
        $message = "Update Successfully!";
    }
}

?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <?php include("includes/top_nav.php"); ?>

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php include("includes/side_nav.php"); ?>
    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Edit User
                    <small></small>
                </h1>

                <div class="col-md-6">
                    <a href="#" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $user->imagePathAndPlaceholder(); ?>" alt=""></a>
                </div>

                <div class="col-md-6">
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php echo $message; ?>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="user_image">User Image</label>
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <a href="delete_user?user_id=<?php echo $user->id; ?>" class="btn btn-danger">Delete</a>
                        <input type="submit" name="update" class="btn btn-primary" value="Update">
                    </form>
                </div>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>