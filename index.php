
<!-- Header -->
<?php include("includes/header.php"); ?>

<?php 
                        /* ------- PAGINATION ------- */
    
    $message = "";
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $IPP = 4; // IPP: Items Per Page its 4 for now should be increased to ~ 10 
    $ITC = Photo::counter(); //ITC: Items Total Count
    $paginator = new Paginator($page, $IPP, $ITC);
    
    // a SQL query to get page photos related to our $paginator object 
    $photos = Photo::get_page_photos($paginator);
    
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
                <? endif; ?>
            </div>
            
            <!-- Pagination -->
            <div class="row">
                <ul class="pager">
                   <? if($paginator->Total_pages() > 1): ?>
                       
                       <!-- NEXT -->
                       <? if($paginator->has_next()): ?> 
                    <li class="next">
                       <a href="index.php?page=<? echo $paginator->Next();?>">Next</a>
                    </li>
                        <? endif; ?>
                       <!-- /.NEXT -->
                    
                       <!-- PAGE Nr -->
                       <? for($i = 1; $i <= $paginator->Total_pages(); $i++): ?>
                           <? if($i == $page): ?>
                       <li class="active">
                           <a href="index.php?page=<? echo $i ?>"><? echo $i ?></a>
                       </li>
                           <? else: ?>
                       <li>
                           <a href="index.php?page=<? echo $i ?>"><? echo $i ?></a>
                       </li>
                           <? endif; ?>
                       <? endfor;?>
                       <!-- /.PAGE Nr -->
                       
                       
                       <!-- PREVIIOUS -->
                        <? if($paginator->has_previous()): ?>    
                    <li class="previous">
                       <a href="index.php?page=<? echo $paginator->Previous();?>">Previous</a>
                    </li>
                        <? endif; ?>
                       <!-- /.PREVIIOUS -->
                        
                    <? endif; ?>
                </ul>
            </div>  
            <!-- /.Pagination -->
            
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
    
    1. Add the photos posts with content wrapper and Categories and Search with tags features.
    2. Try to add user tracking instead of views by refresh.
    3. We should prevent admin or user from adding photo without the photo it self.
    4. make a limit for the page number look up Google MyPagina class.
    5. Add login and profile and hide admin and add edit photo and hide it from not admin usr.
    
-->
                   
                                <!-- Deprecated Code -->
       
       
  <!--     
        
        // Line : 6 
          
        /* ------- FETCH ALL PHOTOS AND DISPLAY THEM HERE ------- */
    
    
//    $photos = Photo::find_all(); 

  -->  