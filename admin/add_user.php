<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>


<?php   
    /* --- CREATE NEW USER --- */    
    $message = "";
    $users_lnk = " <a href='users.php'>View users</a>";
       
    // check first if all fields are filled
    if(!is_post_empty())
        Utilities_CRUD::create_user(); 
    else 
        $message = "One or more fields are empty!"; 
    
    // try to use the post-redirect-get pattern
    // !!! wrong way should be improved the Get msg !!! 
    // comes from create_user() function in functions.php
    if(isset($_GET['msg'])){
        $message = $_GET['msg'];
        $message .= $users_lnk; 
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
                            <small>Add New User</small>
                        </h1>
                        <form action="" enctype="multipart/form-data" method="post">
                            <div class="col-md-6 col-md-offset-3">
                               
                               <div class="form-group">
                               <!-- confirmation message for Admin -->
                                <p class='bg-success'><? echo $message; ?></p>    
                               </div>
                               
                                <div class="form-group">
                                   <label for="username">Username</label>
                                    <input type="text" name="username"  class="form-control">
                                </div> 

                                <div class="form-group">
                                   <label for="first_name">First Name</label>
                                    <input type="text" name="first_name"  class="form-control">
                                </div>

                                <div class="form-group">
                                   <label for="second_name">Second Name</label>
                                    <input type="text" name="second_name"  class="form-control">
                                </div>
                                  
                                <div class="form-group">
                                   <label for="second_name">E-mail</label>
                                    <input type="text" name="user_email"  class="form-control">
                                </div>
                                
                                <div class="form-group">
                                   <label for="password">Password</label>
                                    <input type="password" name="password"  class="form-control">
                                </div>
                                
                                <div class="form-group">
                                   <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password"  class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="file_upload">User Photo</label>
                                    <input type="file" name="file_upload" >
                                </div>
                                    
                                <div class="form-group">
                                    <br><label for="user_role">User Role</label><br>
                                    <select name="user_role" id="">

                                        <option value='subscriber'>Select role</option>
                                        <option value='subscriber'>Subscriber</option>
                                        <option value='admin'>Admin</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="add_user" value="Add User" class="btn btn-primary pull-right">
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

<!--
  
    ---------- 
    TODO List:
    ----------
   
    1. add the password functionality with hash_password encryption. (DONE)
     
-->



<!-- Deprecated HTML Code -->

                            <!-- SIDE BAR -->

                            <!--

                            <div class="col-md-4" >
                                <div  class="user-info-box">
                                    <div class="info-box-header">
                                       <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                <div class="inside">
                                  <div class="box-inner">
                                     <p class="text">
                                       <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                      </p>
                                      <p class="text ">
                                        user Id: <span class="data user_id_box"><?// echo $user->user_id;?></span>
                                      </p>
                                      <p class="text">
                                        Filename: <span class="data"><?// echo $user->user_name;?></span>
                                      </p>
                                     <p class="text">
                                      File Type: <span class="data"><?// echo $user->user_type;?></span>
                                     </p>
                                     <p class="text">
                                       File Size: <span class="data"><?// echo $user->format_bytes($user->user_size);?></span>
                                     </p>
                                  </div>
                                  <div class="info-box-footer clearfix">
                                    <div class="info-box-delete pull-left">
                                        <a  href="delete_user.php?user_id=<?php// echo $user->user_id; ?>" class="btn btn-danger btn-lg ">Delete</a>   
                                    </div>
                                    <div class="info-box-update pull-right ">
                                        <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                    </div>   
                                  </div>
                                </div>          
                            </div>
                        </div>

                        -->
                        <!-- /.SIDE BAR -->