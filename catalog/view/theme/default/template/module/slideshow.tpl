</div>
</div>
<div id="slideshow" >
   <div id="slideshow<?php echo $module; ?>" class="owl-carousel collapse" style="opacity: 1; ">
    <?php foreach ($banners as $banner) { ?>
        <div class="item">
            <?php if ($banner['link']) { ?>
                <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                <?php } else { ?>
                    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                    <?php } ?>
                        <div class="slideshowtxt" >
                            <div class="titlef fplay">
                                <p>
                                    <?php echo $banner['title']; ?>
                                </p>
                            </div>
                            <div class="titles">
                                <p>
                                    <?php echo $banner['description']; ?>
                                </p>
                            </div>
                            <div class="slideshowbtn">
                                <a class="buttonbls"   href="<?php echo $banner['link']; ?>">Перейти к статье</a>
                            </div>
                        </div>
        </div>
        <?php } $i=0; ?>

            
</div>
<div class="container" style="position:relative;    margin-bottom: 20px;">
                <div class="popup-preview row">
                    <?php foreach ($banners as $banner) { $i++; ?>
                        <div class="col-lg-3">
                            <div  class="hov">
                                <a onClick="$('#slideshow<?php echo $module; ?>').trigger('to.owl.carousel',<?php echo $i-1 ?>)" href="#">
<div class="img-container " > <img src="<?php echo $banner['preview']; ?>" alt="" align="middle" href style="opacity:0.8;"></div>
                                    <div class="frobototh text-center valc">

                                        <span> <?php echo $banner['title']; ?> </span>
                                        <hr class="msld">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                </div>
            </div>

</div>

<br>








<script type="text/javascript">
    <!--
    $('#slideshow<?php echo $module; ?>').owlCarousel({
        items: 1,
        autoplay: true,
        loop: true,
        autoplayTimeout: 8000,
        autoplayHoverPause: true

    });

    -->
</script>




<div class="container">
  