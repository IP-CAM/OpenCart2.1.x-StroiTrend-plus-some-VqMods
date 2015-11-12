</div>
</div>
</div>
<div class="News row">

<div class="container">
<div class="Head col-md-12" style="text-align:left;">
    <?php echo $heading_title; ?>
</div>
<div class="row mr">
    <?php $i=0;foreach (array_reverse($all_news) as $news) { $i++;
        if($i>3){break;}
        ?>

        <div class="col-md-4  mr">
           
            <div class="row">

                <?php if ($news['image']) { ?>
                    <div class="text-center static">
                      <div class="Abs">
                       <a href="<?php echo $news['view']; ?>">
                        <img class="mra" src="<?php echo $news['image']; ?>" alt="<?php echo $heading_title; ?>" />
                       </a>
                       </div>
                       <div class="slider">
                           <p>asdasd</p>
                           <p>asd</p>
                           <p>asd</p>
                           <p>asd</p>
                           <p>asd</p>        
                       </div>
                    </div>
                      
                      
                       
                        
                    
                    
                    
                    
                    
                    
                    <?php } ?>
                    
                
                    
                    
            </div>
            
            
            
            
            
            
            
            
            
            
            
            <div class="row mr">
                <a class = "title" href="<?php echo $news['view']; ?>">
                   <?php echo $news['title']; ?>
                
                
                </a>
                </div>
<div class="row mr" style="min-height:90px;">
              <i>
              <?php echo $news['description']; ?>
              </i>  
            </div>
            <div class="row mr">
                    <a class="buttinv" href="<?php echo $news['view']; ?>">
                            Подробней
                    </a>
            </div>
        </div>

        <?php } ?>
</div>
</div>
</div>
<div class="container">
<div class="row">