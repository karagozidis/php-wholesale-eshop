<?php
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
?>

<!-- Product -->
<div class="product clearfix product-hover" style="padding: 17px 0px;">
	<div class="left">
		<?php if ($product['thumb']) { ?>
			
<?php if($product['quantity'] == "0") { ?> <div class="out_of_stock"> Out of Stock </div>   <?php  } ?>	
		
<?php if($product['jan'] != "") { ?>
       		
		    <?php  $SignFlags = explode(",", $product['jan']); ?>
		<?php if ($SignFlags[1] == 1) { ?> <div class="new"> NEW </div>   <?php  } ?>	
		<?php if ($SignFlags[3] == 1) { ?> <div class="next_season float-left"> NEXT SEASON </div>   <?php  } ?>	
		<?php if ($SignFlags[4] == 1) { ?> <div class="coming_soon float-left"> COMING SOON </div>   <?php  } ?>	
 
<?php  } else { ?>
	    <?php $SignFlags[0]= 0 ; ?>
		<?php $SignFlags[1]= 0 ; ?> 
		<?php $SignFlags[2]= 0 ; ?> 
		<?php $SignFlags[3]= 0 ; ?> 
		<?php $SignFlags[4]= 0 ; ?> 
		<?php $SignFlags[5]= 0 ;?>
<?php  } ?>	
		
		
			<div class="image <?php if($theme_options->get( 'product_image_effect' ) == '1') { echo 'image-swap-effect'; } ?>">
				<a href="<?php echo $product['href']; ?>">
					<?php if($theme_options->get( 'product_image_effect' ) == '1') {
						$nthumb = str_replace(' ', "%20", ($product['thumb']));
						$nthumb = str_replace(HTTP_SERVER, "", $nthumb);
						$image_size = getimagesize($nthumb);
						$image_swap = $theme_options->productImageSwap($product['product_id'], $image_size[0], $image_size[1]);
						if($image_swap != '') echo '<img src="' . $image_swap . '" alt="' . $product['name'] . '" class="swap-image" />';
					} ?> 
					<?php if($theme_options->get( 'lazy_loading_images' ) != '0') { ?>
					<img src="image/catalog/blank.gif" data-echo="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="<?php if($theme_options->get( 'product_image_effect' ) == '2') { echo 'zoom-image-effect'; } ?>" />
					<?php } else { ?>
					<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="<?php if($theme_options->get( 'product_image_effect' ) == '2') { echo 'zoom-image-effect'; } ?>" />
					<?php } ?>
				</a>
			</div>
		<?php } else { ?>
			<div class="image">
				<a href="<?php echo $product['href']; ?>"><img src="image/no_image.jpg" alt="<?php echo $product['name']; ?>" <?php if($theme_options->get( 'product_image_effect' ) == '2') { echo 'class="zoom-image-effect"'; } ?> /></a>
			</div>
		<?php } ?>
		<?php if($theme_options->get( 'display_specials_countdown' ) == '1' && $product['special']) { $countdown = rand(0, 5000)*rand(0, 5000); 
		          $product_detail = $theme_options->getDataProduct( $product['product_id'] );
		          $date_end = $product_detail['date_end'];
		          if($date_end != '0000-00-00' && $date_end) { ?>
               		<script>
               		$(function () {
               			var austDay = new Date();
               			austDay = new Date(<?php echo date("Y", strtotime($date_end)); ?>, <?php echo date("m", strtotime($date_end)); ?> - 1, <?php echo date("d", strtotime($date_end)); ?>);
               			$('#countdown<?php echo $countdown; ?>').countdown({until: austDay});
               		});
               		</script>
               		<div id="countdown<?php echo $countdown; ?>" class="clearfix"></div>
     		     <?php } ?>
		<?php } ?>
	</div>
	<div class="right">
		<div class="col-sm-4" style="top: 5px;">
			<?php if($theme_options->get( 'display_add_to_compare' ) != '0' || $theme_options->get( 'display_add_to_wishlist' ) != '0' || $theme_options->get( 'display_add_to_cart' ) != '0') { ?>
			<div class="only-hover" style="bottom: 0px;padding: 0px; position: inherit;">
				
				<?php if ($product['ImgHexsTotal']>0) { ?>
							<div class="overflow-thumbnails-carousel clearfix" style="padding: 20px 0px 0px 0px;" > 
									<?php foreach ($product['ImgHexs'] as $image) { ?>
									<?php if ( $image['imgHex'] != "" ) { ?>
												<label class="CColorHexs" id="ColorHex<?php echo str_replace("#","",$image['imgHex']); ?>" style="background: <?php echo $image['imgHex']; ?>;width: 20px;height: 20px;border: 1px solid #a7a7a7;"></label>		
									<?php } ?>
									<?php } ?> 
							</div>
				<?php } ?> 


			</div>
			<?php } ?>
		</div>
		<div class="col-sm-4">
			<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['sku']; ?></a></div>
			<?php if($theme_options->get( 'product_grid_type' ) == '7') { ?>
			<?php $product_detail = $theme_options->getDataProduct( $product['product_id'] ); ?>
			<div class="brand"><?php echo $product_detail['manufacturer']; ?></div>
			<?php } ?>
			
			<?php if($product['price']) { ?>
			<div class="price">
				<?php if (!$product['special']) { ?>
				<?php echo $product['price']; ?>
				<?php } else { ?>
				<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="col-sm-4" style="top: 7px;">
			<img src="<?php echo $product['CCCIMAGE']; ?>">
		</div>
		
		
		
	</div>
</div>