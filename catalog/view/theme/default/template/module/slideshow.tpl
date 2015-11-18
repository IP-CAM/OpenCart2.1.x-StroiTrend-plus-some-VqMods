
  
</div>
 </div>


  <div id="slideshow<?php echo $module; ?>" class="owl-carousel collapse" style="opacity: 1; max-height:600px;">
    <?php foreach ($banners as $banner) { ?>
        <div class="item">
            <?php if ($banner['link']) { ?>
                <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
                <?php } else { ?>
                    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                    <?php } ?>
        </div>


        <?php } $i=0; ?>
</div>
<div class="container" style="position:relative;    margin-bottom: 20px;">
<div class="popup-preview row">
<?php foreach ($banners as $banner) { $i++; ?>
  <div class="col-md-3">
  
                
                   
<a onClick="$('#slideshow<?php echo $module; ?>').trigger('to.owl.carousel',<?php echo $i-1 ?>)"><img src="<?php echo $banner['preview']; ?>" alt="" align="middle" href><div class="froboto text-center valc">
                    <span> <?php echo $banner['title']; ?> </span>
                    <hr>
                  </div>  
           </a>       
           
</div>
 <?php } ?>
 </div>
</div>

        <script type="text/javascript">
    <!--
    $('#slideshow<?php echo $module; ?>').owlCarousel({
        items: 1,
        autoplay:true,
        loop:true,
        autoplayTimeout:8000,
        autoplayHoverPause:true

    });

    -->
      </script>
      
      
      
      
<div class="container">
<div class="row">


