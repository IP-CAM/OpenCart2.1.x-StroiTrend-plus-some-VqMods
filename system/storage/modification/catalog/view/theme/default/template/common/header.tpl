<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php echo $title; ?>
    </title>
    <base href="<?php echo $base; ?>" />
    <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>
            <?php if ($keywords) { ?>
                <meta name="keywords" content="<?php echo $keywords; ?>" />
                <?php } ?>
                   
                   
                    <!-- jquery -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
                    <!-- bootstrap js -->
                    <!-- Latest compiled and minified JavaScript -->
  <!-- bootstrap js -->
				
				<script src="catalog/view/javascript/mf/jquery-ui.min.js" type="text/javascript"></script>
			
                    <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
                     <!-- bootstrap-->
                    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen" />


                   
                   
                    <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
                    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />

                 <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
                    <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
                    
                    <link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">

                    <?php foreach ($styles as $style) { ?>
                        <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
                        <?php } ?>
                            <script src="catalog/view/javascript/common.js" type="text/javascript"></script>
                            <?php foreach ($links as $link) { ?>
                                
<!-- * = * -->
<?php $linkTags = '';	foreach($link as $key => $val){$linkTags .= $key . '="' . $val . '" ';}
?><link <?php echo $linkTags; ?>/>
<!-- * = * -->
				
                                <?php } ?>
                                    <?php foreach ($scripts as $script) { ?>
                                        <script src="<?php echo $script; ?>" type="text/javascript"></script>
                                        <?php } ?>
                                            <?php foreach ($analytics as $analytic) { ?>
                                                <?php echo $analytic; ?>
                                                    <?php } ?>


                                                        <link href="catalog/view/theme/default/stylesheet/callback.css" rel="stylesheet" type="text/css" />

					<!-- * = * -->
					<?php require_once DIR_CONFIG .'ssb_library/ssb_data.php';
					$this->ssb_data = ssb_data::getInstance();
					$tools = $this->ssb_data->getSetting('tools');
					if($tools AND isset($_SESSION["ssb_page_type"])){
					if($tools['qr_code']['status'] OR $tools['soc_buttons']['status']){
					include_once DIR_CONFIG .'ssb_library/catalog/tools/panel_bar_head.tpl';
					}

					if($tools['webm_tool']['data']['google']){
					$google_meta = $tools['webm_tool']['data']['google'];
					if ( strpos( $google_meta, 'content' ) !== false ) {
					preg_match( '/content="([^"]+)"/', htmlspecialchars_decode($google_meta), $match );
					if(isset($match[1])){
					$google_meta = $match[1];
					}
					}
					echo "\n<meta name=\"google-site-verification\" content=\"$google_meta\" />\n";
					}

					if($tools['webm_tool']['data']['bing']){
					$bing_meta = $tools['webm_tool']['data']['bing'];
					if ( strpos( $bing_meta, 'content' ) !== false) {
					preg_match( '/content="([^"]+)"/', htmlspecialchars_decode($bing_meta), $match );
					if(isset($match[1])){
					$bing_meta = $match[1];
					}
					}
					echo "<meta name=\"msvalidate.01\" content=\"$bing_meta\" />\n";
					}

					if($tools['webm_tool']['data']['alexa']){
					$alexaverify = $tools['webm_tool']['data']['alexa'];
					echo "<meta name=\"alexaVerifyID\" content=\"" . htmlspecialchars( $alexaverify, ENT_NOQUOTES, 'UTF-8' ) . "\" />\n";
					}
					}
					?>
					<!-- * = * -->
				
</head>

<body class="<?php echo $class; ?>">
   <div id="wrap">
    <header id="top" name="top">
        <div class="topH">
            <div class="container" style="padding-right: 27px;">
                <div class="row">
                  <!-- LOGO -->
                  <div class="logo-block">
                   <?php if ($logo) { ?>
                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"/></a>
                        <?php } else { ?>
                        <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                    <?php } ?>
                    </div>
                    <!-- CONTACTS -->
                    <div class="contacts-block">
                        <ul class="list-unstyled ulp">
                            <li>
                                <div>
                                    <a href class="contact-btn buttonbl">Заказать звонок</a>
                                </div>
                            </li>
                            <li>
                                <div class=" uppcase" style="padding-top: 5px;">
                                    <a class=" uppcase" style="color:black;;     max-height: 14px;" href="<?php echo $contact; ?>"><?php echo $telephone; ?></a>
                                    <a class=" uppcase" style="color:black;     max-height: 14px;" href="<?php echo $contact; ?>"><?php echo $fax; ?></a>
                                    <a class=" uppcase" style="color:black;     max-height: 14px;" href="<?php echo $contact; ?>"><?php echo $comment; ?></a>
                                </div>
                            </li>
                            <?php if ($logged) { ?>
                            <li>
                                <div>
                                    <a class="buttonbl" href="<?php echo $account; ?>">
                                        <?php echo $text_account; ?>
                                    </a>
                                </div>
                            </li>
                            <?php } else { ?>
                            <li>
                                <div>
                                    <a class="buttonbl" href="<?php echo $login; ?>">
                                        <?php echo $text_login; ?>
                                    </a>
                                </div>
                                <?php } ?>
                            </li>
                            <li>
                                <div style="position: relative;">
                                    <?php echo $cart; ?>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- MENU -->
                    <nav id="menu" class="navbar">
                        <div class="navbar navbar-header froboto">
                            <button type="button" style="    margin-right: 0px;" class="buttonbl navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
                     </div>  
                        
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <div class="froboto uppcase">
                                        <div>
                                            <a href="">Главная</a>
                                        </div>
                                    </div>
                                </li>
                                <?php foreach ($categories as $category) { ?>
                                <?php if ($category['children']) { ?>
                                <li>
                                <div class="froboto uppcase">
                                    <a data-toggle="collapse" data-target="#categ" class="hand">
                                        <?php echo $category['name']; ?>
                                    </a>
                                </div>
                                </li>
                                <li>
                                    <div class="froboto uppcase">
                                        <div>
                                            <a href="index.php?route=information/articles">Статьи</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="froboto uppcase">
                                        <div>
                                            <a href="<?php echo $AboutUs; ?>">О Компании</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="froboto uppcase">
                                        <div>
                                            <a href="<?php echo $contact; ?>">Контакты</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="topH green-bg">
            <div class="container">
                <div id="categ" class="collapse">

                    <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                        <ul class="nav navbar-nav" style="min-height:80px;">
                            <?php foreach ($children as $child) { ?>
                                <li>
                                    <a href="<?php echo $child['href']; ?>">
                                        <?php echo $child['name']; ?>
                                    </a>
                                </li>
                                <?php } ?>
                        </ul>
                        <?php } ?>
                            </li>
                            <?php } else { ?>
                                <li>
                                    <a class="froboto uppcase" href="<?php echo $category['href']; ?>">
                                        <?php echo $category['name']; ?>
                                    </a>
                                </li>
                                <?php } ?>
                                    <?php } ?>
                                    </div>
                </div>
 
        </div>
    </header>
    <?php if ($categories) { ?>
        <?php } ?>
        