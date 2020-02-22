$(document).ready(function(){
    
    
  
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
    
    // in edit Photo turn the sidebar up and down
    $(".info-box-header").click(function(){
        
        $(".box-inner").slideToggle("fast");
        $("#toggle").toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon ");
        
        // Hint:
        // -----
        
        // the spaces in toggleClass are very important before the ',' you should leave a white space and before the end also like you see above.
        
    });
    
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
});

                            

                        /* ------ Deprecated Code ------ */




// There another texteditor used in the course PHP OOP called TinyMCE
// have a look at video#129 Called 'Installing the texteditor' in Section 15(ADMIN PHOTOS edit photo section)

//    // select all checkboxes
//    $('#selectAllBoxes').click(function(event){
//        if(this.checked){
//            $('.checkBoxes').each(function(){
//               this.checked = true; 
//            });
//        }else{
//            $('.checkBoxes').each(function(){
//               this.checked = false; 
//            });  
//        }
//    });








// -> The objective for this snippet is getting infos from the photo_lib_modal.php         and try to use ajax on it and send these infos to process it to another php           file in the server.

//    $(".modal_thumbnails").click(function(){
//        
//        $("#set_photo").prop('disabled', false);
//        
//        // get the photo Id so I can pull the photo infos
//        var photo_id;
//        photo_id = $(this).attr('data');
//        
//        
//        // send the id to ajax.php
//        $.ajax({
//            
//            url: "includes/ajax_code.php",
//            data: {id: photo_id},
//            type: "POST",
//            dataType: 'json',
//            success: function(data){
//                // I don't konw it we should put something here?
//                if(!data.error){
////                    location.reload(true);
//                    alert(data);
//                }
//            }
//        });
//    });
//    
//    $("#set_photo").click(function(){
//        
//    });
//    
//  