<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

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
                        
                    <div class="col-md-12">
                        <a class="btn btn-primary" href="add_user.php">Add User</a>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Second Name</th>
                                    </tr>
                                </thead>
                                
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
        

        
?>
                                <tbody>

                                    <tr>
                                    <td> <? echo $id; ?> </td>

                                    <td>
                                        <img class="admin-photo-thumbnail" src="<? echo $img_path;?>" alt='Gallery image'>
                                        
                                        <div class="pictures-links">
                                            <a href="delete_user.php?user_id=<? echo $id;?>">Delete</a>
                                            <a href="edit_user.php?user_id=<? echo $id; ?>">Edit</a>
                                            <a href="#">View</a>
                                        </div>
                                    </td>
                                    
                                    <td> <? echo $username; ?> </td>
                                    <td> <? echo $firstname; ?> </td>
                                    <td> <? echo $secondname; ?> </td>

                                    </tr>
<?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- END OF TABLE -->
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
        
        1. sort by id or name ASC & DESC.


-->