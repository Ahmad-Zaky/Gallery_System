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
                            POHOTOS
                            <small>Subheading</small>
                        </h1>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Size</th>
                                    </tr>
                                </thead>
                                
<!-- Get Photos infos from DB -->
<?php 

    $photos = Photo::find_all();
    
    foreach($photos as $photo) :
        
        // get object infos
        $id = $photo -> photo_id;
        $img_path = $photo -> photo_path();
        $ext = pathinfo($img_path, PATHINFO_EXTENSION);
        $name = basename($photo -> photo_name, '.' . $ext);
        $title = $photo -> photo_title;
        $size = $photo -> format_bytes($photo -> photo_size);
        

        // check image file if exists
        if(file_exists($img_path) || !file_exists($img_path)) :
?>
                                <tbody>

                                    <tr>

                                    <td>
                                        <img class="admin-photo-thumbnail" src="<? echo $img_path;?>" alt='Gallery image'>
                                        
                                        <div class="pictures-links">
                                            <a href="delete_photo.php?photo_id=<? echo $id;?>">Delete</a>
                                            <a href="edit_photo.php?photo_id=<? echo $id; ?>">Edit</a>
                                            <a href="#">View</a>
                                        </div>
                                    </td>
                                    <td> <? echo $id; ?> </td>
                                    <td> <? echo $name; ?> </td>
                                    <td> <? echo $title; ?> </td>
                                    <td> <? echo $size; ?> </td>

                                    </tr>
<?php 

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