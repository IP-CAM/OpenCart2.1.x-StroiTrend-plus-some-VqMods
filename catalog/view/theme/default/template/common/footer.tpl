<footer>
    <div class="container">
        <div class="row">

            <?php if ($logo) { ?>
                <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>"  style="display: block;width: 60px;margin: 0 auto;border: 1px solid #fff;" class="img-responsive"/></a>
                <?php } else { ?>
                    <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                    <?php } ?>

        </div>
        <br />
        <div class="row AlignTc">

            <div class="col-xs-10 col-xs-offset-1 "><a class="uppcase fsize11" href="" title="titles">Главная</a>
                <?php foreach ($categories as $category) { ?>
                    <?php if ($category['children']) { ?>
                        <a class="uppcase fsize11" href="<?php echo $category['href']; ?>">
                            <?php echo $category['name']; ?>
                        </a>
                        <?php } ?>
                            <?php } ?>

                                <a class="uppcase fsize11" href="<?php echo $AboutUs; ?>">О&nbsp;Компании</a>
                                <a class="uppcase fsize11" href="<?php echo $contact; ?>" title="titles">Контакты</a>
                                
                                
        
            </div>

            <div class="col-xs-1 upsite" style="float:right">
                <a href="#top" title="titles">
                    <i class="fa fa-angle-up fsize28"></i>
                </a>
       </div>

        </div>
        <br>
        <div class="row AlignTc">

            <div class="col-md-12 ">
                <a href="#" title="titles"><i class="fa fa-instagram fsize28" ></i></a>
                <a href="#" title="titles"><i class="fa fa-google-plus fsize28" ></i></a>
                <a href="#" title="titles"><i class="fa fa-twitter fsize28" ></i></a>
                <a href="#" title="titles"><i class="fa fa-vk fsize28"></i></a>
                <a href="#" title="titles"><i class="fa fa-facebook fsize28" ></i></a></div>
        </div>
        <br>
        <div class="row AlignTc">
            <div class="col-md-12 "><a href="" title="titles">КОПИРАЙТ&nbsp;&copy;&nbsp;2015&nbsp;СТРОЙ&nbsp;ТРЕЙД</a></div>

        </div>
        <div class="row AlignTc">
            <div class="col-md-12 "><a style="margin-left: -3px;" href="http://divotek.com" title="titles">CREATED&nbsp;BY&nbsp;DIVOTEK&nbsp;WEB&nbsp;-&nbsp;STUDIO</a></div>
        </div>
        <br>
        <br>
        <br>
    </div>
</footer>

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->

</body>

<script>
 $('a[href^="#"]').click(function (e) {
 e.preventDefault();
 var link = $(this).attr('href');
 if (link.length > 1) {
  $('body').animate({
   scrollTop: $(link).position().top
  } , 400);
 }
});
</script>


</html>