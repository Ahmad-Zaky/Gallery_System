<?php

    interface Userface{


        // verify usr and pwd with DB
        public static function verify_user($username, $password);

        // check if there is user with the same username 
        public static function find_byUsername($username);

        // get all admin users from DB    
        public static function get_admin_users();

    }

?> 