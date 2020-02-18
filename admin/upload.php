<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

<?php 

    $message = "";
    $photos_lnk = " <a href='photos.php'>View photos</a>";
    
    create_photo();

    // try to use the post-redirect-get pattern
    // !!! wrong way should be improved the Get msg !!! 
    // comes from create_photo() function in functions.php
    if(isset($_GET['msg'])){
        $message = $_GET['msg'];
        $message .= $photos_lnk; 
    }
?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include("includes/top-nav.php"); ?>
            
            
            
            
            
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->            
            <?php include("includes/side-nav.php"); ?>
           
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

                 <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            ADMIN
                            <small>UPLOAD</small>
                        </h1>
                        <div class="col-md-6 col-md-offset-3">
                            <?php echo "<h3> $message </h3>"; ?>
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="title">Photo title</label>
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="title">Photo Caption</label>
                                    <input type="text" name="caption" class="form-control">
                                </div>


                                <div class="form-group">

                                    <label for="description">Photo Description</label>
                                    <textarea name="description" id="editor" cols="30" rows="10" class="form-control">
                                    </textarea>
                                </div>
                                
                                <div class="form-group">

                                    <label for="description">Photo Upload</label>
                                    <input type="file" name="file_upload" >
                                </div>

                                <div class="form-group">
                                    <label for="title">Alternate Text</label>
                                    <input type="text" name="alternate_text" class="form-control">
                                </div>
                                <input class="btn btn-primary pull-right" type="submit" name="submit">

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
  
 
<!-- List of features to add in future -->




<!-- 

    ----------
    TODO List:
    ----------


        1. If you want to add drag drop upload functionality to add mulitple photos at once look up here "212. Installing a Multiple Upload and Drop JS File Plugin Part #3 - COMPLETE"
-->