<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>


<?php 
                    /* --- UPDATE A USER ---  */
    $username = "";
    $first_name = "";
    $second_name = "";
    $message = "";
    $users_lnk = " <a href='users.php'>View Users</a>";

    if(isset($_GET['user_id']) && !empty($_GET['user_id'])){

        // fill the form from DB
        $user = User::find_byID($_GET['user_id']);
        $username = $user->username;
        $first_name = $user->first_name;
        $second_name = $user->second_name;
        
        // taking the updated data from Form to DB
        update_user();
        
        // add view users link
        if(isset($_POST['update']))
            $message .= $users_lnk;
        
        // to keep the fields updated with new changes
        if(isset($_POST['update'])){
            
            $username = $_POST['username'];
            $first_name = $_POST['first_name'];
            $second_name = $_POST['second_name'];
        }
        
    }else
        redirect("users.php");
    
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
                            <small>EDIT USER</small>
                        </h1>
                        <form action="" enctype="multipart/form-data" method="post">
                            
                            <!-- FOR THE IMAGE -->
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <a href="#" class="thumbnail"><img src="<? echo $user -> photo_path(); ?>" alt="Gallery Image"></a>
                                    
                                    <input type="file" name="file_upload" >
                                </div>
                                
                            </div>
                            <!-- ./FOR THE IMAGE -->
                            
                            <div class="col-md-8">
                               <div class="form-group">
                               <!-- confirmation message for Admin -->
                                <p class='bg-success'><? echo $message; ?></p>    
                               </div>
                                

                               
                                <div class="form-group">
                                   <label for="caption">Username</label>
                                    <input type="text" name="username" value="<? echo $username; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                   <label for="caption">First Name</label>
                                    <input type="text" name="first_name" value="<? echo $first_name; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                   <label for="alternate_text">Second Name</label>
                                    <input type="text" name="second_name" value="<? echo $second_name; ?>" class="form-control">
                                </div>
                                  
                                <div class="form-group">
                                   <label for="alternate_text">Password</label>
                                    <input type="password" name="password"  class="form-control">
                                </div>
                                
                                <div class="form-group">
                                   <label for="alternate_text">New Password</label>
                                    <input type="password" name="new_password"  class="form-control">
                                </div>
                                
                                <div class="form-group">
                                   <label for="alternate_text">Confirm Password</label>
                                    <input type="password" name="confirm_password"  class="form-control">
                                </div>

                                <div class="from-group pull-right ">
                                        <input type="submit" name="update" value="Update" class="btn btn-primary">
                                </div> 
                                
                                <div class="form-group pull-left">
                                        <a  href="delete_user.php?user_id=<?php echo $user->user_id; ?>" class="btn btn-danger">Delete</a>   
                                </div>


                            </div>
                            
                            

                        </form>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
  
 




<!-- List of features to add in future -->