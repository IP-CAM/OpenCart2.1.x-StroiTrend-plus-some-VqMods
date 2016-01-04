<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-manufacturer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer" class="form-horizontal">

				<!-- * = * -->
				<ul class="nav nav-tabs"><li class="active"><a href="#tab-general" data-toggle="tab">General</a></li><li><a href="#tab-data" data-toggle="tab">Data</a></li></ul><div class="tab-content"><div class="tab-pane active" id="tab-general">
				<!-- * = * -->
				
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <div class="checkbox">
                  <label>
                    <?php if (in_array(0, $manufacturer_store)) { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($stores as $store) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($store['store_id'], $manufacturer_store)) { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
 If you have a few language, to view the all keywords for all language, you can go to "Edit SEO Items" in SEO module. 
              <?php if ($error_keyword) { ?>
              <div class="text-danger"><?php echo $error_keyword; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"> <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>

				<!-- * = * -->
				</div><div class="tab-pane" id="tab-data"><ul class="nav nav-tabs" id="language"><?php $i=0; foreach ($languages as $language) { ?><li <?php if($i==0){ ?> class="active" <?php } ?> ><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li> <?php $i++; } ?></ul><div class="tab-content"><?php $i=0; foreach ($languages as $language) { ?><div class="tab-pane <?php if($i==0){ ?> active <?php } ?>" id="language<?php echo $language['language_id']; ?>"   ><div class="form-group"><label class="col-sm-2 control-label" for="input-seo-title<?php echo $language['language_id']; ?>">Seo Title</label><div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][seo_title]" value="<?php echo isset($seodata[$language['language_id']]['seo_title']) ? $seodata[$language['language_id']]['seo_title'] : ''; ?>" id="input-seo-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Seo Title" /></div></div>
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-h1-title<?php echo $language['language_id']; ?>">Seo H1</label>
				<div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][seo_h1]" value="<?php echo isset($seodata[$language['language_id']]['seo_h1']) ? $seodata[$language['language_id']]['seo_h1'] : ''; ?>" id="input-h1-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Seo H1" /></div>
				</div>
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-h2-title<?php echo $language['language_id']; ?>">Seo H2</label>
				<div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][seo_h2]" value="<?php echo isset($seodata[$language['language_id']]['seo_h2']) ? $seodata[$language['language_id']]['seo_h2'] : ''; ?>" id="input-h2-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Seo H2" /></div>
				</div>
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-h3-title<?php echo $language['language_id']; ?>">Seo H3</label>
				<div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][seo_h3]" value="<?php echo isset($seodata[$language['language_id']]['seo_h3']) ? $seodata[$language['language_id']]['seo_h3'] : ''; ?>" id="input-h3-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Seo H1" /></div>
				</div>
				<div class="form-group"><label class="col-sm-2 control-label" for="input-keywords-title<?php echo $language['language_id']; ?>">Meta Keywords</label><div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][meta_keyword]" value="<?php echo isset($seodata[$language['language_id']]['meta_keyword']) ? $seodata[$language['language_id']]['meta_keyword'] : ''; ?>" id="input-keywords-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Meta Keywords" /></div></div><div class="form-group"><label class="col-sm-2 control-label" for="input-m_desc-title<?php echo $language['language_id']; ?>">Meta Description</label><div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][meta_description]" value="<?php echo isset($seodata[$language['language_id']]['meta_description']) ? $seodata[$language['language_id']]['meta_description'] : ''; ?>" id="input-m_desc-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Meta Description" /></div></div><div class="form-group"><label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>">Description</label><div class="col-sm-10"><textarea id="input-description<?php echo $language['language_id']; ?>" name="seodata[<?php echo $language['language_id']; ?>][description]" ><?php echo isset($seodata[$language['language_id']]['description']) ? $seodata[$language['language_id']]['description'] : ''; ?></textarea></div></div><div class="form-group"><label class="col-sm-2 control-label" for="input-tag-title<?php echo $language['language_id']; ?>">Tags</label><div class="col-sm-10"><input type="text" name="seodata[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($seodata[$language['language_id']]['tag']) ? $seodata[$language['language_id']]['tag'] : ''; ?>" id="input-tag-title<?php echo $language['language_id']; ?>" class="form-control" placeholder="Enter Tags" /></div></div></div><?php $i++; } ?></div></div></div>
				<!-- * = * -->
				
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>