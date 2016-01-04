</div>

   <footer id="footer">
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
                <a id='myTops' href="#top" title="titles">
                    <i class="fa fa-angle-up fsize28"></i>
                </a>
       </div>

        </div>
      
    <!--    <div class="row AlignTc">

            <div class="col-md-12 ">
                <a href="#" title="titles"><i class="fa fa-instagram fsize28" ></i></a>
                <a href="#" title="titles"><i class="fa fa-google-plus fsize28" ></i></a>
                <a href="#" title="titles"><i class="fa fa-twitter fsize28" ></i></a>
                <a href="#" title="titles"><i class="fa fa-vk fsize28"></i></a>
                <a href="#" title="titles"><i class="fa fa-facebook fsize28" ></i></a>
                </div>
              
        </div>  -->
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

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34457135 = new Ya.Metrika({
                    id:34457135,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34457135" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34457465 = new Ya.Metrika({
                    id:34457465,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71803016-1', 'auto');
  ga('send', 'pageview');

</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34457465" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<!-- * = * -->
<?php require_once DIR_CONFIG .'ssb_library/ssb_data.php';
$this->ssb_data = ssb_data::getInstance();
$tools = $this->ssb_data->getSetting('tools');
if($tools AND isset($_SESSION["ssb_page_type"])){
	if($tools['qr_code']['status'] OR $tools['soc_buttons']['status']){
		$soc_buttons = $tools['soc_buttons'];
		$qr_code = $tools['qr_code'];
		require_once DIR_CONFIG .'ssb_library/catalog/tools/tool.php';
		$this->tool = tool::getInstance();
		$curPageURL = $this->tool->curPageURL();
		if($tools['qr_code']['status']){
			$qr_image_path = $this->tool->get_qr($curPageURL);
			$qr_image = "<img class='count' src='" . $qr_image_path . "' />";
		}
		include_once DIR_CONFIG .'ssb_library/catalog/tools/panel_bar.tpl';
	}
}
?>
<!-- * = * -->
				
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
    
    


$( document ).ready(function() {
    

    
       $(window).scroll(function () { 
if ($(this).scrollTop() > 300) 
$('#myTops').fadeIn(); 
else 
$('#myTops').fadeOut(); 
}); 
$('#myTops').click(function () { 
$('body, html').animate({scrollTop: 0}, 400); 
})

});


    
</script>



                                                        <script type="text/javascript" src="catalog/view/javascript/callback.js"></script>
                                                        <script type="text/javascript" src="catalog/view/javascript/jquery.simplemodal.js"></script>
                                                        
                                                        
                                                        

</html>