<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");} ?>

<?php
$users = User::findAll();
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
                    Users
                    <a href="add_user.php" class="btn btn-primary">Add User</a>
                </h1>

                <p class="bg-success"><?php echo $message; ?></p>
                
                <div class="col-md-12">

                    <table class="table table-hover"> <!-- Start of Table -->
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo $user->id; ?>
                                    <div class="action_links">
                                        <a href="delete_user.php?user_id=<?php echo $user->id; ?>">Delete</a>
                                        <a href="edit_user.php?user_id=<?php echo $user->id; ?>">Edit</a>
                                        <a href="#">View</a>
                                    </div>
                                </td>
                                <td><img class="admin-user-thumbnail user_image" src="<?php echo $user->imagePathAndPlaceholder(); ?>" alt=""></td>
                                <td><?php echo $user->username; ?></td>
                                <td><?php echo $user->first_name; ?></td>
                                <td><?php echo $user->last_name; ?></td>
                            </tr>
                        <?php endforeach; ?>       
                        </tbody>
                    </table> <!-- End of Table -->
                    
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>