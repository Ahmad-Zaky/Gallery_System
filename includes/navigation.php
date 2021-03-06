    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        
       
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               
               
                
                <ul class="nav navbar-nav navbar-right">
                
                    <li>
                    <? if(!$session->is_signedIn()): ?>
                        <a href="admin/login.php">Login</a>
                    <? else: ?>
                        <a href="admin/includes/logout.php">Logout</a>
                    <? endif; ?>
                    </li>
                    
                    <li>
                    <? if(!$session->is_signedIn()): ?>
                        <a href="register.php">Register</a>
                    <? endif; ?>
                    </li>
                    
                    <!-- Check the User Role for Admin -->
                    <? if(isset($_SESSION['user_role'])): ?>
                        <? if($_SESSION['user_role'] !== 'subscriber'): ?>
                    
                    <li>
                    <a href="admin">Admin</a>
                    </li>
                    
                        <? endif; ?>
                    <? endif; ?>
                    
                    <!-- Check the User Role for Editing Photo -->
                    <? if(isset($_SESSION['user_role'])): ?>
                        <? if($_SESSION['user_role'] !== 'subscriber'): ?>
                            <? if(isset($_GET['id']) && !empty($_GET['id'])): ?>
                    
                    <li>
                    <a href="admin/edit_photo.php?photo_id=<? echo $_GET['id']?>">Edit Photo</a>
                    </li>
                           
                            <? endif; ?>
                        <? endif; ?>
                    <? endif; ?>
                    
                    <!-- Check the User Role for Profile -->
                    <? if(isset($_SESSION['user_role'])): ?>
                        <? if($_SESSION['user_role'] == 'subscriber'): ?>
                    
                    <li>
                    <a href="profile.php">My Profile</a>
                    </li>
                    
                        <? endif; ?>
                    <? endif; ?>
                    
                     
                    <!-- Add the dropdown user and profile and logout -->
                    <ul class="nav navbar-nav navbar-right">
                    <? if($session->is_signedIn()): ?>
                        <li style="margin-right: 10px" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <? echo $_SESSION['username'] ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                                </li>

                                <li class="divider"></li>
                                <li>
                                    <a href="admin/includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    <? endif; ?>
                    </ul>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
               
               <!-- Deprecated Code -->
       
       
<!--
        Line : 15
        ---------
                
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    
                </ul>
--> 