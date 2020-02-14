<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

<?php 

    // Get the photo id from photos.php
    $comments = array();
    $img_path = "";
    if(empty($_GET['id']))
        redirect("photos.php");
        
    // get the photo path
    $photo = Photo::find_byID($_GET['id']);
    $img_path = $photo -> photo_path();

    // get the comments related to that photo by ID
    $comments = Comment::find_comm_by_photoID($_GET['id']);
    

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
                            PHOTO COMMENTS
                            <small>Subheading</small>
                        </h1>
                        
                        
                        <!-- The Comment Photo -->
                            <div class="col-md-4 col-md-offset-4">
                                <a class="thumbnail" href="../photo.php?id=<? echo $_GET['id']; ?>">
                                <img src="<? echo $img_path;?>" alt='Gallery image'>
                                </a>
                            </div>
                        <!-- /.The Comment Photo -->
                        
                        
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>comment</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                
<!-- Get comments infos from DB -->
<?php 
    if($comments):
        foreach($comments as $comment) :

            // get object infos
            $id = $comment -> comment_id;
            $author = $comment -> comment_author;
            $body = $comment -> comment_body;

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
                                    
                                    
                                    
                                    <td> <? echo $id; ?> </td>
                                    
                                    <!-- The comment Body -->
                                    <td> <? echo $body; ?> 
                                    
                                        <div class="action-links">
                                            <a href="delete_comment.php?comment_photo_id=<? echo $id;?>">Delete</a>
                                            <a href="edit_comment.php?comment_id=<? echo $id; ?>">Edit</a>
                                            <a href="../photo.php?id=<? echo $photo_id; ?>" >View</a>
                                        </div>
                                    
                                    </td>
                                    <!-- /.The comment Body -->
                                    
                                    <td> <? echo $author; ?> </td>

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