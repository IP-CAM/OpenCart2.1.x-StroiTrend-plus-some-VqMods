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

    <ul>
        <?php foreach ($category['children'] as $child) { ?>
<div class="col-md-3 list-unstyled">
    <li>
        <p><?php echo $child['name']; ?></p>
            <div class="text-center inl-block mra">
                <img src="<?php echo $child['image']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>" class="img-responsive" />
            </div>
            <div class="froboto text-center">
                <a href="<?php echo $child['href']; ?>"> Подробнее </a>
            </div>
    </li>
</div>
            <?php } ?>
    </ul>

</div>

<?php } ?>
                                                <?php } ?>
</div>