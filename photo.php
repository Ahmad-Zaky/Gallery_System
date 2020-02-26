<?php require_once("admin/includes/init.php")?>



<?php 
                /* --- Creating a new Comment  --- */
    
    // redirect to index if no id is specified
    if(empty($_GET['id']))
        redirect("index.php");


                /* ---- Fetching The Photo by ID ---- */
    
    $photo = Photo::find_byID($_GET['id']);


    // retrieving all comments related to this photo
    $comments = Comment::find_comm_by_photoID($_GET['id']); 
    
    // creating the submitted comment
    create_comment();


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
                    by <a href="index.php?photo_id=<? echo $photo->user_id; ?>" ><? echo $photo->find_photo_username(); ?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <? echo format_date_time($photo->photo_upload_date); ?> </p>

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
                   <!-- Add the username if signed in -->
                    <h4>Leave a Comment: 
                    <? if($session->is_signedIn()) echo $_SESSION['username']; ?>
                    </h4>
                    <p style="text-align: center">
                    <?  echo $session->message(); ?>
                    </p>
                    <form role="form" method="post">
                       
                        <!-- Add Name if not registered yet -->
                        <? if(!$session->is_signedIn()): ?>
                        <div class="form-group">
                           <label for="author">Name</label>
                            <input class="form-control" type="text" name="author" >
                        </div>
                        <? endif; ?>
                        
                        <div class="form-group">
                            <textarea class="form-control" name="body" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                
<!-- get the photo comments -->     
<? foreach($comments as $comment): ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        
                        <?
                            $username = "";
                            // get the user photo
                            if($comment->user_id):
                                $user = User::find_byID($comment->user_id);
                                $username = $user->username;
                        ?>
                        <img class="comment-photo-thumbnail media-object" src="admin/<? echo $user->photo_path(); ?>" alt="">
                        <? else: ?>
                        <img class="comment-photo-thumbnail media-object" src="http://placehold.it/64x64" alt="">
                        <? endif; ?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"> 
                           
                           <? // Display username if signed in, Entered Name if not registered
                            if($username)
                                echo $username;
                            else
                                echo $comment->comment_author; 
                            ?>
                            
                            <small>at <? echo format_date_time($comment->comment_date) ?></small>
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
