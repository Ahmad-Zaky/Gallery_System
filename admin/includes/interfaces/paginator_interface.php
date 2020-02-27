<?php 

    interface Paginatorface{
        
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
    
?>