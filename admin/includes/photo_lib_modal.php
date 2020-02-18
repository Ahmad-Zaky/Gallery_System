<?php $photos = Photo::find_all(); ?>
<div class="modal fade" id="photo-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Gallery System Library</h4>
        </div>
      
      <!-- Modal Body-->
      <div class="modal-body">
          <!-- col-md-9 -->
          <div class="col-md-9">
             <div class="thumbnails row">
            
                <!-- PHP LOOP HERE CODE HERE-->
                <? foreach($photos as $photo): ?>
               <div class="col-xs-2">
                 <a href="edit_photo.php?photo_id=<? echo $photo->photo_id; ?>" role="checkbox" aria-checked="false" tabindex="0" id="" class="thumbnail">
                   <img class="modal_thumbnails img-responsive" src="<? echo $photo->photo_path();?>" data="<? echo $photo->photo_id; ?>">
                 </a>
                 
                 <!-- This could also be used to get photo_id and hide it with hidden class -->
                 <div class="photo-id hidden"></div> 
               
               </div>
                <? endforeach; ?>
                <!-- PHP LOOP HERE CODE HERE-->

             </div>
          </div>
          <!-- /.col-md-9 -->

    <div class="col-md-3">
    <div id="modal_sidebar"></div>
    </div>

    </div>
    <!-- /.Modal Body-->
     
      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

     
                            <!-- Deprecated code -->
                            
                            
<!--
   
   
    -> Line : 41            
    ------------
    
      <div class="modal-footer">
        <div class="row">
                Closes Modal
              <button id="set_photo" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal">Apply Selection</button>
        </div>
      </div>
      
-->
