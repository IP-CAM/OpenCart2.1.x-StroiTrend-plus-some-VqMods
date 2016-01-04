<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>
<div class="container">
<ul class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
<li>
<a href="<?php echo $breadcrumb['href']; ?>">
<?php echo $breadcrumb['text']; ?>
</a>
</li>
<?php } ?>
</ul>
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
<?php echo $content_top; ?><div id="mfilter-content-container">

<!-- * = * -->
<h1><?php echo $heading_title; ?></h1>
<?php if(isset($seo_h2) && $seo_h2 && $seo_h2_position == 'after_h1'){ ?><h2><?php echo $seo_h2; ?></h2><?php } ?>
<?php if(isset($seo_h3) && $seo_h3 && $seo_h3_position == 'after_h1'){ ?><h3><?php echo $seo_h3; ?></h3><?php } ?>
<!-- * = * -->
				
<hr class="hrprdct" style="width:100%;margin-left:0%;margin-bottom:20px;margin-top:15px;">
<!--image category -->


<?php if ($categories) { ?>
<div class="row">
<div class="col-sm-12">
<h3> <strong ><?php echo $text_refine; ?></strong></h3>
</div>
</div>
<?php if (count($categories) <= 5) { ?>


		
    
<?php foreach ($categories as $category) { ?>
<div class="row">
<div class="col-xs-12">
<h4> <strong style="color:#00562f;" ><a href="<?php echo $category['href']; ?>"> <?php echo $category['name']; ?>  </a> </strong> </h4>

</div>
</div>
<div class="row">
<div class="col-xs-4">
<a href="<?php echo $category['href']; ?>">
<img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive" />
</a>
</div>
<div class="col-xs-8">
 <p><?php echo htmlspecialchars_decode($category['description']); ?></p>
 <a class="buttonbl" style="float:right;" href="<?php echo $category['href']; ?>"> 
 Перейти
 </a>
</div>
</div>
<hr style="width:100%;">
   

   
    <?php } ?>
  
				

		
		
		

<?php } else { ?>
    <div class="row">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
            <div class="col-sm-3">
                <ul>
                    <?php foreach ($categories as $category) { ?>
                        <li>
                            <a href="<?php echo $category['href']; ?>">
                                <?php echo $category['name']; ?>
                            </a>
                        </li>
                        <?php } ?>
                </ul>
            </div>
            <?php } ?>
    </div>
    <?php } ?>
        <?php } ?>
            <?php if ($products) { ?>
   <div class="row" style="margin-bottom:10px;">          
                  <div class="col-md-4 control-label" >
                     <div style="display:inline-block; margin-left:13px;">     
                           <p>
                    <a class="buttoncardinverse" href="<?php echo $compare; ?>" id="compare-total">
                        <?php echo $text_compare; ?>
                    </a>
                </p>
              </div>
                    </div>
                 
                 
                    <div class="col-md-2 text-right">
                        <label class="control-label" for="input-sort">
                            <?php echo $text_sort; ?>
                        </label>
                    </div>
                    <div class="col-md-3 text-right">
                        <select id="input-sort" class="form-control" onchange="location = this.value;">
                            <?php foreach ($sorts as $sorts) { ?>
                                <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                    <option value="<?php echo $sorts['href']; ?>" selected="selected">
                                        <?php echo $sorts['text']; ?>
                                    </option>
                                    <?php } else { ?>
                                        <option value="<?php echo $sorts['href']; ?>">
                                            <?php echo $sorts['text']; ?>
                                        </option>
                                        <?php } ?>
                                            <?php } ?>
                        </select>
                    </div>
                    
                    
                    <div class="col-md-1 text-right">
                        <label class="control-label" for="input-limit">
                            <?php echo $text_limit; ?>
                        </label>
                    </div>
                    <div class="col-md-2 text-right" >
                        <select id="input-limit" class="form-control" onchange="location = this.value;">
                            <?php foreach ($limits as $limits) { ?>
                                <?php if ($limits['value'] == $limit) { ?>
                                    <option value="<?php echo $limits['href']; ?>" selected="selected">
                                        <?php echo $limits['text']; ?>
                                    </option>
                                    <?php } else { ?>
                                        <option value="<?php echo $limits['href']; ?>">
                                            <?php echo $limits['text']; ?>
                                        </option>
                                        <?php } ?>
                                            <?php } ?>
                        </select>
                    </div>
    </div>
                 <div class="clearfix"></div>
                  <!-- єто продукты с правой части  -->
                   <div class="row">
                    <?php foreach ($products as $product) { ?>
                        <div class="product-layout product-list col-sm-12">
                            <div class="product-thumb">
<div class="row">
    <div class="col-xs-4">
         <!-- img -->
                               <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['alt_image'] ? $product['alt_image'] : $product['name']; ?>"
				 title="<?php echo $product['title_image'] ? $product['title_image'] : $product['name']; ?>"
				 class="img-responsive" /></a></div>
                               <!-- img -->
    </div>
    <div class="col-xs-8">
        <div >
                                        <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                                        <p>
                                           <!--atr-->
                                            <div class="row">
                                               <div class="col-xs-11">
                                                   <h5 class="froboto" style="color:#00562f" >
                                                       Характеристики:
                                                   </h5>
                                                   <hr class="hrcate">
                                               </div>
                                           </div>
                                         <?php 
                                            $jq=0;
                                           foreach($product['attribute_groups'][0]['attribute'] as $attribute) {
                                           $jq++; ?>
                                          
                                           <div class="row">
                                              <div class="col-xs-8">
                                                 <span>
                                                      <?php echo $attribute['name']; ?>
                                                 </span> 
                                              </div>
                                               <div class="col-xs-4">
                                                   <span>
                                                        <?php echo $attribute['text']; ?>
                                                   </span>
                                               </div>
                                               
                                           </div>
                                          
                                          
                                           
                                           <?php if($jq==3)break; } ?>
                             
                                           <!--atr-->
                                        </p>
   <div class="row">
       <div class="col-xs-6">
           <!--cost-->
<?php if ($product['rating']) { ?>
<div class="rating">
<span>Рейтинг товара:</span>
<?php for ($i = 1; $i <= 5; $i++) { ?>
<?php if ($product['rating'] < $i) { ?>
<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
<?php } else { ?>
<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<!--cost-->
       </div>
       <div class="col-xs-6">
           <!--runked-->  
<?php if ($product['price']) { ?>
<p class="price">
<?php if (!$product['special']) { ?>
<span> Цена за лист:</span>  <strong><?php echo $product['price']; ?></strong>
<?php } else { ?>
<span> Цена за лист:</span>    <span class="price-new"><strong><?php echo $product['special']; ?></strong></span> <span class="price-old"><?php echo $product['price']; ?></span>
<?php } ?>
<?php if ($product['tax']) { ?>
<span class="price-tax"><?php echo $text_tax; ?> <strong><?php echo $product['tax']; ?></strong></span>
<?php } ?>
</p>
<?php } ?>
   <!--runked--> 
       </div>
   </div>                                     

                                             
                                              

                                                    
                                                  
                                                    
                                                    
                                                    
                                    </div>
    </div>
</div>
                            
                                    
                                    <div class="button-group col-md-5 col-md-offset-6">
              <button type="button" class="buttoncardinverse"  data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                                        
    <button type="button" class="buttoncard" onClick="location.href='<?php echo $product['href']; ?>'">Перейти к товару</button>
   
   
                                    </div>
                               
                               
                                
    <div style="    margin-top: 20px;" >
                                    
                                    
                               
                                                    <!-- child-->
                                                    
                                          
                                                        
                                             <?php $zzz=1; foreach ($products_child as $ch) { 
                                             
                                             if($ch['product_id']!=$product['product_id'])
                                             {
                                             
                                              if($ch['sku']==$product['sku']) {
                                             ?>
                                             
                                              <?php 
                                              if($zzz==1)
                                              {
                                              $zzz=0;
                                              ?>        
                                            
                                   <div class="row" > 
                                           <div class="col-xs-11 col-xs-offset-1">
                                            <h4 class="froboto" style="color:#00562f"> Модификации:</h4>
                                            </div>
                                            <hr class="hrprdct">
                                            </div>         
                                          
                                             <?php } ?>
                                              
                                              
                                <div class="row" style="   padding-top:3px;padding-bottom:3px;">
                                    
                                    
                               
                                <div class="col-xs-6 col-xs-offset-1">         <a href="<?php echo $ch['href']; ?>"> <?php echo $ch['name']; ?></a> </div>  
                                <div class="col-xs-2">          <span class="price">
                                                        <?php if (!$ch['special']) { ?>
                                                            <?php echo $ch['price']; ?>
                                                                <?php } else { ?>
                                                                    <span class="price-new"><?php echo $ch['special']; ?></span> <span class="price-old"><?php echo $ch['price']; ?></span>
                                                                    <?php } ?>
                                                                        <?php if ($ch['tax']) { ?>
                                                                            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $ch['tax']; ?></span>
                                                                            <?php } ?>
                                                    </span>
                                                    </div>     
                                               
            <div class="col-xs-2" style="    display: inline-table;">                                 
                                               
   <a class="buttoncard hand " style="    padding-top: 2px !important;
    padding-bottom: 2px !important; 
   " href="<?php echo $ch['href']; ?>">Перейти
          </a> 
           
            </div>  
                                            
                                              </div>
                                              <?php  } } }?>       
                          
                                 </div>
                            </div>
                            
                              
                            
                            
                            
                        </div>
                        <?php } ?>
                </div>
                    <!-- єто продукты с правой части  -->
                   
                   
                   
                   
                 
                    
                    
                    
                    
                </div>
                <br />
                
                
                
                
                
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <?php echo $pagination; ?>
                    </div>
                    <div class="col-sm-6 text-right">
                        <?php echo $results; ?>
                    </div>
                </div>
                <?php } ?>

				<!-- * = * -->
                <?php if (isset($tags) AND $tags) { ?><div class="tags gen-area gen-tags"><b><?php echo $text_tags . ' '; ?></b><?php for ($i = 0; $i < count($tags); $i++) { ?><?php if ($i < (count($tags) - 1)) { ?><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,<?php } else { ?><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a><?php } ?><?php } ?></div><?php } ?>
				<!-- * = * -->
				
                    <?php if (!$categories && !$products) { ?>
                        <p>
                            <?php echo $text_empty; ?>
                        </p>
                        <div class="buttons">
                            <div class="pull-right">
                                <a href="<?php echo $continue; ?>" class="btn btn-primary">
                                    <?php echo $button_continue; ?>
                                </a>
                            </div>
					
                        </div>
                        <?php } ?>
												   <?php if ($thumb || $description) { ?>
<div class="row">
</br>

				<!-- * = * -->
				<?php if(isset($seo_h2) && $seo_h2 && $seo_h2_position == 'before_description'){ ?>
				<h2><?php echo $seo_h2; ?></h2><?php } ?>
				<?php if(isset($seo_h3) && $seo_h3 && $seo_h3_position == 'before_description'){ ?>
				<h3><?php echo $seo_h3; ?></h3><?php } ?>
				<!-- * = * -->
				
<?php if ($description) { ?>
    <div class="col-sm-12">
        <?php 
				
		//	$description=	(strlen(strip_tags(html_entity_decode($description, ENT_QUOTES))) > 200 ? substr(strip_tags(html_entity_decode($description, ENT_QUOTES)), 0, 200) . '...' : strip_tags(html_entity_decode($description, ENT_QUOTES)));
				
				
				echo $description; ?>
    </div>
    <?php } ?>
 </div>
<hr>
<?php } ?>
												
												
												
                            </div><?php echo $content_bottom; ?>
														
</div>
<?php echo $column_right; ?>



</div>
</div>


<!--  img category -->
<!--  ШАШЛЫК) -->

<?php echo $footer; ?>