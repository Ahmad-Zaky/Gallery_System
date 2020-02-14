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
                            <small>COMMENTS</small>
                        </h1>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>comment</th>
                                        <th>Photo</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                
<!-- Get comments infos from DB -->
<?php 

    $comments = Comment::find_all();
    
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
                                            <a href="delete_comment.php?comment_id=<? echo $id;?>">Delete</a>
                                            <a href="edit_comment.php?comment_id=<? echo $id; ?>">Edit</a>
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
    
        1. Add edit comment feature by creating the file with its functionality.

-->