# Gallery CMS System

> Its My own version Project which I built along side with Udemy OOP PHP Course and here you can find a brief explanation of my CMS system to show you my code structure and the features I added to the system. 

## Table of content:

 * [summary](#summary)
 * [layout](#layout)
 * [features](#features)


## Summary

* I created a Gallery system which containts two parts the __public section__ where the internet users can browse and the __admin section__ which only admin users can browse for Control Management System (CMS).

* I hosted my web application online so you can see it by your self

    - Subscriber username: user
    - Subscriber password: user
    - Admin username: admin
    - Admin password: admin

    http://ahmedzaky.epizy.com/gallery

## Layout

* The project layout   
![Layout Image](/images/project_layout.jpg)
  
  - Admin Section:  
  ![admin Section](/images/admin_section.jpg)  

    * We can find here the Frontend directories like __css__, __js__, __fonts__, ... etc.

    * __includes__ directory   
    ![admin includes](/images/admin_includes.jpg) 
    
        - which contains the Project classes, config file, init file, html front end files like header, footer, ... etc,

        - We have also the admin section files which we will talk more in details about them in [features section](#features)

  - Public section: 

    * Here there is also the Frontend directories same like __admin section__, and we have also th e Public files and we will take more in details about the files in [features section](#features)

## Features

* Here I will categorise the features in which each feature will be referenced to its php file where I used it:

    - [Code structure](#code-structure)
    - [Back end](#back-end)
    - [Front end](#Front-end)
 

### Code structure

* init.php file:

    - This files includes all my classes and interfaces, session, and other important files for the system and I included init.php file in the header file to be included all over the system.

* new_config.php file:
    
    - Here I defined all my __CONSTANTS__ like __DB__ connection constants, and __ROOT PATHS__ Constants. 

* Classes and interfaces:

    - As you know from the [Summary](#summary) my system is Object oriented based PHP code, so I will discuss breifly the classes I built.

      * Database class

        - Here I did use a Design pattern called singleton which means that the class can only create one object instance from it self and any other object created after the first one is just a reference to the first created object and it is useful in some cases when I only need one instance and here for our database connection we need only one connection to one database.

        - You can see the class feature functions from its interface.  
        
        ```php
       
       
          interface Database_interface{

            // Establish a DB Connection using mysqli object
            public function open_connection_db();

            // create one object within the class (singleton pattern)
            public static function get_instance();

            // return the db connection
            public function get_connection();

            // Making a Query
            public function query($sql);

            // escaping sql strings
            public function escape_string($string);

            // getting the already inserted id
            public function inserted_id();

            // getting affected rows from last operation
            public function affected_query();
        }

       
        ```
        
        
        
    * Session class
        
        - It is responsible for tracking loged in users and manage there roles.  
       
        ```php
        

        interface Session_interface{

            // get the session sign_is status
            public function is_signedIn();

            // set the first user login session by passing its object
            public function login($user);

            // unset the session and object properties to log out
            public function logout();

            // get a message and set a message if there is not 
            public function message($msg);

            // custom function to turn message to empty
            public function set_msg_empty();

            // check views by refreshing
            public function views_counter();

        }

        
        ```

    * DB_object class
        
        - This is my __parent class__ for database table classes (__User__, __Photo__, __Comment__) 

            * Here I refacored a lot of functions to be generic and usable for all my table classes like CRUD functions and more (create_obj, properties, clean_properties, ... etc)
            
            Example:  
            
            ```php
            
            // create a new object
            public static function create_obj($properties){


                if(isset($properties) && !empty($properties)){

                    // create a new object
                    $called_class = get_called_class();
                    $new_obj = new $called_class;

                    // loop in class properties
                    foreach($properties as $property => $value){

                        // check each $property if exists
                        if($new_obj->has_attribute($property)){
                            $new_obj->$property = $value;
                        }else
                            return false;
                    }
                    return $new_obj;
                }
                return false;
            }
            
            ```

            * I also used an array in each class to hold the table fields names   
            `$db_table_fields = array( /* table fields name */);`

            * and variable to hold the table name  
            `$db_table = /* table name */`

            * They help me to iterate through each class table fields by its table name and execute genric functions declared at the parent class.
            
            Example:  
            
            ```php
            
            // get class properties
            protected function properties(){

                $properties = array();

                foreach(static::$db_table_fields as $table_field){
                    if(property_exists($this, $table_field)){
                        $properties[$table_field] = $this->$table_field;
                    }
                }
                return $properties;
            }

            // get class properties after escaping the string 
            protected function clean_properties(){

                global $db;
                $clean_properties = array();

                foreach($this->properties() as $key => $value){
                    $clean_properties[$key] = $db->escape_string($value);
                }
                return $clean_properties;
            }
            
            ```

            

    * Paginator class

        - Here I created a class to control the pagination feature.  

        ```php
        
           interface Paginator_interface{
        
                // Next and Previous functions 
                public function Next();

                public function Previous();

                // Total Nr of Pages function
                public function Total_pages();

                // has_next() && has_previous() functions
                public function has_next();

                public function has_previous();

                // get the next number of photos for the next page
                public function offset();
            }

        
        ```


    * Utilities classes

        - This class combines all the functions which combines the relation between the view and the database.

        - Examples:  
            
            * CRUD Utilities which handles the crud requests comes from the user.  

            ```php
            
                interface Utilities_CRUD_interface{

                    public static function create_user();

                    public static function update_user();

                    public static function create_photo();

                    public static function update_photo();

                    public static function create_comment();
                }
            
            
            ```

            * User Utilities which handles functionalities related to user.  
            
            ```php
            
              interface Utilities_user_interface{

                public static function find_byUsername($username);

                public static function registeration();

                public static function login_form();
            }
            
            ```


### Back end

> Here you will find the php functionalities related to the view.   

* __User side__

    - **Home page** `index.php`
    
        1. I added the photos stored in the server and have records in the DB in a fixed size using pages.
        2. The pages are numbers and Next, Previous Next button disappears at the last page and previous button disappears at the first page.
        3. The top nav bar has links show up based on the login state for example if I am a new user the links will be `login` and `register` if I did register as a regular user I will get `logout`, and `Profile` links, and if I did login as admin user firstly I will be redirected to the __Dashboard__ but if I go to __Home Page__ I will find `Admin`, and `logout` links. 
    
    - **Photo page** `photo.php`
        
        1. I will fetch the photo from th DB using its ID.
        2. show Photo information and change the time to a readable Date time using `formate_date_time($date_time)`
        
        ```php
        
        // --- Format Date and Time ---
        function format_date_time($date_time){

            // Date 
            $Day_nr = date('d', strtotime($date_time));
            $Day_name = date('D', strtotime($date_time));
            $Month = date('F', strtotime($date_time));
            $Year = date('Y', strtotime($date_time));

            // Time 
            $hour = date('h', strtotime($date_time));
            $minute = date('i', strtotime($date_time));
            $_12Sys = date('A', strtotime($date_time));

            // should look like this 'Tue 24 August, 2013 at 9:00 PM'
            return "$Day_name $Day_nr $Month, $Year at $hour:$minute $_12Sys";

        }
        
        ```
        
        3. if I am logged in the name textbox will disappear and you will see your username instead.
    - **Reigester Page** `register.php`
        
        1. check empty fields.
        2. check username with db so username will be unique for each user.
        3. check password match with confirmation.
        4. encrypt the password with Aragon2i algorithm online I am using a nother algorithm.
        5. using regular expression for email.
        
    - **Profile Page** `profile.php`
    
        1. It shows the subscriber profile to edit his own profile
        2. check empty fields.
        3. check username with db so username will be unique for each user.
        4. check password match with confirmation.
        5. encrypt the password with Aragon2i algorithm online I am using a nother algorithm.
        6. using regular expression for email.
        7. show notifications if successfully changed or if nothing changed.
        8. show error notifications if an error occured.
        
* __Admin side__

    - **Dashboard** `index.php`
    
        1. Show the Nr. of my gallery system classes like how many photos, users, comments I have, and nr of views based on the refreshing of the page.
        2. Pie charts show the difference between the approved and unapproved for (photos, users, comments).
        3. There is also a Pie chart which shows the number of photos related to the admin user who did upload these photos.
    - **Users Page** `users.php`
    
        1. There is selected options to select all or some and applay some functionalities on all selected users like change user role or delete them.
        2. Each user has a link for delete except the logged in user I prevented him fromdeleting him self.
        3. Each user without a photo I add a placeholder image instead.
        4. if I wanna edit or add the user I will have the same validation found in registeration Form page.
        5. if I edit a user It will except the password fields from checking if empty.
       
    - **Upload Dropdown**  
    
        - **Normal Upload** `upload.php`
        
            1. Here I allow to add empty photo but it will not be published untill it is completed.
        
        - **Multi Upload** `multi_upload.php
        
            1. Here I used online API called Dropzone to allow multiple photo uploads.

    - **Photos Page** `photos.php`
    
        1. beside the functionalities which are same as users page here the file size is been changed to be more readable.
        
        ```php
        // function to format the file size in more readable way with units
        public function format_bytes($bytes, $precision = 2){
            $units = array('B', 'KB', 'MB', 'GB', 'TB');

            // in case negative input
            $bytes = max($bytes, 0);

            // get the power which indicates one of the units above
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));

            // in case the unit is larger than 'TB'
            $pow = min($pow, count($units) - 1);

            // convert bytes to its closest unit
            $bytes /= (1 << (10 * $pow)); // bit wise method

            return round($bytes, $precision) . ' ' . $units[$pow];
        }
        ```
        2. I created a link for comments which take you to a file with the comments related to this photo.
    
    - **My Photos** `my_photos.php`
        
        * here I group all the registered admin photos
        
    - **Edit Photo** `edit_photo.php`
    
        1. Here I did add a popup window when you click on the photo which show you all the photos uploaded on the system and I can pick any one of them and it will load me the edit photo page for that picked photo.
        2. I added a side bar for meta data which can be droped up and down using `Javascript`

    - **Comments Page** `comments.php`
    
        1. Here you find the comment and a photo where the comment was posted.
        2. I have 2 fields of users one for the commenter who is not registered `Author` and the other is for registered commenters `User`.
        
        
### Front end

> I used here some Javascript and JQuery to improve my admin side view and the practicality of the Project and I also used CSS and Bootstrap to customize the view of the project.

* __Javascript and JQuery Examples__

    - select all checkBoxes option
    
    ```php
    
    // select all checkboxes option
    $("#selectAllBoxes").click(function(event){
        
        if(this.checked){
            $(".checkBoxes").each(function(){
                this.checked = true;
            });
        }else{
            $(".checkBoxes").each(function(){
                this.checked = false;
            });
        }
    });
    
    ```
    
    - Turn the sidebar up and down in `edit_photo.php` file
    
    ```php
    
    // in edit Photo turn the sidebar up and down
    $(".info-box-header").click(function(){
        
        $(".box-inner").slideToggle("fast");
        $("#toggle").toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon ");
        
        // Hint:
        // -----
        
        // the spaces in toggleClass are very important before the ',' you should leave a white space and before the end also like you see above.
        
    });
    
    ```
    
    - Popup a confirmation window before delete in Admin side
    
    ```php
    
    // confirm delete link before execution
    $(".delete-link").click(function(){
       
        return confirm("Confirm with 'ok' if want realy delete the Item.");
    });
    
    // Text editor
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        });
    
    ```
       
* __Online APIs__

    - Text editor API (CKEditor) used in `edit_photo.php`, `upload.php` and the script is placed in the `header.php` 
    ```html

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>

    ```
    
    - Pie chart Google API used in the __Dashboard__ at admin side
    
    ```html
    <!-- Pie Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    ```





