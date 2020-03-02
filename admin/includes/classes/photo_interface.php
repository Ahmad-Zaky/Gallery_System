<?php 
    
    interface Photo_interface{
        
        // get photo username function
        public function find_photo_username();
        
        // find Photos by user ID
        public static function find_photos_by_userID($user_id);
        
        // get approved photos count and user photos if specified
        public static function custom_counter_approved($user_id);

        // get the page photos from DB
        public static function get_page_photos($paginator, $user_id);
    }

?>