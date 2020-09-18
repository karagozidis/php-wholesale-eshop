<div class="box box-no-advanced">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="strip-line"></div>
  <div class="box-content">
    <ul class="box-filter">
		
      <?php foreach ($filter_groups as $filter_group) { ?>
      <li><i class="fa fa-angle-down fa-lg" style="padding-right:6px;"></i><span id="filter-group<?php echo $filter_group['filter_group_id']; ?>" data-toggle="collapse" data-target="#collapse1<?php echo $filter_group['filter_group_id']; ?>" role="button" style="cursor: pointer;"><?php echo $filter_group['name'];?></span>
		  
		    <?php $foundInFilters = false; ?>
		    <?php foreach ($filter_group['filter'] as $filter) { ?>
               <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
		       <?php $foundInFilters = true; ?>
		       <?php } ?>
		    <?php } ?>
		  
        <ul class="collapse <?php if ($foundInFilters) { ?> in <?php } ?>" id="collapse1<?php echo $filter_group['filter_group_id']; ?>">
          <?php foreach ($filter_group['filter'] as $filter) { ?>
          <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
          <li>
            <input type="checkbox" value="<?php echo $filter['filter_id']; ?>" id="filter<?php echo $filter['filter_id']; ?>" checked="checked" />
            
			 <?php if ($filter_group['filter_group_id'] == 4 && $filter['colorhex'] != '' ) { ?>  
				<label for="filter<?php echo $filter['filter_id']; ?>" style='background: <?php echo $filter['colorhex']; ?>;width: 20px;height: 14px;border: 1px solid #a7a7a7;'></label>
			 <?php } else { ?>  
			    <label for="filter<?php echo $filter['filter_id']; ?>"><?php echo $filter['name']; ?></label>
			<?php } ?>  
			
          </li>
          <?php } else { ?>
          <li>
            <input type="checkbox" value="<?php echo $filter['filter_id']; ?>" id="filter<?php echo $filter['filter_id']; ?>" />
			
			<?php if ($filter_group['filter_group_id'] == 4 && $filter['colorhex'] != '' ) { ?>  
				<label for="filter<?php echo $filter['filter_id']; ?>" style='background: <?php echo $filter['colorhex']; ?>;width: 20px;height: 14px;border: 1px solid #a7a7a7;'></label>
			<?php } else { ?>  
			    <label for="filter<?php echo $filter['filter_id']; ?>"><?php echo $filter['name']; ?></label>
			<?php } ?>  
			
          </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
    <a id="button-filter" class="button"><?php echo $button_filter; ?></a>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').bind('click', function() {
	filter = [];
	
	$('.box-filter input[type=\'checkbox\']:checked').each(function(element) {
		filter.push(this.value);
	});
	
	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
//--></script> 
