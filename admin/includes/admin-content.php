         <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            ADMIN
                            <small>Dashboard</small>
                        </h1>
                      
                      
                      
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><? echo $_SESSION['views']; ?></div>
                                                <div>New Views</div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="panel-footer">
                                          <span class="pull-left"></span> 
                                       <span class="pull-right"><i class="fa"></i></span> 
                                            <div class="clearfix"></div>
                                        </div>
                                </div>
                            </div>

                             <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-photo fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><? echo Photo::counter()?></div>
                                                <div>Photos</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="photos.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                             <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-user fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><? echo User::counter() ?></div>
                                                <div>Users</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="users.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                              <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-support fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><? echo Comment::counter() ?></div>
                                                <div>Comments</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="comments.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                        </div> 
                        <!--First Row-->
                      
                        <!-- Pie Chart -->
                        <!--Table and divs that hold the pie charts-->
                            <div class="row">
                                <table class="columns">
                                    <tr>
                                        <td>
                                            <div  id="piechart_Photos" style="border: 1px "></div>
                                        </td>
                                        <td>
                                            <div  id="piechart_UserPhotos" style="border: 1px "></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div  id="piechart_Users" style="border: 1px "></div>
                                        </td>
                                        <td>
                                            <div  id="piechart_Comments" style="border: 1px "></div>
                                        </td>
                                    </tr>
                                </table>      
                            </div>
                            
                        <!-- /.Pie Chart -->
                        
                      
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

   
   
   
<!-- List of features to add in future -->

<!--
  
    ---------- 
    TODO List:
    ----------
    
    1. Add More than one Pie chart one for each class. (DONE)
    2. try to position each div in the page so each row contains 2 charts max.(DONE)
    3. add the approved and unapproved feature to photos and so on for other classes.(DONE)
    
    
  
-->   
   
<!-- 
    
     
                              *------ Deprecated Code ------*
      
            
                         
                         
                          // check photo class find_byID()
//                            $obj_photo = Photo::find_byID(1);
//                            echo $obj_photo -> photo_name;
           
       
                           // try catch checker for undefined class
//                            try{
//                                    
//                                // print all users
//                                $users = User::find_all();
//                                foreach($users as $user)
//                                    echo $user->get_username() . "<br>";
//                                
//                                // print user by id
//                                $usr_found = User::find_byID($session->user_id);
//                                echo $session->user_id . "<br>";
//                                if($usr_found)    
//                                    echo $usr_found->get_username() . "<br>";
//                                else
//                                    echo "user not found!";
//                                                                
//                            }catch(Exception $e){
//                                echo $e -> getMessage(), "\n";
//                            }
                        
                            // create a user test
//                            $user_obj = new User();
//                            
//                            // setting the user properties
//                            $user_obj->username = "Hamdy_HR";
//                            $user_obj->password = "hamdyabc";
//                            $user_obj->first_name = "Hamdy";
//                            $user_obj->second_name = "Shaker";
//                            
//                            $user_obj->create();
                        
                            // update a user test
//                            $user_obj = User::find_user(4);
//                        
//                            $user_obj->set_username("ahmed_cpp");
//                            echo ($user_obj->update()) ? "yes" : "no";
                        
                            // delete a user test
//                            $user_obj = User::find_user(5);
//                            echo ($user_obj->delete()) ? "yes" : "no";
                        
                            // save function for user test (update existing user)
//                            $user_obj = User::find_byID(8);
//                            $user_obj->username = "sameh_node";
//                            $user_obj->save();
                       
                            // save function for user test (creating a new user)
//                            $user_obj = new User();
//                            $user_obj->username = "Fady_VB";
//                            $user_obj->save();
                        
                            // Photo tests
                        
                            // select all photos
//                            $photos = Photo::find_all();
//                            foreach($photos as $photo)
//                                echo $photo->photo_title . "<br>";
                            
                            // save function for photo test (creating a new photo)
//                            $photo_obj = new Photo();
//                            
//                            $photo_obj->photo_title = "photo from ocean";
//                            $photo_obj->photo_description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt unde eligendi ipsa dolores impedit. Officia a sapiente natus voluptatem iste, exercitationem nobis neque reprehenderit autem, dolorum sequi magni! Quas, expedita.";
//                            $photo_obj->photo_name = "ocean.jpg";
//                            $photo_obj->photo_type = "image";
//                            $photo_obj->photo_size = 3;
//                            
//                            $photo_obj->create();
//                        
                        
                            // save function for user test (update existing user)
//                            $photo_obj = Photo::find_byID(8);
//                            $photo_obj->photo_title = "photo from mountains";
//                            $photo_obj->update();
 
       
               *----- It is from Line : 10 (Template HTML code) -----*
       
                       <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
       
       -->
        
                            
         
        
