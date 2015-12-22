<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
  <div class="news_style_information">
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1 class="name_news"><?php echo $heading_title; ?></h1>
	  <?php if ($image) { ?>
	  <div class="text-center">
	  <img class="pull-left" src="<?php echo $image; ?>" alt="<?php echo $heading_title; ?>" style ="width:100%;"/>
	  </div>
	  <?php } ?>
	 
	  <p><?php echo $description; ?></p>
	   <?php  if($button && $button_link) {?>
	 
	  <?php } ?>
	 
	  
	  <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?>
  </div>
  </div>
  <div class="row">
      <div class="col-xs-6" >
          <!-- AddThis Button BEGIN -->
           <div style="padding-top:10px;">
            <div class="addthis_toolbox addthis_default_style" >
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
             
              <a class="addthis_counter addthis_pill_style"></a>
              </div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
                       <script type="text/javascript" src="catalog/view/javascript/question.js"></script>
                                                        <script type="text/javascript" src="catalog/view/javascript/jquery.simplemodal.js"></script>
            <!-- AddThis Button END -->
            </div>
      </div>

 
      <?php if($button) { ?>
      <div class="col-xs-6"><a class="buttonbl" href="<?php echo $button_link; ?>" style="float:right;"><?php echo $button; ?></a></div>
      <?php } ?>
  </div>
</div>
<?php echo $footer; ?> 
