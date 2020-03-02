<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>
<? Utilities_CRUD::create_photo(); ?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include("includes/top-nav.php"); ?>
            
            
            
            
            
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->            
            <?php include("includes/side-nav.php"); ?>
           
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <!-- ROW -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        ADMIN
                        <small>Multi Upload</small>
                    </h1>
                    <form action="multi_uploads.php" class="dropzone"></form>
                </div>
            </div>
            <!-- END OF ROW -->
        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
  
<!--
 
 Dropzone Error:
 
  <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"> <html><head> <title>404 Not Found</title> </head><body> <h1>Not Found</h1> <p>The requested URL was not found on this server.</p> <p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p> <hr> <address>Apache/2.4.41 (Win64) OpenSSL/1.1.1c PHP/7.4.1 Server at localhost Port 80</address> </body></html>

 -->
