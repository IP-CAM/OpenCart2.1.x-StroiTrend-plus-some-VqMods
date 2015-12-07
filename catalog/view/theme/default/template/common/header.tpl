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
                    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
                    
                    <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

                    <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
             
                    <link href="catalog/view/theme/default/stylesheet/style.css" rel="stylesheet">
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
                                <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
                                <?php } ?>
                                    <?php foreach ($scripts as $script) { ?>
                                        <script src="<?php echo $script; ?>" type="text/javascript"></script>
                                        <?php } ?>
                                            <?php foreach ($analytics as $analytic) { ?>
                                                <?php echo $analytic; ?>
                                                    <?php } ?>


                                                        <link href="catalog/view/theme/default/stylesheet/callback.css" rel="stylesheet" type="text/css" />
</head>

<body class="<?php echo $class; ?>">
    <header id="top" name="top">
        <div class="topH">
            <div class="container" style="padding-left: 30px;padding-right: 27px;">
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
                                <div class=" uppcase" style="padding:20px 0px;">
                                    <a class=" uppcase" style="color:black;" href="<?php echo $contact; ?>"><?php echo $telephone; ?></a>
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
                           <div class="row"> <button type="button" class="buttonbl navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
                     </div>   </div>
                        
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