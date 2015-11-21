<?php echo $header; ?>
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
<?php echo $content_top; ?>
<h2><?php echo $heading_title; ?></h2>
<!--image category -->
<?php if ($categories) { ?>
<h3><?php echo $text_refine; ?></h3>
<?php if (count($categories) <= 5) { ?>
<div class="row">
    <div class="col-sm-3">
        <ul>
<?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>">
        <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive" />
<?php echo $category['name']; ?></a>
   </li>
    <?php } ?>
        </ul>
    </div>
</div>
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
                     <div style="display:inline-block">     
                           <p>
                    <a href="<?php echo $compare; ?>" id="compare-total">
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
                                <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                                <div>
                                    <div class="caption">
                                        <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                                        <p>
                                            <?php echo $product['description']; ?>
                                        </p>
                                        <?php if ($product['rating']) { ?>
                                            <div class="rating">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <?php if ($product['rating'] < $i) { ?>
                                                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                        <?php } else { ?>
                                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                            <?php } ?>
                                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                                <?php if ($product['price']) { ?>
                                                    <p class="price">
                                                        <?php if (!$product['special']) { ?>
                                                            <?php echo $product['price']; ?>
                                                                <?php } else { ?>
                                                                    <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                                                    <?php } ?>
                                                                        <?php if ($product['tax']) { ?>
                                                                            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                                                            <?php } ?>
                                                    </p>
                                                    <?php } ?>
                                                    
                                                  
                                                    
                                                    
                                                    
                                    </div>
                                    <div class="button-group">
                                       
    <button type="button" class="buttoncard" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
   
    <button type="button" class="buttoncardinverse"  data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                                    </div>
                                </div>
                               
                                
    <div style="    margin-top: 60px;" >
                                    
                                    
                               
                                                    <!-- child-->
                                                    
                                             <?php foreach ($products_child as $ch) { 
                                             
                                             if($ch['product_id']!=$product['product_id'])
                                             {
                                             
                                              if($ch['sku']==$product['sku']) {
                                             ?>
                                             
                                              
                                <div class="row" style="   padding-top:3px;padding-bottom:3px;">
                                    
                                    
                               
                                <div class="col-md-6 col-md-offset-1">         <a href="<?php echo $ch['href']; ?>"> <?php echo $ch['name']; ?></a> </div>  
                                <div class="col-md-2">          <span class="price">
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
                                               
            <div class="col-md-2">                                 
                                               
   <a onclick="cart.add('<?php echo $ch['product_id']; ?>', '<?php echo $ch['minimum']; ?>');" class="buttoncard hand " style="    padding-top: 2px !important;
    padding-bottom: 2px !important;
   ">Купить</a>  </div>  
                                            
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
                            <?php echo $content_bottom; ?>
</div>
<?php echo $column_right; ?>
</div>
</div>


<!--  img category -->
<div class="container">
<div class="row">
  
    <?php if ($thumb || $description) { ?>
<div class="row">

<?php if ($description) { ?>
    <div class="col-sm-9 col-sm-offset-3">
        <?php echo $description; ?>
    </div>
    <?php } ?>
</div>
<hr>
<?php } ?>
    
</div>
</div>
<?php echo $footer; ?>