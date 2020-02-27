<?php 

    interface Databaseface{
        
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

?>