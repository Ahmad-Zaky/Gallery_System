<?php 

    interface Comment_interface{
        
        // find comments by photo ID
        public static function find_comm_by_photoID($photo_id);
    }

?>