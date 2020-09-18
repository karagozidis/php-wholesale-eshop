<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
 <div class="page-header">
    <div class="container-fluid">
    
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
    <div class="box ">
      <div class="rev_content content" style="min-width: 1095px;">
          <!-- content here --> 
          <?php echo $rev_content; ?>
      </div>
  </div>
</div>
</div>
<style type="text/css">
.rev_content .content.wrap {
  margin: 0px 0px 0 0px;
}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$(this.body).addClass('rev_backoffice wp-core-ui');
	});
</script>
<?php echo $footer; ?>