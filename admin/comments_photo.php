<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>


<?php 


    // apply options on selected elements
    apply_selected_options();                             


    // Get the photo id from photos.php
    $comments = array();
    $img_path = "";
    if(empty($_GET['id']))
        redirect("photos.php");
    
    $photo_id = $_GET['id'];

    // get the photo path
    $photo = Photo::find_byID($photo_id);
    $img_path = $photo -> photo_path();

    // get the comments related to that photo by ID
    $comments = Comment::find_comm_by_photoID($photo_id);
    

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
                            PHOTO 
                            <small>COMMENTS</small>
                        </h1>
                        
                        <!-- Form for bulk option -->
                        <form action="" method="post">
                        
                        <!-- The Comment Photo -->
                            <div class="col-md-4 col-md-offset-4">
                                <a class="thumbnail" href="../photo.php?id=<? echo $_GET['id']; ?>">
                                <img src="<? echo $img_path;?>" alt='Gallery image'>
                                </a>
                        

                            <!-- add some options list -->
                           <div class="col-md-9" id="bulkOptionContainer" >
                               <select name="bulkOption" id="" class="form-control">
                                   <option value="">Select Options</option>
                                   <option value="pinned">Pin</option>
                                   <option value="unpinned">Unpin</option>
                                   <option value="delete_comment">Delete</option>
                               </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-success" value="Apply">
                            <!-- /.add some options list -->
                            </div>
                        <!-- /.The Comment Photo -->
                            
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                       <th><input type="checkbox" onclick="toggle(this)" id="selectAllBoxes"></th>

                                        <th>ID</th>
                                        <th>Comment</th>
                                        <th>Author</th>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>pin</th>
                                        <th>unpin</th>
                                    </tr>
                                </thead>

              

                                
<!-- Change comment status by $_GET[''] using <a> link tags -->
<?php 
    
    // in case we clicked on admin link
    if(isset($_GET['unpin'])){
        
        $photo_id = $_GET['unpin'];
        set_comment_status($photo_id, "unpinned");
    }
        
    // in case we clicked on subscriber link
    if(isset($_GET['pin'])){
        
        $photo_id = $_GET['pin'];
        set_comment_status($photo_id, "pinned");
    }
        
                                
?>
                               
              
<!-- Get comments infos from DB -->
<?php 
    if($comments):
        foreach($comments as $comment) :
                                
            $username = "";                    
                                
            // get object infos
            $id = $comment -> comment_id;
            $author = $comment -> comment_author;
            $body = $comment -> comment_body;
            $status = $comment -> comment_status;
            
                // get User Id if there is one and get the username of this user_id
            if($comment->user_id)
                $usrname = User::find_byID($comment->user_id);
                 
            
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
                                            <a href="delete_comment.php?comment_photo_id=<? echo $id;?>">Delete</a>
                                            <a href="../photo.php?id=<? echo $photo_id; ?>" >View</a>
                                        </div>
                                    
                                    </td>
                                    <!-- /.The comment Body -->
                                    
                                    <td> <? echo $author; ?> </td>
                                    <td> <? echo $username; ?> </td>
                                    <td> <? echo $status; ?> </td>
                                    <td><a href="comments_photo.php?id=<? echo $photo_id; ?>&pin=<? echo $id ?>">Pin</a></td>
                                    <td><a href="comments_photo.php?id=<? echo $photo_id; ?>&unpin=<? echo $id ?>">Unpin</a></td>
                                    
                                    </tr>
<?php 
            else:
                echo "<h3> Photo Not Found!</h3>";
            endif;
        endforeach;
    endif;
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



                        <!-- Deprecated Code -->



<!-- Button as link Line : 104 -->

<!-- <input class="btn btn-link" type="submit" name="delete" value="Delete"> -->