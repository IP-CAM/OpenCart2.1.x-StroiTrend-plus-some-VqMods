<div class="Article">
<div class="Head col-md-12">
    <?php echo $heading_title; ?>
</div>
<div class="row mr">
    <?php $i=0;foreach ($all_articles as $articles) { $i++;
        if($i>9){break;}
        ?>

        <div class="col-md-4 mr">
           <div class="box">
            <div class="row">

                <?php if ($articles['image']) { ?>
                    <div class="text-center">
                       <a href="<?php echo $articles['view']; ?>">
                      <div class="img-container">  <img class="mra" src="<?php echo $articles['image']; ?>" alt="<?php echo $heading_title; ?>" /> </div>
                       </a>
                    </div>
                    <?php } ?>
            </div>
            <div class="row mr">
                <a class = "title" href="<?php echo $articles['view']; ?>">
                   <?php echo $articles['title']; ?>
                
                
                </a>
                </div>
<div class="text" style="min-height:90px;">
              <i>
              <?php echo $articles['description']; ?>
              </i>  
            </div>
            <div class="row mr" style="margin-bottom:35px;">
                    <a class="buttinv" href="<?php echo $articles['view']; ?>" >
                            Подробней
                    </a>
                    
                    </div>
            </div>
        </div>

        <?php } ?>
</div>
</div>