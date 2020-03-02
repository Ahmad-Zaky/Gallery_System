
<!-- Header -->
<?php include("includes/header.php"); ?>

<?php 
                    /* -------- user photos ---------- */


    // if I chose the Author of the photo it should shows here his photos
    $id = 0;
    if(isset($_GET['photo_id'])){
        $id = $_GET['photo_id'];
    }


                        /* ------- PAGINATION ------- */
    
    $message = "";
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $IPP = 4; // IPP: Items Per Page its 4 for now should be increased to ~ 10 
    $ITC = Photo::custom_counter_approved($id); //ITC: Items Total Count
    $paginator = new Paginator($page, $IPP, $ITC);
    
    // a SQL query to get page photos related to our $paginator object 
    // it will return only published photos and if $id is specified it will return only this user_id photos
    $photos = Photo::get_page_photos($paginator, $id);
    
    // check if it returns true
    if(!$photos):
        $message = "Failed to get the Photos!";
    else:
    

?>

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-12">
            
            <h1><? echo $message ?></h1>
               
            <div class="thumbnail row">
                <!-- Display photo by photo from DB -->
                <? foreach( $photos as $photo) : 
                    
                
                    /* --- Filter Photos Without real photos --- */
                    if($photo->photo_name == "")
                        continue;
                ?>
                
                <div class="col-xs-6 col-md-3">
                    <a class="thumbnail" href="photo.php?id=<? echo $photo -> photo_id; ?>" >
                        <img class="home-img" src="admin/<? echo $photo -> photo_path(); ?>" alt="Gallery Photo">
                    </a>
                </div>
                <? endforeach; ?>
                <? endif; ?>
            </div>
            
                 <?php include("includes/pagination.php"); ?>
            
            
        </div>
        <!-- /.Blog Entries Column -->

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
    
    1. Add the photos posts with content wrapper and Categories and Search with tags features. (DONE DIFFERENTLY)
    2. Try to add user tracking instead of views by refresh. (TAKING IT ONLINE FIRST)
    3. We should prevent admin or user from adding photo without the photo it self.(DONE DIFFERENTLY)
    4. make a limit for the page number look up Google MyPagina class.
    5. Add login and profile and hide admin and add edit photo and hide it from not admin usr. (DONE)
    6. change all short php tags < ? ? > into < ?= ?>
    
-->
                   
                                <!-- Deprecated Code -->
       
       
  <!--     
        
        // Line : 6 
        -----------
            
        /* ------- FETCH ALL PHOTOS AND DISPLAY THEM HERE ------- */
    
    
//    $photos = Photo::find_all(); 
        
        // Line : 21
        ------------
        
        
//    $ITC = Photo::counter(); 
 
 
 
-->  