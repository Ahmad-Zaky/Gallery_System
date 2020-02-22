<?php include("includes/header.php"); ?>
<?php include("includes/photo_lib_modal.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>


<?php 
                    /* --- UPDATE A PHOTO ---  */

    
    $title = "";
    $caption = "";
    $alternate_text = "";
    $description = "";
    $status = "";
    $message = "";
    $photos_lnk = " <a href='photos.php'>View Photos</a>";
    
    if(isset($_GET['photo_id']) && !empty($_GET['photo_id'])){

        // fill the form from DB
        $photo = Photo::find_byID($_GET['photo_id']);

        if($photo){
            $title = $photo -> photo_title;
            $caption = $photo -> photo_caption;
            $alternate_text = $photo -> photo_alternate_text;
            $description = $photo -> photo_description;
            $upload_date = $photo -> photo_upload_date;
            $status = $photo -> photo_status;
        }else
            $message = "Photo not found! " . $photos_lnk;
        
        // taking the updated data from Form to DB
        update_photo();
        
        // add view photos link
        if(isset($_POST['update']))
            $message .= $photos_lnk;
        
        // This duplication is mainly because I wanna keep the changes
        // after the update from the DB
        if(isset($_POST['update'])){
            $title = $_POST['title'];
            $caption = $_POST['caption'];
            $alternate_text = $_POST['alternate_text'];
            $description = $_POST['description'];
            $upload_date = $_POST['upload_date'];
            $status = $_POST['status'];
        }
    }else
        redirect("photos.php");
    
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
                            ADMIN
                            <small>EDIT PHOTO</small>
                        </h1>
                        <form action="" enctype="multipart/form-data" method="post">
                            <div class="col-md-8">
                               <div class="form-group">
                               <!-- confirmation message for Admin -->
                                <p class='bg-success'><? echo $message; ?></p>    
                               </div>
                               
                                <div class="form-group">
                                    <input type="text" name="title" value="<? echo $title; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <a href="" class="thumbnail" data-toggle="modal" data-target="#photo-modal">
                                    <img src="<? echo $photo -> photo_path(); ?>" alt="Gallery Image"></a>
                                    
                                    <input type="file" name="file_upload" >
                                </div>

                                <div class="form-group">
                                   <label for="caption">Caption</label>
                                    <input type="text" name="caption" value="<? echo $caption; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                   <label for="alternate_text">Alternate Text</label>
                                    <input type="text" name="alternate_text" value="<? echo $alternate_text; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                   <label for="description">Description</label>
                                    <textarea name="description" id="editor" cols="30" rows="10" class="form-control"><? echo $description; ?>
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <br><label for="status">Status</label><br>
                                    <select name="status" id="">
                                        
                                    <!-- Arrange the options depend on the photo_status -->
                                    <? if($photo_status == 'draft'):?>
                                        
                                        <option value='draft'>Draft</option>
                                        <option value='published'>Published</option>
                                        
                                    <? else: ?>
                                        
                                        <option value='published'>Published</option>
                                        <option value='draft'>Draft</option>
                                        
                                    <? endif; ?>
                                    </select>
                                </div>
                                     
                            </div>
                            
                            <!-- SIDE BAR -->
                            <div class="col-md-4" >
                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                       <h4>Save <span id="toggle" class="glyphicon-menu-up glyphicon pull-right"></span></h4>
                                    </div>
                                <div class="inside">
                                  <div class="box-inner">
                                     <p class="text">
                                       <span class="glyphicon glyphicon-calendar"></span> Uploaded on: <? echo format_date_time($upload_date); ?>
                                      </p>
                                      <p class="text ">
                                        Photo Id: <span class="data photo_id_box"><? echo $photo->photo_id;?></span>
                                      </p>
                                      <p class="text">
                                        Filename: <span class="data"><? echo $photo->photo_name;?></span>
                                      </p>
                                     <p class="text">
                                      File Type: <span class="data"><? echo $photo->photo_type;?></span>
                                     </p>
                                     <p class="text">
                                       File Size: <span class="data"><? echo $photo->format_bytes($photo->photo_size);?></span>
                                     </p>
                                  </div>
                                  <div class="info-box-footer clearfix">
                                    <div class="info-box-delete pull-left">
                                        <a href="delete_photo.php?photo_id=<?php echo $photo->photo_id; ?>" class="delete-link btn btn-danger btn-lg ">Delete</a>   
                                    </div>
                                    <div class="info-box-update pull-right ">
                                        <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                    </div>   
                                  </div>
                                </div>          
                            </div>
                        </div>
                        <!-- /.SIDE BAR -->

                        </form>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
  
 




<!-- List of features to add in future -->
                                   
                                   
                                   <!-- DEPREACATED CODE -->
                                   
<!-- 


    -> Line : 88

        <a href="../photo.php?id=<? //echo $photo->photo_id ?>" class="thumbnail">
        <img src="<? //echo $photo -> photo_path(); ?>" alt="Gallery Image">
        </a>
        
        

-->