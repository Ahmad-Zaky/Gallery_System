<!-- Pagination -->
            <div class="row">
                <ul class="pager">
                  <!-- photos if user is not specified -->
                   <? if(!$id): ?>
                       <!-- Check total Pages -->
                       <? if($paginator->Total_pages() > 1): ?>
                       
                           <!-- NEXT -->
                           <? if($paginator->has_next()): ?> 
                    <li class="next">
                       <a href="index.php?page=<? echo $paginator->Next();?>">Next</a>
                    </li>
                            <? endif; ?>
                       <!-- /.NEXT -->
                    
                       <!-- PAGE Nr -->
                           <? for($i = 1; $i <= $paginator->Total_pages(); $i++): ?>
                               <? if($i == $page): ?>
                       <li class="active">
                           <a href="index.php?page=<? echo $i ?>"><? echo $i ?></a>
                       </li>
                               <? else: ?>
                       <li>
                           <a href="index.php?page=<? echo $i ?>"><? echo $i ?></a>
                       </li>
                               <? endif; ?>
                           <? endfor;?>
                           <!-- /.PAGE Nr -->
                       
                       
                            <!-- PREVIIOUS -->
                            <? if($paginator->has_previous()): ?>    
                    <li class="previous">
                       <a href="index.php?page=<? echo $paginator->Previous();?>">Previous</a>
                    </li>
                            <? endif; ?>
                            <!-- /.PREVIIOUS -->
                        
                        <? endif; ?>
                        <!-- /.Check total Pages -->
                    
                    
                    <!-- /.photos if user is not specified -->
                    <? else: ?>
                    <!-- User photos if user is specified -->
                    
                       
                        <!-- Check total Pages -->
                        <? if($paginator->Total_pages() > 1): ?>
                       
                           <!-- NEXT -->
                           <? if($paginator->has_next()): ?> 
                    <li class="next">
                       <a href="index.php?photo_id=<? echo $id;?>&page=<? echo $paginator->Next(); ?>">Next</a>
                    </li>
                           <? endif; ?>
                           <!-- /.NEXT -->
                    
                           <!-- PAGE Nr -->
                           <? for($i = 1; $i <= $paginator->Total_pages(); $i++): ?>
                               <? if($i == $page): ?>
                       <li class="active">
                           <a href="index.php?photo_id=<? echo $id;?>&page=<? echo $i ?>"><? echo $i ?></a>
                       </li>
                               <? else: ?>
                       <li>
                           <a href="index.php?photo_id=<? echo $id;?>&page=<? echo $i ?>"><? echo $i ?></a>
                       </li>
                               <? endif; ?>
                           <? endfor;?>
                           <!-- /.PAGE Nr -->
                       
                       
                            <!-- PREVIIOUS -->
                            <? if($paginator->has_previous()): ?>    
                    <li class="previous">
                       <a href="index.php?photo_id=<? echo $id;?>&page=<? echo $paginator->Previous();?>">Previous</a>
                    </li>
                            <? endif; ?>
                            <!-- /.PREVIIOUS -->
                        
                        <? endif; ?>
                        <!-- /.Check total Pages -->
                    <? endif; ?>
                    <!-- /.User photos if user is specified -->
                </ul>
            </div>  
            <!-- /.Pagination -->