<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); 
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?php if ($orders) { ?>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#datepickerFrom" ).datepicker({ dateFormat: 'dd/mm/yy' });
	$( "#datepickerTo" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );
  </script>

<h3 style="text-align:center;margin-bottom: 36px;margin-top: -36px;"><span style="border: 2px solid #13A697;padding: 20px;background-color: white;"><?php echo $name; ?></span></h3>

<input type="text" id="datepickerFrom">
<input type="text" id="datepickerTo">
<input type="button" value="ViewDates" id="ViewDates" rel="113" class="button" style="padding: 5px 16px 5px 16px;">

<script>
$( "#ViewDates" ).click(function() {
	
	if( ($( "#datepickerFrom" ).val() == '') && $( "#datepickerTo" ).val() == '' )
	{
		$( ".rowDate" ).each(function( index ) {
			 $( this ).parent().show();
		});
		return;
	}

	var frmStr = $( "#datepickerFrom" ).val() ;
	if(frmStr == '') frmStr = '01/01/1550';
	var toStr = $( "#datepickerTo" ).val() ;
	if(toStr == '') toStr = '01/01/2090';
	
	var FromDate = toDate(frmStr);
	var ToDate = toDate(toStr);
	
	$( ".rowDate" ).each(function( index ) {
		var curDate =  toDate($( this ).val());
		if(curDate >= FromDate && curDate <= ToDate) $( this ).parent().show();
		else  $( this ).parent().hide();
	});
	
 // alert( FromDate );
});
	
	
function toDate(dateStr) {
  const [day, month, year] = dateStr.split("/")
  return new Date(year, month - 1, day)
}
	
	
  </script>



<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-left"><?php echo $column_trndate; ?></td>
        <td class="text-left"><?php echo $column_findoc; ?></td>
        <td class="text-left"><?php echo $column_fincode; ?></td>
        <td class="text-left"><?php echo $column_series; ?></td>
        <td class="text-left"><?php echo $column_deb; ?></td>
        <td class="text-left"><?php echo $column_cre; ?></td>
		<td class="text-left"><?php echo $column_Balance; ?></td>
      </tr>
    </thead>
    <tbody>
	  <?php $balance = 0; ?>
      <?php foreach ($orders as $order) { ?>
		<?php $balance = $balance + $order['DEB'] - $order['CRE'] ?>
	  <?php } ?>
		<?php foreach ($orders as $order) { ?>
		
      <tr>
		<td class="text-left"><?php echo date_format(new DateTime($order['TRNDATE']), 'd/m/Y'); ?></td> 
        <td class="text-left"><?php echo $order['FINDOC']; ?></td>
        <td class="text-left"><?php echo $order['FINCODE']; ?></td>
        <td class="text-left"><?php echo $order['X_SNAME']; ?></td>
        <td class="text-left"><?php echo $order['DEB']; ?></td>
        <td class="text-left"><?php echo $order['CRE']; ?></td>
		<td class="text-left"><?php echo round($balance,2) ?></td>
		<input type="hidden" class="rowDate" value="<?php echo date_format(new DateTime($order['TRNDATE']), 'd/m/Y'); ?>">

      </tr>
		<?php $balance = $balance - $order['DEB'] + $order['CRE'] ?>
      <?php } ?>
    </tbody>
  </table>
</div>
<div class="row">
  <!--<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>-->
 <!-- <div class="col-sm-6 text-right"><?php echo $results; ?></div> -->
</div>
<?php } else { ?>
<p><?php echo $text_empty2; ?></p>
<?php } ?>
<!-- <div class="buttons clearfix">
  <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
</div> -->
  
<?php include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>