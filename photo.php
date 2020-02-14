<?php require_once("admin/includes/init.php")?>
<?php ob_start(); ?>



<?php 
                /* --- Creating a new Comment  --- */
    
    // redirect to index if no id is specified
    if(empty($_GET['id']))
        redirect("index.php");
    
    // retrieving all comments related to this photo
    $comments = Comment::find_comm_by_photoID($_GET['id']); 
    
    // creating the submitted comment
    create_comment();
?>


<!-- Header -->
<?php include("includes/header.php"); ?>

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>Blog Post Title</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">Start Bootstrap</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!</p>

                <hr>

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
                 <?php include("includes/sidebar.php"); ?>
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
     
-->
