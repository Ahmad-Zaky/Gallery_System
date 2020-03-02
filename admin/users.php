<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>

<? apply_selected_options(); ?>
       

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
                            <small>USERS</small>
                        </h1>
                        <p class="bg-success">
                            <? echo $session->message(); ?>
                        </p>
                        
                        
                    <!-- Form for bulk option -->
                    <form action="" method="post">

                        <!-- add some options list -->
                       <div class="col-md-4" id="bulkOptionContainer" >
                           <select name="bulkOption" id="" class="form-control">
                               <option value="">Select Options</option>
                               <option value="admin">Admin</option>
                               <option value="subscriber">Subscriber</option>
                               <option value="delete_user">Delete</option>
                           </select>
                        </div>
                        <input type="submit" name="submit" class="btn btn-success" value="Apply">
                        <!-- /.add some options list -->


                    <div class="col-md-12">
                        <a class="btn btn-primary" href="add_user.php">Add New User</a>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                       <th><input type="checkbox" onclick="toggle(this)" id="selectAllBoxes"></th>

                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Second Name</th>
                                        <th>E-mail</th>
                                        <th>Rigistered</th>
                                        <th>Role</th>
                                        <th>Admin</th>
                                        <th>Subscriber</th>
                                    </tr>
                                </thead>
                                
<!-- Change user role by $_GET[''] using <a> link tags -->
<?php 
    
    // in case we clicked on admin link
    if(isset($_GET['admin'])){
        
        $user_id = $_GET['admin'];
        set_user_role($user_id, "admin");
    }
        
    // in case we clicked on subscriber link
    if(isset($_GET['subscriber'])){
        
        $user_id = $_GET['subscriber'];
        set_user_role($user_id, "subscriber");
    }
        
                                
?>
                                
                                
              
                                          
<!-- Get users infos from DB -->
<?php 

    $users = User::find_all();
    
    foreach($users as $user) :
        
        // get object infos
        $id = $user -> user_id;
        $img_path = $user -> photo_path();
        $username = $user -> username;
        $firstname = $user -> first_name;
        $secondname = $user -> second_name;
        $user_email = $user -> user_email;
        $user_register_date = $user -> user_register_date;
        $user_role = $user -> user_role;
        

        
?>
                                <tbody>

                                    <tr>
                                    <td><input type="checkbox" class="checkBoxes" name="chkBoxArr[]" value="<?php echo $id?>" > </td>

                                    <td> <? echo $id; ?> </td>

                                    <td>
                                        <a href="edit_user.php?user_id=<? echo $id; ?>">
                                            <img class="admin-photo-thumbnail" src="<? echo $img_path;?>" alt='Gallery image'>
                                        </a>
                                        
                                        <div class="pictures-links">
                                        
                                        <!-- Hide the loged in user delete link -->
                                        <? if($user->user_id !== $_SESSION['user_id']): ?>
                                            <a class="delete-link"  href="delete_user.php?user_id=<? echo $id;?>">Delete</a>
                                        <? endif; ?>   

                                            
                                            
                                            <a href="edit_user.php?user_id=<? echo $id; ?>">Edit</a>
                                            <a href="profile.php">View</a>
                                        </div>
                                    </td>
                                    
                                    <td> <? echo $username; ?> </td>
                                    <td> <? echo $firstname; ?> </td>
                                    <td> <? echo $secondname; ?> </td>
                                    <td> <? echo $user_email; ?> </td>
                                    <td> <? echo format_date_time($user_register_date); ?> </td>
                                    <td> <? echo $user_role; ?> </td>
                                    <td><a href="users.php?admin=<? echo $id ?>">Admin</a></td>
                                    <td><a href="users.php?subscriber=<? echo $id ?>">Subscriber</a></td>
                                    <td>  </td>

                                    </tr>
<?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- END OF TABLE -->
                        </div>
                        </form>
                        <!-- END OF FORM -->
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
        
        1. sort by id or name ASC & DESC.


-->