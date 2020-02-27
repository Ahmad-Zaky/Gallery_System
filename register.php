<?php require_once("includes/header.php"); ?>


<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
      

            <section id="login">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="form-wrap">
                            <h1 style="text-align: center">Register</h1>

                              
                              
                            <!-- ***** Registeration function process ***** -->
                           
                           
                            <?  // get registeration success or error messages
                                $messages = registeration();
                                
                                // Display registeration errors
                                if(!empty($messages))          
                                    foreach($messages as $msg)
                                        echo "<p class='bg-danger'>".$msg."</p>";
                            ?>

                    
                            <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            
                            <div class="form-group">
                                <label for="first_name" class="sr-only">Firstname</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter Your First Name">
                            </div>
                            
                            <div class="form-group">
                                <label for="username" class="sr-only">Secondname</label>
                                <input type="text" name="second_name" id="second_name" class="form-control" placeholder="Enter Your Second Name">
                            </div>
                            
                             <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                             <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="sr-only">Confirm Password</label>
                                <input type="password" name="confirm_password" id="key" class="form-control" placeholder="Confirm Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



       
       
       
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
  
 




<!--                          *--- List of features ---*

    1. check empty fields.
    2. check username with db so username will be unique for each user.
    3. check password match with confirmation.
    4. encrypt the password with Aragon2i algorithm.
    5. using regular expression for email.
    
<!-- 


-->

<!-- List of features to add in future -->

<!-- 

    ----------
    TODO List:
    ----------
        
        1. add the password_needs_rehash() function.
    
-->



