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
      <h1>Применение фанеры</h1>
      <table class="table bordergr table-bordered table-striped table-hover">
		<tbody>
		<?php foreach ($all_articles as $articles) { ?>
		  <tr>
		   <td style="vertical-align:middle; padding:0px;" class="text-center" ><img style="width:100%;" src="<?php echo $articles['image']; ?>" /></td>
		   <!--<td style="vertical-align:middle"><?php echo $articles['title']; ?></td>-->
		   <td  class="news_text_size" style="vertical-align:middle"><?php echo $articles['description']; ?></td>
		   <td  class="news_text_size" style="vertical-align:middle"><?php echo $articles['date_added']; ?></td>
		   <td style="vertical-align:middle" class="text-right"><a class="button_news_short" href="<?php echo $articles['view']; ?>"><?php echo $text_view; ?></a></td>
		  </tr>
		<?php } ?>
		</tbody>
	  </table>
	  <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
	  <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
  </div>
</div>
<?php echo $footer; ?> 