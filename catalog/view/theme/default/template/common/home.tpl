<?php echo $header; ?>
    <div class="container">
        <div class="row">
            <?php echo $column_left; ?>
                <?php if ($column_left && $column_right) { ?>
                    <?php $class = 'col-sm-6'; ?>
                        <?php } elseif ($column_left || $column_right) { ?>
                            <?php $class = 'col-sm-9'; ?>
                                <?php } else { ?>
                                    <?php $class = 'col-sm-12'; ?>
                                        <?php } ?>
                                            <div id="content" class="<?php echo $class; ?>">
                                                <?php echo $content_top; ?>





                                            </div>



                                            <div class="News static">
                                               <div class="container">
                                                <div class="row mr">
                                                    <p class="Head">
                                                        Преймущества Строй-трейд
                                                    </p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                     <div class="white_box">   <p class="froboto fsize16">
                                                            Постоянно в наличии
                                                        </p>
                                                        <div class="row">
                                                        <img src="<?php echo HTTP_SERVER;  ?>image/catalog/static/plitki.jpg" alt="">
                                                        </div>
                                                        <i  clas="fsize11">
                                                            Все виды фанеры на сайте имеются в наличии на наших складах
                                                        </i>
                                                        </div></div>

                                                    <div class="col-md-4">
                                                      <div class="white_box">  <p class="froboto fsize16">Быстрая доставка по всей Украине</p>
                                                        <div class="row"><img src="<?php echo HTTP_SERVER;  ?>/image/catalog/static/carr.jpg" alt=""> </div>
                                                        <i clas="fsize11">Мы гарантируем оптимальные условия достаки в любой населенный пункт</i>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                     <div class="white_box">   <p class="froboto fsize16">Любая форма оплаты</p>
                                                      <div class="row">  <img src="<?php echo HTTP_SERVER;  ?>/image/catalog/static/mpo.jpg" alt=""> </div>
                                                        <i clas="fsize11">Наличный расчет, перевод на банковскую карту или счет</i>
                                                    </div>

                                                </div>
                                                        </div>
                                            </div>

</div>
                                            <div class="container">





                                                <?php echo $content_bottom; ?>
                                            </div>
                                            <?php echo $column_right; ?>
        </div>
    </div>
    
    
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyA_NQ-DRsT8exnEeAcDgMl4wdQHHIObmWE&sensor=false&extension=.js'></script> 
 
<script> 
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        var mapOptions = {
           center: new google.maps.LatLng(48.46489,35.044526),
            zoom: 15,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.DEFAULT,
            },
            disableDoubleClickZoom: false,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            },
            scaleControl: false,
            scrollwheel: false,
            panControl: false,
            streetViewControl: false,
            draggable : true,
            overviewMapControl: false,
            overviewMapControlOptions: {
                opened: false,
            },
            mapTypeId: google.maps.MapTypeId.TERRAIN,
        }
        var mapElement = document.getElementById('StroyTreyd');
        var map = new google.maps.Map(mapElement, mapOptions);
        var locations = [
['title', 'undefined', 'undefined', 'undefined', 'undefined', 48.464777469718534, 35.044536123664784, '<?php echo HTTP_SERVER;  ?>image/catalog/static/mmap.png']
        ];
        for (i = 0; i < locations.length; i++) {
			if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
			if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
			if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
           if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
           if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
            marker = new google.maps.Marker({
                icon: markericon,
                position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                map: map,
                title: locations[i][0],
                desc: description,
                tel: telephone,
                email: email,
                web: web
            });
link = '';     }

}
</script>
<style>
    #StroyTreyd {
        height:400px;
        width:100%;
            margin-bottom: -30px;
    }
    .gm-style-iw * {
        display: block;
        width: 100%;
    }
    .gm-style-iw h4, .gm-style-iw p {
        margin: 0;
        padding: 0;
    }
    .gm-style-iw a {
        color: #4272db;
    }
</style>

<div id='StroyTreyd'></div>
    
    
    
    <?php echo $footer; ?>