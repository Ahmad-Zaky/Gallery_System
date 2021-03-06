<?php require_once("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>


<?php 
                    /* --- UPDATE A USER ---  */
    $username = "";
    $first_name = "";
    $second_name = "";
    $message = "";
    $user_email = "";
    $user_role = "";
    $user_register_date = ""; 
    $users_lnk = " <a href='index.php'>Home</a>";

        


    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){

        // fill the form from DB
        $user = User::find_byID($_SESSION['user_id']);
        $username = $user->username;
        $first_name = $user->first_name;
        $second_name = $user->second_name;
        $user_email = $user->user_email;
        $user_role = $user->user_role;
        $user_register_date = format_date_time($user->user_register_date);
        
        // taking the updated data from Form to DB
        Utilities_CRUD::update_user();
        
        // add view users link

        if(isset($_POST['update']))
            $message .= $users_lnk;
        
        // to keep the fields updated with new changes
        if(isset($_POST['update'])){
            
            $username = $_POST['username'];
            $first_name = $_POST['first_name'];
            $second_name = $_POST['second_name'];
            $user_email = $_POST['user_email'];
            $user_register_date = $_POST['user_register_date'];

        }
        
    }else
        redirect("index.php");
    
?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <? echo $_SESSION['username'] ?> Profile
                </h1>
                <form action="" enctype="multipart/form-data" method="post">

                    <!-- FOR THE IMAGE -->
                    <div class="col-md-3">

                        <div class="form-group">
                                <img class="thumbnail" src="admin/<? echo $user -> photo_path(); ?>" alt="Gallery Image">

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
                           <label for="username">Username</label>
                            <input type="text" name="username" value="<? echo $username; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                           <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="<? echo $first_name; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                           <label for="second_name">Second Name</label>
                            <input type="text" name="second_name" value="<? echo $second_name; ?>" class="form-control">
                        </div>

                         <div class="form-group">
                           <label for="user_email">E-mail</label>
                            <input type="text" name="user_email" value="<? echo $user_email; ?>" class="form-control">
                        </div>


                        <div class="form-group">
                            <label for="">   Register Date </label>
                            <input  value="<?php echo $user_register_date; ?>" type="text" class="form-control" name="user_register_date" readonly>
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

                        <!-- user role element is hidden for the subscriber user -->
                        <input name="user_role" value="<? echo $user_role ?>" hidden>
                        
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
  
 




                            <!-- List of features -->
<!-- 

    1. get user infos using session.(DONE)
    2. format the date and time in a readable way. (DONE)
    3. keep user info after submitting the updates. (DONE)

-->
<!-- List of features to add in future -->


