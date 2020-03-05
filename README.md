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
![Layout Image](\images\project_layout.jpg)
  
  - Admin Section:  
  ![admin Section](\images\admin_section.jpg)  

    * We can find here the Frontend directories like __css__, __js__, __fonts__, ... etc.

    * __includes__ directory   
    ![admin includes](\images\admin_includes.jpg) 
    
        - which contains the Project classes, config file, init file, html front end files like header, footer, ... etc,

        - We have also the admin section files which we will talk more in details about them in [features section](#features)

  - Public section: 

    * Here there is also the Frontend directories same like __admin section__, and we have also th e Public files and we will take more in details about the files in [features section](#features)

## Features

* Here I will categorise the features in which each feature will be referenced to its php file where I used it:

    - [Code structure](#code-structure)
    - [Front end](#Front-end)
    - [Back end](#back-end)

### Code structure

* init.php file:

    - This files includes all my classes and interfaces, session, and other important files for the system and I included init.php file in the header file to be included all over the system.

* new_config.php file:
    
    - Here I defined all my __CONSTANTS__ like __DB__ connection constants, and __ROOT PATHS__ Constants. 

* Classes and interfaces:

    - As you know from the [Summary](#summary) my system is Object oriented based PHP code, so I will discuss breifly the classes I built.

      * Database class

        - Here I did use a Design pattern called singleton which means that the class can only create one object instance from it self and any other object created after the first one is just a reference to the first created object and it is useful in some cases when I only need one instance and here for our database connection we need only one connection to one database.

        - You can see the class feature functions from its interface  
        ![database interface](/images/database_interface.jpg)

    * Session class
        
        - It is responsible for tracking loged in users and manage there roles.  
            ![session interface](/images/session_interface.jpg)

    * DB_object class
        
        - This is my __parent class__ for database table classes (__User__, __Photo__, __Comment__) 

            * Here I refacored a lot of functions to be generic and usable for all my table classes like CRUD functions and more (create_obj, properties, clean_properties, ... etc)
            
            Example:
            ![create_object](/images/create_object.jpg)

            * I also used an array in each class to hold the table fields names   
            `$db_table_fields = array( /* table fields name */);`

            * and variable to hold the table name  
            `$db_table = /* table name */`

            * They help me to iterate through each class table fields by its table name and execute genric functions declared at the parent class.
            
            Example:
            ![properties and clean](/images/properties_clean.jpg)

            

    * Paginator class

        - Here I created a class to control the pagination feature
        ![paginator interface](/images/paginator_interface.jpg)

    * Utilities classes

        - This class combines all the functions which combines the relation between the view and the database.

        - Examples:  
            
            * CRUD Utilities which handles the crud requests comes from the user.
            ![utilities crud](/images/utilities_crud.jpg)

            * User Utilities which handles functionalities related to user.
            ![utilities user](/images/utilities_user.jpg)

### Front end

> I used here some Javascript and JQuery to improve the view and the practicality of the Project


### Back end






