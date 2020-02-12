$(document).ready(function(){
    
    // Text editor
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
});

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