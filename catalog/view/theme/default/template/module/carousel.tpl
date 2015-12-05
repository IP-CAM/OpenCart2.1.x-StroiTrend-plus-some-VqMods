   
   <div class="mfilter-box">
   <h3 class="box-heading" style="margin-bottom:10px;">Последние статьи</h3>
   

   <div id="carousel<?php echo $module; ?>" class="owl-carousel">
    <?php foreach ($banners as $banner) { ?>
        <div class="item text-center">
            <?php if ($banner['link']) { ?>
                <a href="<?php echo $banner['link']; ?>">
                <img src="<?php echo $banner['preview']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                
                
                
                
                </a>
                <p></p>
                <p style="text-align-center;">
                <b>
                <a href="<?php echo $banner['link']; ?>">
                 <?php echo $banner['title']; ?>   </a>
                   </b> 
                </p>
                <p>
                <?php echo $banner['description']; ?>
               </p>
               
               <a href="<?php echo $banner['link']; ?>" style="padding-bottom:10px;display:block;">
                   Перейти к статье
               </a>
               
                <?php } else { ?>
                    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                    <?php } ?>
        </div>
        <?php } ?>
</div>
</div>
<script type="text/javascript">
    <!--
    $('#carousel<?php echo $module; ?>').owlCarousel({
        items: 1,
        autoplay:true,
        loop:true,
        autoplayTimeout:8000,
        navigation: true,
        navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
        pagination: true
    });
    -->
</script>