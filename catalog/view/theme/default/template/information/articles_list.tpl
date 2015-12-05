<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
   <div class="news_list_style">
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2>Применение фанеры</h2>
      <hr class="hrprdct" style="width:100%;margin-left:0%;margin-bottom:20px;margin-top:15px;">
      
      

		<?php foreach ($all_articles as $articles) { ?>
		<div class="row">
        <div class="col-xs-12">
		   <a href="<?php echo $articles['view']; ?>"> <h4><strong style="color:#00562f;"> <?php echo $articles['title']; ?></strong> </h4> </a>
		    </div>
		    
		</div>
	
		 <div class="row">
      
       <div class="col-xs-4">
		   <img style="width:100%;" src="<?php echo $articles['image']; ?>" />
       </div>
       <div class="col-xs-8">
		
		   <p><?php echo $articles['description']; ?></p>
		   <a class="buttonbl" href="<?php echo $articles['view']; ?>" style="float:right;"><?php echo $text_view; ?></a>
		   </div>
	
		   
		
		 </div>
		 	<div class="row">
		    <div class="col-xs-12">
		         <hr class="hrprdct" style="opacity:0.1; width:100%;margin-left:0%;margin-top:15px;margin-bottom:0px;">
		    </div>
		</div>
		<?php } ?>
		
	  
	  
	  <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
	  <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
  </div>
</div>
<?php echo $footer; ?> 