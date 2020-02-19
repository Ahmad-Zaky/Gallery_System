<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>


       
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
                            <small>MY PHOTOS</small>
                        </h1>
                        <p class="bg-success">
                            <? echo $session->message(); ?>
                        </p>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Comments</th>
                                        <th>Size</th>
                                    </tr>
                                </thead>
                                
<!-- Get Photos infos from DB -->
<?php 

    $photos = Photo::find_photos_by_userID($_SESSION['user_id']);
    
    foreach($photos as $photo) :
        
        // get object infos
        $id = $photo -> photo_id;
        $img_path = $photo -> photo_path();
        $ext = pathinfo($img_path, PATHINFO_EXTENSION);
        $name = basename($photo -> photo_name, '.' . $ext);
        $title = $photo -> photo_title;
        $size = $photo -> format_bytes($photo -> photo_size);
        
        // get the comments related to this photo
        $comments = Comment::find_comm_by_photoID($id);
        

        // check image file if exists
        if(file_exists($img_path) || !file_exists($img_path)) :
?>
                                <tbody>

                                    <tr>

                                    <td>
                                        <a href="../photo.php?id=<?echo $id; ?>">
                                            <img class="admin-photo-thumbnail" src="<? echo $img_path;?>" alt='Gallery image'>
                                        </a>
                                        
                                        <div class="pictures-links">
                                            <a class="delete-link" href="delete_photo.php?photo_id=<? echo $id;?>">Delete</a>
                                            <a href="edit_photo.php?photo_id=<? echo $id; ?>">Edit</a>
                                            <a href="../photo.php?id=<?echo $id; ?>">View</a>
                                        </div>
                                    </td>
                                    <td> <? echo $id; ?> </td>
                                    <td> <? echo $name; ?> </td>
                                    <td> <? echo $title; ?> </td>
                                    <td> <? echo count($comments); ?>
                                    
                                    <a href="comments_photo.php?id=<?echo $id; ?>">Comments</a> 
                                    
                                    </td>
                                    <td> <? echo $size; ?> </td>

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
  
 
<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

<?php 
if(!empty($_GET['photo_id']) && isset($_GET['photo_id'])){
    
    echo "get id";
    
    $id = $_GET['photo_id'];
    
    $photo = Photo::find_byID($id);
    if($photo){
        
        $photo->delete_photo();
        redirect("photos.php");
    }
    else
        redirect("photos.php");

}else{
    echo "did not get id";
}
?>

<!-- List of features to add in future -->


<!-- 

    ----------
    TODO List:
    ----------
    
        1. Add a feature to show only the photos related to the login admin user only and add role for the users to do that and add the extra field in db to help us doing that and add a function in the user class to get the photos related to that admin user and make sure you add the new fields names in the class specially db_table_fields.

-->