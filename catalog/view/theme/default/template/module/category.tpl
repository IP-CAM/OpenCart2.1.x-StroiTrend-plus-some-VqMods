<div class="list-group">
    <?php foreach ($categories as $category) { ?>
        <?php if ($category['category_id'] == $category_id) { ?>
            <h3 class="box-heading">Категории товаров</h3>
            <a href="<?php echo $category['href']; ?>" class="list-group-item headerscat">
                <?php echo $category['name']; ?>
            </a>
            <?php if ($category['children']) { ?>
                <?php foreach ($category['children'] as $child) { ?>
                    <?php if ($child['category_id'] == $child_id) { ?>
                        <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp; <?php echo $child['name']; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp; <?php echo $child['name']; ?></a>
                            <?php } ?>
                                <?php } ?>
                                    <?php } ?>
                                        <?php } else { ?>

                                            <div class="row">

                                                <ul style="padding-left: 0px;">
                                                    <?php foreach ($category['children'] as $child) { ?>
                                                        <div class="col-md-3 list-unstyled " style="margin-bottom:10px;">
                                                            <div class="box">
                                                                <li>
                                                                    <p class="fplay fsize16 grey">
   <a href="<?php echo $child['href']; ?>" class="nonewhbg" style="border:none !important; " >    <?php echo $child['name']; ?></a> 
                                                                            <?php foreach ($banners as $banner) { 
 {?>
                                                                                <br /><i class="froboto fsize11 lightgrey">
 <?php echo $banner['name']; ?>
                                                                </i>  <?php break; ?><?php  }}?>
                                                                    </p>
                                                                    <div class="text-center mra">
                                                                        <div class="img-container">
       <a href="<?php echo $child['href']; ?>" style="border:none !important; ">  <img src="<?php echo $child['image']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>" class="img-responsive" /> </a> </div>
                                                                    </div>




                                                                    <?php foreach ($banners as $banner) { 
if($banner['category_child']==$child['category_id']) {?>

                                                                        <div class="row rowp10">

                                                                            <div class="col-xs-3 col-xs-offset-1">

<img src="<?php echo $banner['image']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>" class="img-responsive" />
                                                                            </div>
                                                                            <div class="col-xs-7 col-xs-offset-1" style="padding-left:0px;vertical-align:middle; margin:auto;">
                                                                                <div class="inl-block mra"> <span>
            <?php echo $banner['title']; ?>
            </span> </div>
                                                                            </div>


                                                                        </div>
                                                                        <?php  }}?>

                                                                            <div class="froboto text-center">
                                                                                <a href="<?php echo $child['href']; ?>" style="border: none !important;"> Подробнее </a>
                                                                            </div>
                                                                </li>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                </ul>

                                            </div>

                                            <?php } ?>
                                                <?php } ?>
</div>