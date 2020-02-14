
<!-- Header -->
<?php include("includes/header.php"); ?>

<?php 
        /* ------- FETCH ALL PHOTOS AND DISPLAY THEM HERE ------- */
    
    
    $photos = Photo::find_all(); 

?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
            
               
            <div class="thumbnail row">
                <!-- Display photo by photo from DB -->
                <? foreach( $photos as $photo) : 
                
                    /* --- Filter Photos Without real photos ---*/
                    if($photo->photo_name == "")
                        continue;
                ?>
                
                <div class="col-xs-6 col-md-3">
                    <a class="thumbnail" href="photo.php?id=<? echo $photo -> photo_id; ?>" >
                        <img class="home-img" src="admin/<? echo $photo -> photo_path(); ?>" alt="Gallery Photo">
                    </a>
                </div>
                <? endforeach; ?>
            </div>

            </div>

<!--                 <?php //include("includes/sidebar.php"); ?>-->
        </div>
        <!-- /.row -->

<!-- Footer -->
<?php include("includes/footer.php"); ?>


<!-- List of features to add in future -->

<!--
  
    ---------- 
    TODO List:
    ----------
    
    1. Add the photos posts with content wrapper and Categories and Search with tags features.
    2. Try to add user tracking instead of views by refresh.
    
-->