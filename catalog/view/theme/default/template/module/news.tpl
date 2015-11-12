</div>
</div>
</div>
<div class="News row">
    <div class="container">
        <div class="Head" style="text-align:left;">
            <?php echo $heading_title; ?>
        </div>


        <div class=" mr">
            <div class="owl-car">

                <?php $i=0;foreach (array_reverse($all_news) as $news) { $i++;
 
        ?>




                    <?php if ($news['image']) { ?>
                        <div class="item">
                            <div class="text-center static">
                                <div class="Abs">
                                    <a href="<?php echo $news['view']; ?>">
                                    <img class="mra" src="<?php echo $news['image']; ?>" alt="<?php echo $heading_title; ?>" />
                                   </a>
                                </div>
                                <div class="slider">
                                    <a href="<?php echo $news['view']; ?>">asdasd</a>
                                    <a href="<?php echo $news['view']; ?>">asdasd</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                            <?php // echo $news['title']; ?>
                                <?php // echo $news['description']; ?>


                                    <?php } ?>


            </div>

        </div>
    </div>
</div>