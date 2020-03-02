<?php 

    class Paginator implements Paginator_interface{
        
        private $page;
        private $IPP; // IPP: Items Per Page
        private $ITC; // ITC: Items Total Count
        
        private $errors = array();
        
        // Magic methods (construct)
        function __construct($page=1, $IPP=4, $ITC=0){
            
            $this->page = (int)$page;
            $this->IPP = (int)$IPP;
            $this->ITC = (int)$ITC;
        }
        
        // Magic methods (set and get)
        function __set($property, $value){
            
            if(property_exists($this, $property))
                $this->$property = $value;
            
            $this->errors[] = "Failed to set $property to $value!";
        }
        
        function __get($property){
            
            if(property_exists($this, $property))
                return $this->$property;
            
            $this->errors[] = "Failed to get $property!";
        }
        
        
        // Next and Previous functions 
        public function Next(){ // Uppercase because next() is built-in function
            return $this->page +1;
        }
        
        public function Previous(){
            return $this->page -1;
        }
        
        // Total Nr of Pages function
        public function Total_pages(){
            return ceil($this->ITC / $this->IPP);
        }
        
        // has_next() && has_previous() functions
        public function has_next(){
            return ($this->Next() ) <= ($this->Total_pages()) ? true : false;
        }
        
        public function has_previous(){
            return ($this->Previous() ) >= 1 ? true : false;
        }
        
        public function offset(){
            return ($this->page -1) * ($this->IPP);    
        }
        
        
    }
    
    
?>


                    <!-- List of features to add in future -->


<!-- 

    ----------
    TODO List:
    ----------

    1. two constructors instead of one? (I don't think it is necessary)
    
    
-->

                            <!-- Deprecated code -->
                            
<!-- 

 
  
   
    
 -->