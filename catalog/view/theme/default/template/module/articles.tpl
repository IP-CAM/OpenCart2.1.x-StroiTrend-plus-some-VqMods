<div class="ArticleHead col-md-12">
    <?php echo $heading_title; ?>
</div>
<div class="row mr">
    <?php foreach ($all_articles as $articles) { ?>

        <div class="col-md-3 col-md-offset-1">
            <div class="row mr">

                <?php if ($articles['image']) { ?>
                    <div class="text-center">
                        <img class="pull-left" src="<?php echo $articles['image']; ?>" alt="<?php echo $heading_title; ?>" />
                    </div>
                    <?php } ?>
            </div>
            <div class="row mr">
                <a href="<?php echo $articles['view']; ?>">
                    <?php echo $articles['title']; ?>
                </a>
                </div>

                <?php echo $articles['description']; ?>
            <div class="row mr">
                    <a class="buttinv" href="<?php echo $articles['view']; ?>">
                            Подробней
                    </a>
            </div>
        </div>

        <?php } ?>
</div>