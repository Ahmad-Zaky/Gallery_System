<?php require_once("admin/includes/init.php")?>



<?php 
                /* --- Creating a new Comment  --- */
    
    // redirect to index if no id is specified
    if(empty($_GET['id']))
        redirect("index.php");
    
    // retrieving all comments related to this photo
    $comments = Comment::find_comm_by_photoID($_GET['id']); 
    
    // creating the submitted comment
    create_comment();

            /* ---- Fetching The Photo by ID ---- */

    $photo = Photo::find_byID($_GET['id']);
?>


<!-- Header -->
<?php include("includes/header.php"); ?>

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-12">

                <!-- Blog Post -->
                
                <!-- Check Photo existance -->
                <? if($photo) :?>
                
                <!-- Title -->
                <h1><? echo $photo -> photo_title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">Start Bootstrap</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on </p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="admin/<? echo $photo -> photo_path(); ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><? echo $photo -> photo_caption; ?></p>
                <p><? echo $photo -> photo_description; ?></p>

                <hr>
                
                
                <!-- /.Check Photo existance -->
                <? endif; ?>
                
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        
                        <div class="form-group">
                           <label for="author">Author</label>
                            <input class="form-control" type="text" name="author" >
                        </div>
                        
                        <div class="form-group">
                            <textarea class="form-control" name="body" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                
                
<? foreach($comments as $comment) : ?>
                
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"> <? $comment -> author ?>
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        <? echo $comment -> comment_body?>
                    </div>
                </div>
                <!-- /.Comment -->

<? endforeach; ?>
                

            </div>
                 <?php //include("includes/sidebar.php"); ?>
        </div>
        <!-- /.row -->

<!-- Footer -->
<?php include("includes/footer.php"); ?>


<!-- List of features to add in future -->

<!--
  
    ---------- 
    TODO List:
    ----------
       
    1. pull user information and fill the comment part with the name and photo or placholder.   
    2. add nested replay feature.
    3. make notification feature for replies at least.
    4. take features from the last CMS project course.
    5. Add the role feature for Authentication and Authorization.
    5. Add the admin option into the nav bar if the login is an admin user.
    6. Add also an Edit photo link in the nav bar for the admin user also.
    7. Add author to photos and make user role for that also.
    8. put date for photos and comments uploads.
    9. Add edit comment for users online.
    10. Change the date format to be like this 'August 24, 2013 at 9:00 PM'
     
-->
