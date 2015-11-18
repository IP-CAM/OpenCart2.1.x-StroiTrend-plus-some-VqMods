
  
</div>
 </div>


  <div id="slideshow<?php echo $module; ?>" class="owl-carousel collapse" style="opacity: 1;">
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

<?php foreach ($banners as $banner) { $i++; ?>
  

<div class="popup-preview">
 <a onClick="$('#slideshow<?php echo $module; ?>').trigger('to.owl.carousel',<?php echo $i ?>)"><img src="<?php echo $banner['preview']; ?>" alt="" href></a>       
 </div>
 <?php } ?>



        <script type="text/javascript">
    <!--
    $('#slideshow<?php echo $module; ?>').owlCarousel({
        items: 1,
        autoPlay: 6000,
        singleItem: true,
        navigation: true,
        navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
        pagination: true
    });
    -->
      </script>
      
      
      
      
<div class="container">
<div class="row">


