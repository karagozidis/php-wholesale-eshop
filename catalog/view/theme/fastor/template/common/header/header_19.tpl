<?php if($theme_options->get( 'fixed_header' ) == 1) { ?>
<!-- HEADER
	================================================== -->
<div class="fixed-header-1 sticky-header header-type-3 header-type-13 header-type-19">
	<?php $slideshow = $modules_old_opencart->getModules('slideshow'); ?>
	<?php  if(count($slideshow)) { ?>
	<!-- Slider -->
	<div id="slider" class="<?php if($theme_options->get( 'slideshow_layout' ) == 1) { echo 'full-width'; } elseif($theme_options->get( 'slideshow_layout' ) == 4) { echo 'fixed3 fixed2'; } elseif($theme_options->get( 'slideshow_layout' ) == 3) { echo 'fixed2'; } else { echo 'fixed'; } ?>">
		<div class="background-slider"></div>
		<div class="background">
			<div class="shadow"></div>
			<div class="pattern">
			     <div class="container">
	                     <div class="row slideshow-modules">
	                          <div class="col-md-3">
	           				<?php foreach($slideshow as $module) { ?>
	           				<?php echo $module; ?>
	           				<?php } ?>
	           			</div>
	           		     
	           		     <div class="col-md-9">
	           		          <div class="shop-by-car">
	           		               <select class="shop-by-car-select" onChange="window.location.href=this.value">
	           		                    <option><?php if($theme_options->get( 'shop_by_car_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'shop_by_car_text', $config->get( 'config_language_id' ) )); } else { echo 'Shop by car'; } ?></option>
	           		               </select>
	           		               
	           		               <script type="text/javascript">
	           		                    $(document).ready(function() {
	           		                         $("#cars-links ul li a").each(function() {
	           		                              $('select.shop-by-car-select').append('<option value="' + $(this).attr('href') + '">' + $(this).html() + '</option>');
	           		                         });
	           		                    });
	           		               </script>
	           		          </div>
	           		          
	           		          <div class="shop-by-brands">
	           		               <select class="shop-by-brand-select" onChange="window.location.href=this.value">
	           		                    <option><?php if($theme_options->get( 'shop_by_brand_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'shop_by_brand_text', $config->get( 'config_language_id' ) )); } else { echo 'Shop by brand'; } ?></option>
	           		               </select>
	           		               
	           		               <script type="text/javascript">
	           		                    $(document).ready(function() {
	           		                         $("#brands-links ul li a").each(function() {
	           		                              $('select.shop-by-brand-select').append('<option value="' + $(this).attr('href') + '">' + $(this).html() + '</option>');
	           		                         });
	           		                    });
	           		               </script>
	           		          </div>
	           		          
	           		          <div class="search_form_overflow">
	                		          <div class="search_form">					         
	                		              <div class="overflow-input"><input type="text" class="input-block-level search-query" name="search" placeholder="<?php echo $search; ?>" id="search_query" value="" /></div>
	                		              
	                		              <div class="button-search"></div>
	                		              <?php if($theme_options->get( 'quick_search_autosuggest' ) != '0') { ?>
	                		              	<div id="autocomplete-results" class="autocomplete-results"></div>
	                		              	
	                		              	<script type="text/javascript">
	                		              	$(document).ready(function() {
	                		              		$('#search_query').autocomplete({
	                		              			delay: 0,
	                		              			appendTo: "#autocomplete-results",
	                		              			source: function(request, response) {		
	                		              				$.ajax({
	                		              					url: 'index.php?route=search/autocomplete&filter_name=' +  encodeURIComponent(request.term),
	                		              					dataType: 'json',
	                		              					success: function(json) {
	                		              						response($.map(json, function(item) {
	                		              							return {
	                		              								label: item.name,
	                		              								value: item.product_id,
	                		              								href: item.href,
	                		              								thumb: item.thumb,
	                		              								desc: item.desc,
	                		              								price: item.price
	                		              							}
	                		              						}));
	                		              					}
	                		              				});
	                		              			},
	                		              			select: function(event, ui) {
	                		              				document.location.href = ui.item.href;
	                		              				
	                		              				return false;
	                		              			},
	                		              			focus: function(event, ui) {
	                		              		      	return false;
	                		              		   	},
	                		              		   	minLength: 2
	                		              		})
	                		              		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
	                		              		  return $( "<li>" )
	                		              		    .append( "<a>" + item.label + "</a>" )
	                		              		    .appendTo( ul );
	                		              		};
	                		              	});
	                		              	</script>
	                		              <?php } ?>
	                		          </div>
	           		          </div>
	           		     </div>
	           		</div>
	      		</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>

<!-- HEADER
	================================================== -->
<header class="header-type-3 header-type-13 header-type-19">
	<div class="background-header"></div>
	<div class="slider-header">
		<!-- Top of pages -->
		<div id="top" class="<?php if($theme_options->get( 'header_layout' ) == 1) { echo 'full-width'; } elseif($theme_options->get( 'header_layout' ) == 4) { echo 'fixed3 fixed2'; } elseif($theme_options->get( 'header_layout' ) == 3) { echo 'fixed2';  } else { echo 'fixed'; } ?>">
			<div class="background-top"></div>
			<div class="background">
				<div class="shadow"></div>
				<div class="pattern">
				     <div class="top-bar">
				          <div class="container">
				               <!-- Links -->
				               <ul class="menu">
				               	<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
				               	<li><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a></li>
				               	<li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
				               	<li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
				               	<?php if ($logged) { ?>
				               	<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
				               	<?php } ?>
				               </ul>
				               
				               <?php echo $currency.$language; ?>
				          </div>
				     </div>
				     
					<div class="container">
						<div class="row">		
						     <?php if ($logo) { ?>
						     <!-- Header Left -->
						     <div class="col-sm-3" id="header-left">
						          <!-- Logo -->
						          <div class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
						     </div>
						     <?php } ?>
						     
							<!-- Header Left -->
							<div class="col-sm-5" id="header-center">
                                        <?php 
                                        $menu9 = $modules_old_opencart->getModules('menu');
                                        if( count($menu9) ) { ?>
                                             <div class="megamenu-background">
                                                  <div class="">
                                                       <div class="overflow-megamenu container">
                                        				<?php 
                                        				if(count($menu9) > 1) echo '<div class="row mega-menu-modules">';
                                        				$i = 0;
                                        				    
                                        				foreach ($menu9 as $module) {
                                        				     if($i == 0 && count($menu9) > 1) echo '<div class="col-md-3">';
                                        				     if($i == 1 && count($menu9) > 1) echo '<div class="col-md-9">';
                                        					     echo $module;
                                        					if(count($menu9) > 1 && ($i == 0 || $i == 1)) echo '</div>';
                                        					if(count($menu9) > 1 && $i == 1) echo '</div>';
                                        					$i++;
                                        				} ?>
                                        			</div>
                                        		</div>
                                        	</div>
                                        <?php
                                        } else {
                                        	echo $menu;
                                        }
                                        ?>
							</div>
							
							<!-- Header Right -->
							<div class="col-sm-4" id="header-right">
							     <?php 
							     $top_block = $modules_old_opencart->getModules('top_block');
							     if( count($top_block) ) { 
							     	foreach ($top_block as $module) {
							     		echo $module;
							     	}
							     } ?>
							     
							     <a href="<?php echo $account; ?>" class="my-account"><i class="fa fa-user"></i></a>
								<?php echo $cart; ?>
							</div>
						</div>
					</div>
					
					<?php 
					$menu92 = $modules_old_opencart->getModules('menu2');
					if( count($menu92) ) { 
					     echo '<div class="overflow-menu2">';
						foreach ($menu92 as $module) {
							echo $module;
						}
						echo '</div>';
					} ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php $slideshow = $modules_old_opencart->getModules('slideshow'); ?>
	<?php  if(count($slideshow)) { ?>
	<!-- Slider -->
	<div id="slider" class="<?php if($theme_options->get( 'slideshow_layout' ) == 1) { echo 'full-width'; } elseif($theme_options->get( 'slideshow_layout' ) == 4) { echo 'fixed3 fixed2'; } elseif($theme_options->get( 'slideshow_layout' ) == 3) { echo 'fixed2'; } else { echo 'fixed'; } ?>">
		<div class="background-slider"></div>
		<div class="background">
			<div class="shadow"></div>
			<div class="pattern">
			     <div class="container">
                         <div class="row slideshow-modules">
                              <div class="col-md-3">
               				<?php foreach($slideshow as $module) { ?>
               				<?php echo $module; ?>
               				<?php } ?>
               			</div>
               		     
               		     <div class="col-md-9">
               		          <div class="shop-by-car">
               		               <select class="shop-by-car-select" onChange="window.location.href=this.value">
               		                    <option><?php if($theme_options->get( 'shop_by_car_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'shop_by_car_text', $config->get( 'config_language_id' ) )); } else { echo 'Shop by car'; } ?></option>
               		               </select>
               		               
               		               <script type="text/javascript">
               		                    $(document).ready(function() {
               		                         $("#cars-links ul li a").each(function() {
               		                              $('select.shop-by-car-select').append('<option value="' + $(this).attr('href') + '">' + $(this).html() + '</option>');
               		                         });
               		                    });
               		               </script>
               		          </div>
               		          
               		          <div class="shop-by-brands">
               		               <select class="shop-by-brand-select" onChange="window.location.href=this.value">
               		                    <option><?php if($theme_options->get( 'shop_by_brand_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'shop_by_brand_text', $config->get( 'config_language_id' ) )); } else { echo 'Shop by brand'; } ?></option>
               		               </select>
               		               
               		               <script type="text/javascript">
               		                    $(document).ready(function() {
               		                         $("#brands-links ul li a").each(function() {
               		                              $('select.shop-by-brand-select').append('<option value="' + $(this).attr('href') + '">' + $(this).html() + '</option>');
               		                         });
               		                    });
               		               </script>
               		          </div>
               		          
               		          <div class="search_form_overflow">
                    		          <div class="search_form">					         
                    		              <div class="overflow-input"><input type="text" class="input-block-level search-query" name="search" placeholder="<?php echo $search; ?>" id="search_query" value="" /></div>
                    		              
                    		              <div class="button-search"></div>
                    		              <?php if($theme_options->get( 'quick_search_autosuggest' ) != '0') { ?>
                    		              	<div id="autocomplete-results" class="autocomplete-results"></div>
                    		              	
                    		              	<script type="text/javascript">
                    		              	$(document).ready(function() {
                    		              		$('#search_query').autocomplete({
                    		              			delay: 0,
                    		              			appendTo: "#autocomplete-results",
                    		              			source: function(request, response) {		
                    		              				$.ajax({
                    		              					url: 'index.php?route=search/autocomplete&filter_name=' +  encodeURIComponent(request.term),
                    		              					dataType: 'json',
                    		              					success: function(json) {
                    		              						response($.map(json, function(item) {
                    		              							return {
                    		              								label: item.name,
                    		              								value: item.product_id,
                    		              								href: item.href,
                    		              								thumb: item.thumb,
                    		              								desc: item.desc,
                    		              								price: item.price
                    		              							}
                    		              						}));
                    		              					}
                    		              				});
                    		              			},
                    		              			select: function(event, ui) {
                    		              				document.location.href = ui.item.href;
                    		              				
                    		              				return false;
                    		              			},
                    		              			focus: function(event, ui) {
                    		              		      	return false;
                    		              		   	},
                    		              		   	minLength: 2
                    		              		})
                    		              		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                    		              		  return $( "<li>" )
                    		              		    .append( "<a>" + item.label + "</a>" )
                    		              		    .appendTo( ul );
                    		              		};
                    		              	});
                    		              	</script>
                    		              <?php } ?>
                    		          </div>
               		          </div>
               		     </div>
               		</div>
          		</div>
			</div>
		</div>
	</div>
	<?php } ?>
</header>