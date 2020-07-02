<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");} ?>

<?php
$photos = Photo::findAll();
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
                    Photos
                    <small>Subheading</small>
                </h1>
                
                <div class="col-md-12">

                    <table class="table table-hover"> <!-- Start of Table -->
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Id</th>
                                <th>File Name</th>
                                <th>Title</th>
                                <th>Size</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($photos as $photo) : ?>
                            <tr>
                                <td><img src="<?php echo $photo->picturePath(); ?>" alt="">
                                    <div class="pictures_link">
                                        <a href="delete_photo.php?photo_id=<?php echo $photo->id; ?>">Delete</a>
                                        <a href="#">Edit</a>
                                        <a href="#">View</a>
                                    </div>
                                </td>
                                <td><?php echo $photo->id; ?></td>
                                <td><?php echo $photo->filename; ?></td>
                                <td><?php echo $photo->title; ?></td>
                                <td><?php echo $photo->size; ?></td>
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