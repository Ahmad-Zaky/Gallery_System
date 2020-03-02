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
                            <small>COMMENTS</small>
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
                                   <option value="pinned">Pin</option>
                                   <option value="unpinned">Unpin</option>
                                   <option value="delete_comment">Delete</option>
                               </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-success" value="Apply">
                            <!-- /.add some options list -->

                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                       <th><input type="checkbox" onclick="toggle(this)" id="selectAllBoxes"></th>

                                        <th>ID</th>
                                        <th>comment</th>
                                        <th>Photo</th>
                                        <th>Author</th>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>pin</th>
                                        <th>unpin</th>
                                    </tr>
                                </thead>

           
                      

                                
<!-- Change comment status by $_GET[''] using <a> link tags -->
<?php 
    
    // in case we clicked on unpin link
    if(isset($_GET['unpin'])){
        
        $comment_id = $_GET['unpin'];
        set_comment_status($comment_id, "unpinned");
    }
        
    // in case we clicked on pin link
    if(isset($_GET['pin'])){
        
        $comment_id = $_GET['pin'];
        set_comment_status($comment_id, "pinned");
    }
        
                                
?>
                                                      
                                                       
<!-- Get comments infos from DB -->
<?php 

    $comments = Comment::find_all();
    
    foreach($comments as $comment) :
        
        $usrname = "";
                                
        // get object infos
        $id = $comment -> comment_id;
        $author = $comment -> comment_author;
        $body = $comment -> comment_body;
        $status = $comment -> comment_status;
        
        // get User Id if there is one and get the username of this user_id
        if($comment->user_id)
            $usrname = User::find_byID($comment->user_id) -> username;

        
        
        // get photo for that comment
        $photo_id = $comment -> photo_id;
        
        $photo = Photo::find_byID($photo_id);
        $img_path = $photo -> photo_path();        
        $ext = pathinfo($img_path, PATHINFO_EXTENSION);
        $name = basename($comment -> comment_name, '.' . $ext);
        
        // check image file if exists
        if(file_exists($img_path) || !file_exists($img_path)) :

?>
                                <tbody>

                                    <tr>
                                    
                                    <td><input type="checkbox" class="checkBoxes" name="chkBoxArr[]" value="<?php echo $id?>" > </td>
                                    
                                    <td> <? echo $id; ?> </td>
                                    
                                    <!-- The comment Body -->
                                    <td> <? echo $body; ?> 
                                    
                                        <div class="action-links">
                                            <a class="delete-link" href="delete_comment.php?comment_id=<? echo $id;?>">Delete</a>
                                            <a href="../photo.php?id=<? echo $photo_id; ?>" >View</a>
                                        </div>
                                    
                                    </td>
                                    <!-- /.The comment Body -->
                                    
                                    
                                    <!-- The Comment Photo -->
                                    <td>
                                        <a href="../photo.php?id=<? echo $photo_id; ?>">
                                            <img class="admin-photo-thumbnail" src="<? echo $img_path;?>" alt='Gallery image'>
                                        </a>
                                    </td>
                                    <!-- /.The Comment Photo -->
                                    
                                    <td> <? echo $author; ?> </td>
                                    <td> <? echo $usrname; ?> </td>
                                    <td> <? echo $status; ?> </td>
                                    <td><a href="comments.php?pin=<? echo $id ?>">Pin</a></td>
                                    <td><a href="comments.php?unpin=<? echo $id ?>">Unpin</a></td>
                                    
                                    
                                    </tr>
<?php 
    else:
        echo "<h3> Photo Not Found!</h3>";
    endif;
    endforeach;

?>
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

    TODO List:
    
        1. Add edit comment feature by creating the file with its functionality (may be by the normal user side at the photo.php)

-->
                            <!-- DEPRECATED CODE -->
                                           
<!--    

    -> Line : 84
    ------------
    
    <a href="edit_comment.php?comment_id=<? //echo $id; ?>">Edit</a>


    -> Line : 117
    -------------
    
                
//            // get username
//            if($usr)
//                $usrname = $usr->username;


-->