<div class="list-group">
    <?php foreach ($categories as $category) { ?>
        <?php if ($category['category_id'] == $category_id) { ?>
            <a href="<?php echo $category['href']; ?>" class="list-group-item active">
                <?php echo $category['name']; ?>
            </a>
            <?php if ($category['children']) { ?>
                <?php foreach ($category['children'] as $child) { ?>
                    <?php if ($child['category_id'] == $child_id) { ?>
                        <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
                            <?php } ?>
                                <?php } ?>
                                    <?php } ?>
                                        <?php } else { ?>
                                           
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <ul>
                                                        <?php foreach ($category['children'] as $child) { ?>
      <li><a href="<?php echo $child['href']; ?>">
        <img src="<?php echo $child['image']; ?>" 
        alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>" 
        class="img-responsive" />
        <?php echo $child['name']; ?></a>
      </li>
                                                            <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <?php } ?>
                       <?php } ?>
</div>
<pre>
    <?php var_dump($g); ?>
</pre>