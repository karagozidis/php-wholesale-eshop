<?php

class ModelSoftoneProduct extends Model {
   
	
public function SyncRelatedProducts($data) 
		{
			 $queryR = $this->db->query(
                        "SELECT product_id"
                        . " FROM " . DB_PREFIX . "product WHERE model = '" . (int) $data['CODE'] . "' ");
                 
                if ($queryR->row)
                    {
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$queryR->row['product_id'] . "' ");
						
						foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
							 {
								 
								$queryR2 = $this->db->query(
                                     "SELECT product_id"
                                          . " FROM " . DB_PREFIX . "product WHERE model = '" .(int) $option_CODE . "' " );
								   
								if ($queryR2->row)
									{	
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$queryR->row['product_id'] . "', related_id = '" . (int)$queryR2->row['product_id']  . "'");
									}		   
							 }

					}
		}
	
	
	
public function UpdateProductImages($product_id, $data) 
		{
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' AND imgLbl = '' ");
		  
				$img_rel1 = "catalog/s1/".$data['model'].".jpg";
				if (file_exists(DIR_IMAGE . $img_rel1)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel1, ENT_QUOTES, 'UTF-8')) . "', sort_order = '1'");
				}
		  
		  
				$img_rel2 = "catalog/s1/".$data['model']."-2.jpg";
				if (file_exists(DIR_IMAGE . $img_rel2)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel2, ENT_QUOTES, 'UTF-8')) . "', sort_order = '2'");
				}
				
				$img_rel3 = "catalog/s1/".$data['model']."-3.jpg";
				if (file_exists(DIR_IMAGE . $img_rel3)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel3, ENT_QUOTES, 'UTF-8')) . "', sort_order = '3'");
				}
					
				$img_rel4 = "catalog/s1/".$data['model']."-4.jpg";
				if (file_exists(DIR_IMAGE . $img_rel4)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel4, ENT_QUOTES, 'UTF-8')) . "', sort_order = '4'");
				}
				 
				$img_rel5 = "catalog/s1/".$data['model']."-5.jpg";
				if (file_exists(DIR_IMAGE . $img_rel5)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel5, ENT_QUOTES, 'UTF-8')) . "', sort_order = '5'");
				}	
		}
	
	
	public function UpdateProductCategoryFlagFilters($data) 
		{
		 
        $softone_code = $data['model']; 
		
		$Flag[0] = $data['NEW_ITEM'];
		$Flag[1] = $data['PREV_SEASON'];
		$Flag[2] = $data['NEXT_SEASON'];
		$Flag[3] = $data['COMING_SOON'];
		$Flag[4] = $data['PROMO'];
		$Flag[5] = $data['WEB_DISCNT'];
		
		$CATEG_ID[0] = 'Flag0';
		$CATEG_ID[1] = 'Flag1';
		$CATEG_ID[2] = 'Flag2';
		$CATEG_ID[3] = 'Flag3';
		$CATEG_ID[4] = 'Flag4';
		$CATEG_ID[5] = 'Flag5';
		
						
		$MTRCATEGORYNAME[0] = 'New Products';
		$MTRCATEGORYNAME[1] = 'Previous Season';
		$MTRCATEGORYNAME[2] = 'Next Season';
		$MTRCATEGORYNAME[3] = 'Comming Soon';
		$MTRCATEGORYNAME[4] = 'Promo';
		$MTRCATEGORYNAME[5] = 'Discounted Products';
		
		
		$MTRCATEGORYNAMEGR[0] = 'Νέα είδη';
		$MTRCATEGORYNAMEGR[1] = 'Προηγούμενη Σεζόν';
		$MTRCATEGORYNAMEGR[2] = 'Επόμενη Σεζόν';
		$MTRCATEGORYNAMEGR[3] = 'Comming Soon';
		$MTRCATEGORYNAMEGR[4] = 'Promo';
		$MTRCATEGORYNAMEGR[5] = 'Εκπτωτικά';
		
		
		$queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
					
					
		for($x = 0; $x < 6; $x++) {
			
			if($Flag[$x] == '1')
			{
			
					$queryR1 = $this->db->query(
							" SELECT f.filter_id FROM `" . DB_PREFIX . "filter` f ".
							" WHERE f.gencolor = '".$CATEG_ID[$x]."'  and f.filter_group_id = 7 " );
					
					
					
					if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter` (`filter_group_id`,`gencolor`) VALUES (7,'".$CATEG_ID[$x]."') ");	    
									$filter_id = $this->db->getLastId();	
									 
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",1,7,'".$this->db->escape($MTRCATEGORYNAME[$x])."') ");	   
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",2,7,'".$this->db->escape($MTRCATEGORYNAMEGR[$x])."') ");	    								 
							}
					else 
							{
								$filter_id = $queryR1->row['filter_id'];
							}							
						
					 
					 $queryC = $this->db->query( " SELECT COUNT(*) AS TOTALS ".
												 " FROM " . DB_PREFIX . "product_filter ".
												 " WHERE product_id = '" . (int)$product_id . "' ".
												 " AND   filter_id = '" . (int)$filter_id . "' ");
	 					
					 if ( $queryC->row['TOTALS'] == 0)
							 {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter (product_id,filter_id) ".
													 "SELECT  '" . (int)$product_id . "' as product_id, " . $filter_id . " as filter_id "
													 );	    
							 }	
							 
			}	   
		}				   
	}
	
	
	
public function UpdateProductCategoryFilter($data) 
	 {
		 
        $softone_code = $data['model']; 
		$CATEG_ID = $data['CATEG_ID']; 
		$MTRCATEGORYNAME = $data['MTRCATEGORYNAME']; 
		
		
		
		
		$queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
					
					
					
					$queryR1 = $this->db->query(
							" SELECT f.filter_id FROM `" . DB_PREFIX . "filter` f ".
							" WHERE f.gencolor = '".$CATEG_ID."'  and f.filter_group_id = 5 " );
					
					
					
					if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter` (`filter_group_id`,`gencolor`) VALUES (5,".$CATEG_ID.") ");	    
									$filter_id = $this->db->getLastId();	
									 
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",1,5,'".$this->db->escape($MTRCATEGORYNAME)."') ");	   
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",2,5,'".$this->db->escape($MTRCATEGORYNAME)."') ");	    								 
							}
					else 
							{
								$filter_id = $queryR1->row['filter_id'];
							}							
						
					 
					 $queryC = $this->db->query( " SELECT COUNT(*) AS TOTALS ".
												 " FROM " . DB_PREFIX . "product_filter ".
												 " WHERE product_id = '" . (int)$product_id . "' ".
												 " AND   filter_id = '" . (int)$filter_id . "' ");
	 					
					 if ( $queryC->row['TOTALS'] == 0)
							 {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter (product_id,filter_id) ".
													 "SELECT  '" . (int)$product_id . "' as product_id, " . $filter_id . " as filter_id "
													 );	    
							 }			
				     		
	}
	
	
public function UpdateProductColorImages($data) 
	 {
		 
        $softone_code = $data['CODE'];           
		$colorValue = "NotInitialized";
		$FirstHeadingValueFoundAgain = 0;
		
		$queryP = $this->db->query( " SELECT p.product_id, p.sku FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
                                $product_id = $queryP->row['product_id'];
                                $sku = $queryP->row['sku'];						 
							}
						else 
							{
								return;
							}	
					
		$counter = 0;
			foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
			{
                 $values = explode("~", $option_value);
				 $val0sec = explode(" ", $values[0]);
				 $NameValue = $val0sec[0];
				 $HeadingValue = $values[1];
				 $quantity = $values[2];
				 $hex = $values[3];
				 $genName = $values[4];
                 $filter_id = 0;           
								
				 
				 if($colorValue != $NameValue) 
						{	
						$queryR1 = $this->db->query(
									" SELECT i.product_image_id FROM `" . DB_PREFIX . "product_image` i ".
									" WHERE i.imgLbl = '".$NameValue."' and i.product_id = ".$product_id."  " );
					
					     if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',1) ");
									$this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',2) ");	    									
                                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',3) ");	    																		
                                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',4) ");
									$this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',5) ");	    									
									$this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',6) ");	   									$this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',1) ");
									$this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',7) ");	    									
                                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',8) ");	   
                                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image`(`product_id`,`sort_order`,`imgHex`,`imgLbl`, `imgCounter`) VALUES (".$product_id.",".$counter.",'".$hex."','".$NameValue."',9) ");  
							}
						else 
							{
								$product_image_id = $queryR1->row['product_image_id'];
								$this->db->query("UPDATE `" . DB_PREFIX . "product_image` SET `imgHex` = '".$hex."', `sort_order` = ".$counter." WHERE product_image_id =  ".$product_image_id." AND product_id = ".$product_id."; ");		
							}							

						}
				
				$colorValue = $NameValue;
				$counter ++; 
            }
                
            

            //Sync Images
           /* $PIMG = "catalog/images/".$data['ItemExtra1'].".jpg";
            $PIMGNew = "catalog/".$data['model']."/".$data['ItemExtra1'].".jpg";

            if (file_exists(DIR_IMAGE . $PIMG)) {
                if (copy(DIR_IMAGE . $PIMG, DIR_IMAGE . $PIMGNew)) {
                    // copy( (DIR_IMAGE.$PIMG) , (DIR_IMAGE.$PIMGNew) ) ;
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET "
                    . " image= '" . $this->db->escape(html_entity_decode($PIMGNew, ENT_QUOTES, 'UTF-8')) . "' "
                    . " WHERE product_id = '" . (int)$product_id . "'");
                }
            } */

            $qrProductImages = $this->db->query(" SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . $product_id ."'"  );
            
            foreach ($qrProductImages->rows as $product_image) 
            {   
                $imgCurCounter = "";
                if($product_image['imgCounter']<10)  $imgCurCounter = "0".$product_image['imgCounter'];
                else $imgCurCounter = "".$product_image['imgCounter'];

                $PIMG = "catalog/images/".$sku."-".$product_image['imgLbl']."-".$imgCurCounter.".jpg";
                $PIMGNew = "catalog/".$data['CODE']."/".$sku."-".$product_image['imgLbl']."-".$imgCurCounter.".jpg";


               
                if (file_exists(DIR_IMAGE . $PIMG)) 
                { 
                    if (copy(DIR_IMAGE . $PIMG, DIR_IMAGE . $PIMGNew)) 
                    {
                       // echo "     " . $PIMGNew . "     ";
                        $this->db->query("UPDATE " . DB_PREFIX . "product_image ".
                            " SET ".
                            " image = '" . $this->db->escape(html_entity_decode($PIMGNew, ENT_QUOTES, 'UTF-8')) . "' ".
                            " where product_id = '" . (int)$product_id . "' ".
                            " and 	product_image_id = '".(int)$product_image['product_image_id'] . "'"
                        );
                    }
                }
            }
	}

	
	
public function DeleteProductFilters($data) 
	 {
		 
		  $softone_code = $data['CODE'];
		  
	      $queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
          if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
							
		 $this->db->query("DELETE pf FROM " . DB_PREFIX . "product_filter pf INNER JOIN " . DB_PREFIX . "filter f ON f.filter_id = pf.filter_id  WHERE  pf.product_id = '" . (int)$product_id . "' AND f.filter_group_id NOT IN (5,7) ");	  
	 }
	 
public function DeleteProductFiltersOnly5($data) 
	 {
		 
		  $softone_code = $data['CODE'];
		  
	      $queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
          if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
							
		 $this->db->query("DELETE pf FROM " . DB_PREFIX . "product_filter pf INNER JOIN " . DB_PREFIX . "filter f ON f.filter_id = pf.filter_id  WHERE  pf.product_id = '" . (int)$product_id . "' AND f.filter_group_id in (5,7) ");	  
	 }
	 
public function addFiltersSizes($data) 
	 {
            $softone_code = $data['CODE'];
                    
		   // $colorValue = "NotInitialized";
		   // $FirstHeadingValueFoundAgain = 0;
		
		
		$queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
					
		
			foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
			{
                 $values = explode("~", $option_value);
				 $val0sec = explode(" ", $values[0]);
				 $NameValue = $val0sec[1];
				 $HeadingValue = $values[1];
				 $quantity = $values[2];
				 $hex = $values[3];
				 $genName = $values[4];
                 $filter_id = 0;           
								
				 
				// if($colorValue != $NameValue) 
				//		{	
						$queryR1 = $this->db->query(
									" SELECT f.filter_id FROM `" . DB_PREFIX . "filter` f ".
									" INNER JOIN `" . DB_PREFIX . "filter_description` fd ON f.filter_id = fd.filter_id ".
									" WHERE fd.name = '".$NameValue."' and fd.language_id = 1 and f.filter_group_id = 3 " );
					
					
					
					     if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter`(`filter_group_id`) VALUES (3) ");	    
									$filter_id = $this->db->getLastId();	
									 
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",1,3,'".$NameValue."') ");	   
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",2,3,'".$NameValue."') ");	    								 
							}
						else 
							{
								$filter_id = $queryR1->row['filter_id'];
							  //$this->db->query("UPDATE `" . DB_PREFIX . "filter` SET `colorhex` = '".$hex."' ,`gencolor` = '".$genName."'  WHERE filter_group_id = 3 AND filter_id = ".$filter_id."; ");		
							}							
						
					 
					 $queryC = $this->db->query( " SELECT COUNT(*) AS TOTALS ".
												 " FROM " . DB_PREFIX . "product_filter ".
												 " WHERE product_id = '" . (int)$product_id . "' ".
												 " AND   filter_id = '" . (int)$filter_id . "' ");
	 					
					 if ( $queryC->row['TOTALS'] == 0)
							 {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter (product_id,filter_id) ".
													 "SELECT  '" . (int)$product_id . "' as product_id, " . $filter_id . " as filter_id "
													 );	    
							 }			
				//		}
				
			//	$colorValue = $NameValue;
				
            }
				     		
	}
	
	
	
	
	
	public function addFilterGeneralSizes($data) 
	 {
            $softone_code = $data['CODE'];
                    
		   // $colorValue = "NotInitialized";
		   // $FirstHeadingValueFoundAgain = 0;
		
		
		$queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
					
		
			foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
			{
                 $values = explode("~", $option_value);
				 $val0sec = explode(" ", $values[0]);
				 $NameValue = $values[5];
				 $HeadingValue = $values[1];
				 $quantity = $values[2];
				 $hex = $values[3];
				 $genName = $values[4];
                 $filter_id = 0;           
								
				 
				// if($colorValue != $NameValue) 
				//		{	
						$queryR1 = $this->db->query(
									" SELECT f.filter_id FROM `" . DB_PREFIX . "filter` f ".
									" INNER JOIN `" . DB_PREFIX . "filter_description` fd ON f.filter_id = fd.filter_id ".
									" WHERE fd.name = '".$NameValue."' and fd.language_id = 1 and f.filter_group_id = 6 " );
					
					
					
					     if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter`(`filter_group_id`) VALUES (6) ");	    
									$filter_id = $this->db->getLastId();	
									 
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",1,6,'".$NameValue."') ");	   
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",2,6,'".$NameValue."') ");	    								 
							}
						else 
							{
								$filter_id = $queryR1->row['filter_id'];
							  
							}							
						
					 
					 $queryC = $this->db->query( " SELECT COUNT(*) AS TOTALS ".
												 " FROM " . DB_PREFIX . "product_filter ".
												 " WHERE product_id = '" . (int)$product_id . "' ".
												 " AND   filter_id = '" . (int)$filter_id . "' ");
	 					
					 if ( $queryC->row['TOTALS'] == 0)
							 {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter (product_id,filter_id) ".
													 "SELECT  '" . (int)$product_id . "' as product_id, " . $filter_id . " as filter_id "
													 );	    
							 }			
				//		}
				
			//	$colorValue = $NameValue;
				
            }
				     		
	}
	
	
	

	
	public function addFilterGeneralColors($data) 
	 {
            $softone_code = $data['CODE'];
                    
		    $colorValue = "NotInitialized";
		    $FirstHeadingValueFoundAgain = 0;
		
		
		$queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
					

			foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
			{
                 $values = explode("~", $option_value);
				 $val0sec = explode(" ", $values[0]);
				 $NameValue = $val0sec[0];
				 $HeadingValue = $values[1];
				 $quantity = $values[2];
				 $hex = $values[3];
				 $genName = $values[4];
                 $filter_id = 0;           
								
				 
				 if($colorValue != $NameValue) 
						{	
						$queryR1 = $this->db->query(
									" SELECT f.filter_id FROM `" . DB_PREFIX . "filter` f ".
									" INNER JOIN `" . DB_PREFIX . "filter_description` fd ON f.filter_id = fd.filter_id ".
									" WHERE fd.name = '".$genName."' and fd.language_id = 1 and f.filter_group_id = 4 " );
					
					
					
					     if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter`(`filter_group_id`,`colorhex`,`gencolor`) VALUES (4,'".$hex."','')");	    
									$filter_id = $this->db->getLastId();	
									 
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",1,4,'".$genName."') ");	   
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",2,4,'".$genName."') ");	    								 
							}
						else 
							{
								$filter_id = $queryR1->row['filter_id'];
								$this->db->query("UPDATE `" . DB_PREFIX . "filter` SET `colorhex` = '".$hex."' ,`gencolor` = '".$genName."'  WHERE filter_group_id = 4 AND filter_id = ".$filter_id."; ");		
							}							
						
					 
					 $queryC = $this->db->query( " SELECT COUNT(*) AS TOTALS ".
												 " FROM " . DB_PREFIX . "product_filter ".
												 " WHERE product_id = '" . (int)$product_id . "' ".
												 " AND   filter_id = '" . (int)$filter_id . "' ");
	 					
					 if ( $queryC->row['TOTALS'] == 0)
							 {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter (product_id,filter_id) ".
													 "SELECT  '" . (int)$product_id . "' as product_id, " . $filter_id . " as filter_id "
													 );	    
							 }			
						}
				
				$colorValue = $NameValue;
				
            }
				     		
	}
	
	
	
	
public function addFilterColors($data) 
	 {
            $softone_code = $data['CODE'];
                    
		    $colorValue = "NotInitialized";
		    $FirstHeadingValueFoundAgain = 0;
		
		
		$queryP = $this->db->query( " SELECT p.product_id FROM `" . DB_PREFIX . "product` p ".
									" WHERE p.model = '".$softone_code."' " );
					
        if ($queryP->num_rows > 0)
							{       
								$product_id = $queryP->row['product_id'];			 
							}
						else 
							{
								return;
							}	
					
		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE  product_id = '" . (int)$product_id . "' ");	   

	
		
			foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
			{
                 $values = explode("~", $option_value);
				 $val0sec = explode(" ", $values[0]);
				 $NameValue = $val0sec[0];
				 $HeadingValue = $values[1];
				 $quantity = $values[2];
				 $hex = $values[3];
				 $genName = $values[4];
                 $filter_id = 0;           
								
				 
				 if($colorValue != $NameValue) 
						{	
						$queryR1 = $this->db->query(
									" SELECT f.filter_id FROM `" . DB_PREFIX . "filter` f ".
									" INNER JOIN `" . DB_PREFIX . "filter_description` fd ON f.filter_id = fd.filter_id ".
									" WHERE fd.name = '".$NameValue."' and fd.language_id = 1 and f.filter_group_id = 1 " );
					
					
					
					     if ($queryR1->num_rows == 0)
							{       
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter`(`filter_group_id`,`colorhex`,`gencolor`) VALUES (1,'".$hex."','".$genName."')");	    
									$filter_id = $this->db->getLastId();	
									 
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",1,1,'".$NameValue."') ");	   
									$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_description`(`filter_id`, `language_id`, `filter_group_id`, `name`) VALUES (".$filter_id.",2,1,'".$NameValue."') ");	    								 
							}
						else 
							{
								$filter_id = $queryR1->row['filter_id'];
								$this->db->query("UPDATE `" . DB_PREFIX . "filter` SET `colorhex` = '".$hex."' ,`gencolor` = '".$genName."'  WHERE filter_group_id = 1 AND filter_id = ".$filter_id."; ");		
							}							
						
					 
					 $queryC = $this->db->query( " SELECT COUNT(*) AS TOTALS ".
												 " FROM " . DB_PREFIX . "product_filter ".
												 " WHERE product_id = '" . (int)$product_id . "' ".
												 " AND   filter_id = '" . (int)$filter_id . "' ");
	 					
					 if ( $queryC->row['TOTALS'] == 0)
							 {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter (product_id,filter_id) ".
													 "SELECT  '" . (int)$product_id . "' as product_id, " . $filter_id . " as filter_id "
													 );	    
							 }			
						}
				
				$colorValue = $NameValue;
				
            }
				     		
	}
	
	
	
	 public function addOptionOnProduct($data) {
		 
      $softone_code = $data['CODE'];
                 
	  $queryR = $this->db->query(
                        " select pop.product_option_id".
                        " from ( " . DB_PREFIX . "product_option pop inner join " . DB_PREFIX . "option op".
                        " on  pop.option_id =  op.option_id)".
                        " inner join " . DB_PREFIX . "product pr on pop.product_id = pr.product_id".
                        " where op.softone_code = '".$this->db->escape($softone_code)."'".
                        " and pr.model = '".$this->db->escape($softone_code)."'"
                        );
                        
                if (!$queryR->row)
                    {      
                    $this->db->query(
                            "INSERT INTO " . DB_PREFIX . "product_option ".
                            " SET ". //product_option_id = '" . (int)$product_option['product_option_id'] . "',".
                            " product_id = "."(select pr.product_id from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ) ". ",".
                            " option_id = " ."(select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' ) "  . ", ".
                            " required = '1'"
                            );

                    	$product_option_id = $this->db->getLastId();
                    }
                else 
                    {
                        $product_option_id = $queryR->row['product_option_id'];
                    }
                
		 
		 	$this->db->query(
                   " DELETE FROM " . DB_PREFIX . "product_option_value WHERE ".
                   " product_id = "."(select pr.product_id from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ) ". " AND ".
                   " option_id = " ." (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' ); "
                   ); 
		 
		 foreach ($data['OPTIONS'] as $option_CODE => $option_value) 
		 {
		 		$this->db->query(
                   "INSERT INTO " . DB_PREFIX . "product_option_value ".
			       " SET ".
                   " product_option_id = '" . (int)$product_option_id . "', ".
                   " product_id = "."(select pr.product_id from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ) ". ",".
                   " option_id = " ." (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' ) ". ",". 
                   " option_value_id =" ." (select opv.option_value_id from " . DB_PREFIX . "option_value opv where opv.softone_code = '".$this->db->escape($option_CODE)."' AND ". 
				   " opv.option_id= (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' )  ) ". ",".
                   " quantity =" ." (select opv.quantityP from " . DB_PREFIX . "option_value opv where opv.softone_code = '".$this->db->escape($option_CODE)."' AND ". 
				   " opv.option_id= (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' )  ) ". ",".
                   " subtract = '1', ".
                   " price = (select pr.price from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ), ".
                   " price_prefix = '+', ".
                   " points = '0', ".
                   " points_prefix = '+', ".
                   " weight = '0', ".
                   " weight_prefix = '-'");		   
		 }
		 
	 }
	
	
    public function addOption($data) {
        
                $queryR = $this->db->query(
                        "SELECT option_id"
                        . " FROM " . DB_PREFIX . "option WHERE softone_code = '" . $this->db->escape($data['CODE']) . "'");
                 
                if (!$queryR->row)
                    {
					
					if($data['TC'] == 1)  $columnType = "column_". $this->db->escape($data['TC']);
					else  $columnType = "columns_". $this->db->escape($data['TC']);
						
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET "
                            . " type = 'option_qty', "
                            . " sort_order = '1' , " 	 
							. " column_table = '".$columnType."',"
                            . " softone_code = '".$this->db->escape($data['CODE'])."'  "
                            );

                    $option_id = $this->db->getLastId();

                    $this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET "
                            . " option_id = '" . (int)$option_id . "', "
                            . " language_id = '1', "
                            . "name = '" . $this->db->escape($data['NAME']) . "'"
                            );

                    $this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET "
                            . " option_id = '" . (int)$option_id . "', "
                            . " language_id = '2', "
                            . "name = '" . $this->db->escape($data['NAME']) . "'"
                            );
                            
                            $selected_option_id = $option_id;
                    }
                  else
                    {
                    $selected_option_id = $queryR->row['option_id'];
                    }  
                    
		//if (isset($data['OPTIONS'])) {
		    $i =0 ; 
		    //$FirstHeadingValue = "NotInitialized";
		    //$FirstHeadingValueFoundAgain = 0;
		    $counter = $data['TC'];
			foreach ($data['OPTIONS'] as $option_CODE => $option_value) {
                            
                         $queryR1 = $this->db->query(
                        "SELECT option_value_id"
                        . " FROM " . DB_PREFIX . "option_value WHERE softone_code = '" . $this->db->escape($option_CODE) . "' "
                        . " and option_id=".$selected_option_id);
                
                        
                        if (!$queryR1->row)
                            {   
                                $values = explode("~", $option_value);
							    $NameValue = $values[0];
							    $HeadingValue = $values[1];
							    $quantity = $values[2];
                                
                                $this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET "
                                        . " option_id = '" . (int)$selected_option_id . "', "
                                       // . " image = '" . $this->db->escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', "
                                        . " sort_order = '" . (int)$i . "', "
								        . " quantityP = '" . (int)$quantity . "', "
                                        . " softone_code = '".$this->db->escape($option_CODE)."'  "
                                        );
                                $i++;

                                $option_value_id = $this->db->getLastId();

						
							
							//if($FirstHeadingValue == $HeadingValue) $FirstHeadingValueFoundAgain = 1;
							//if($FirstHeadingValueFoundAgain == 1)
							if(!($counter>0))	$HeadingValue = "";
							
							
                                $this->db->query(
                                        "INSERT INTO " . DB_PREFIX . "option_value_description SET "
                                        . " option_value_id = '" . (int)$option_value_id . "', "
                                        . " language_id = '1', "
                                        . " option_id = '" . (int)$selected_option_id . "', "
								     	. " heading = '" .$this->db->escape($HeadingValue). "', "
                                        . " name = '" . $this->db->escape($NameValue) . "'"
                                        );

                                $this->db->query(
                                        "INSERT INTO " . DB_PREFIX . "option_value_description SET "
                                        . " option_value_id = '" . (int)$option_value_id . "', "
                                        . " language_id = '2', "
                                        . " option_id = '" . (int)$selected_option_id . "', "
								    	. " heading = '" .$this->db->escape($HeadingValue). "', "
                                        . " name = '" . $this->db->escape($NameValue) . "'"
                                        );  
							
						//	if($FirstHeadingValue == "NotInitialized") $FirstHeadingValue = $HeadingValue;
							$counter--;
                            }
				
				

                        
			}
	}
	
	
	
	
	
public function deleteOption($data) {
	
	    $queryR = $this->db->query( "SELECT option_id"
                        . " FROM " . DB_PREFIX . "option WHERE softone_code = '" . $this->db->escape($data['CODE']) . "'");
                 
        if ($queryR->row)
            {	
			$option_id = $queryR->row['option_id'];
			
			$this->db->query("DELETE FROM `" . DB_PREFIX . "option` WHERE option_id = '" . (int)$option_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "option_description WHERE option_id = '" . (int)$option_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "option_value WHERE option_id = '" . (int)$option_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "option_value_description WHERE option_id = '" . (int)$option_id . "'");
			}
	}
	
	
    public function updateOptionQty($data) {

    foreach ($data['QTYS'] as $order_id => $value) 
      {  
      $values = explode("~", $value);
      $softone_code = $values[5];
      
      
      //Characteristic 1
      $queryR = $this->db->query(
                        " select pop.product_option_id".
                        " from ( " . DB_PREFIX . "product_option pop inner join " . DB_PREFIX . "option op".
                        " on  pop.option_id =  op.option_id)".
                        " inner join " . DB_PREFIX . "product pr on pop.product_id = pr.product_id".
                        " where op.softone_code = '".$this->db->escape($softone_code)."'".
                        " and pr.model = '".$this->db->escape($softone_code)."'"
                        );
                        
                if (!$queryR->row)
                    {      
                    $this->db->query(
                            "INSERT INTO " . DB_PREFIX . "product_option ".
                            " SET ". //product_option_id = '" . (int)$product_option['product_option_id'] . "',".
                            " product_id = "."(select pr.product_id from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ) ". ",".
                            " option_id = " ."(select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' ) "  . ", ".
                            " required = '1'"
                            );

                    	$product_option_id = $this->db->getLastId();
                    }
                else 
                    {
                        $product_option_id = $queryR->row['product_option_id'];
                    }
                
   		$c2 = "";   
		/*if($values[2] > 0)
			{
			$c2 =   " AND option_value_name2 =" ." (select opvd.name from " . DB_PREFIX . "option_value opv ".
			" inner join " . DB_PREFIX . "option_value_description opvd on opv.option_value_id = opvd.option_value_id ".
			" and opv.option_id = opvd.option_id ".
		    " and opvd.language_id = 1 ".
			" where opv.softone_code = '".$this->db->escape($values[2])."' and opv.option_id= (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($values[6])."' )  ) ";
			} */
		$this->db->query(
                   " DELETE FROM " . DB_PREFIX . "product_option_value WHERE ".
                   " product_id = "."(select pr.product_id from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ) ". " AND ".
                   " option_id = " ." (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($softone_code)."' ) ". " AND ". 
                   " option_value_id =" ." (select opv.option_value_id from " . DB_PREFIX . "option_value opv where opv.softone_code = '".$this->db->escape($values[1])."' and opv.option_id= (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($values[0])."' )  ) ".
				   $c2 
                   ); 
                   
		$c2 = "";   
		if($values[2] > 0)
			{
			$c2 = " option_value_name2 =" ." (select opvd.name from " . DB_PREFIX . "option_value opv ".
			" inner join " . DB_PREFIX . "option_value_description opvd on opv.option_value_id = opvd.option_value_id ".
			" and opv.option_id = opvd.option_id ".
			" and opvd.language_id = 1 ".
			"  where opv.softone_code = '".$this->db->escape($values[2])."' and opv.option_id= (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($values[6])."' )  ) ". ","; 
			}
			
		$this->db->query(
                   "INSERT INTO " . DB_PREFIX . "product_option_value ".
                   " SET ".// product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', ".
                   " product_option_id = '" . (int)$product_option_id . "', ".
                   " product_id = "."(select pr.product_id from " . DB_PREFIX . "product pr where pr.model = '".$this->db->escape($softone_code)."' ) ". ",".
                   " option_id = " ." (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($values[0])."' ) ". ",". 
                   " option_value_id =" ." (select opv.option_value_id from " . DB_PREFIX . "option_value opv where opv.softone_code = '".$this->db->escape($values[1])."' and opv.option_id= (select op.option_id from " . DB_PREFIX . "option op where op.softone_code = '".$this->db->escape($values[0])."' )  ) ". ",".
				    $c2.
                   " quantity = '" . (int)$values[4]. "', ".
                   " subtract = '1', ".
                   " price = '0', ".
                   " price_prefix = '+', ".
                   " points = '0', ".
                   " points_prefix = '+', ".
                   " weight = '0', ".
                   " weight_prefix = '-'");		   
				   

                                   
     
                                   
      }      
    }
    
    
    public function updateQty($softone_code ,$value ) {

	    $this->db->query("UPDATE " . DB_PREFIX . "product SET "

            . " quantity = '" . (int) $value . "' " .

            // . " image_banner = '" . $this->db->escape(html_entity_decode($image, ENT_QUOTES, 'UTF-8')) . "' ". 

             " WHERE model = '" . $this->db->escape($softone_code) . "'"); 

	}
	
	
    public function editProductImage($model,$image) {
            
		    /* 
		    $this->db->query("UPDATE " . DB_PREFIX . "product SET "
            . " image = '" . $this->db->escape(html_entity_decode($image, ENT_QUOTES, 'UTF-8')) . "' " .
            // . " image_banner = '" . $this->db->escape(html_entity_decode($image, ENT_QUOTES, 'UTF-8')) . "' ". 
            " WHERE model = '" . $this->db->escape($model) . "'"); 
            $this->cache->delete('product'); 
			*/
		
	}

    

    public function checkIfExists($model) {

		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

		return $query->row;

	}

         

    public function checkIfCategExists($cId) {

		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE softone_code='" . $this->db->escape($cId) . "'");

		return $query->row;

	}

		 

        public function checkIfActive($softone_code) {

		$query = $this->db->query("SELECT status FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($softone_code) . "'");

		return $query->row;

	}

        

        public function getIdByModel($model) {

		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

		return $query->row;

	}



        public function activate($softone_code) {

                	$this->db->query("UPDATE " . DB_PREFIX . "product  SET status = '1' where model='". $this->db->escape($softone_code) . "'");

	}

        

        public function deActivate($softone_code) {

                	$this->db->query("UPDATE " . DB_PREFIX . "product  SET status = '0' where model='". $this->db->escape($softone_code) . "'");

	}

 

 

     public function connectToProduct($product_id , $softone_code) {

              $this->db->query("UPDATE " . DB_PREFIX . "product SET model = product_id WHERE model = '" . $this->db->escape($softone_code) . "'");

			  $this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($softone_code) . "' WHERE product_id = '" . (int) $product_id . "'");

	}

 

 

    public function addCategory($data) {



		$this->db->query("INSERT INTO " . DB_PREFIX . "category " . 

			" (`category_id`,  ".

			" `parent_id`, `top`, `column`, `sort_order`, `status`, `date_added`, `date_modified`, `softone_code`) VALUES " .

			" (NULL, '0', '0', '0', '0', '0', now(), now(), '".$data['MTRGROUP']."'); " );

		

		$category_id = $this->db->getLastId();

                         

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_description ".

		" (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES ".

		"('".$category_id."', '1', '".$data['NAME']."', '', '', '')"

		);

		

	    $this->db->query("INSERT INTO " . DB_PREFIX . "category_description ".

		" (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES ".

		"('".$category_id."', '2', '".$data['NAME']."', '', '', '')"

		);

		

		//INSERT INTO `rfcomgr_dbrfcnew`.`m7s0p_category_to_store` (`category_id`, `store_id`) VALUES ('1111', '1111');

		

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store ".

		" (`category_id`, `store_id`) VALUES ".

		"('".$category_id."', '0')"

		);

		

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '0'");

	}



 

    public function editCategory($category_id,$data) {

    
            /*
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_description ".

		" (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES ".

		"('".$category_id."', '1', '".$data['NAME']."', '', '', '')"

		);

		

	    $this->db->query("INSERT INTO " . DB_PREFIX . "category_description ".

		" (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES ".

		"('".$category_id."', '2', '".$data['NAME']."', '', '', '')"

		);

		

		$this->cache->delete('category'); */

	//	$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store ".

	//	" (`category_id`, `store_id`) VALUES ".

	///	"('".$category_id."', '0')"

	//	);

		

	//	$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '0'");

	}

 


        public function addProduct($data) {

 
			$flagsSerialized = $data['ON_WEB'].','.$data['NEW_ITEM'].','.$data['PREV_SEASON'].','.$data['NEXT_SEASON'].','.$data['COMING_SOON'].','.$data['PROMO'];
               
                $priceTotal = (float) str_replace(",",".",$data['price']); 
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET".

                         " model = '" . $this->db->escape($data['model'])     .  "', ".

                          " sku = '" . $this->db->escape($data['ItemExtra1'])  .  "', ".

                          " upc = '" . $this->db->escape($data['ItemExtra2'])  .  "', ".
                          " ean = '" . $this->db->escape($data['ItemExtra3'])  .  "', ".
						  
                          " jan = '" . $this->db->escape($flagsSerialized)  .  "', ".
						   " isbn = '" . $this->db->escape($data['WEB_DISCNT'])  .  "', ".
						  
                      //  $addManufacturerSql.
                        
                     
                      //  "', ean = '" . $this->db->escape($data['ean']) .

                      //  "', jan = '" . $this->db->escape($data['jan']) .

                     //   "', isbn = '" . $this->db->escape($data['isbn']) . 

                     //   "', mpn = '" . $this->db->escape($data['mpn']) . 

                       " location = '" . $this->db->escape($data['CCCIMAGE']) ."', ".
                       
                       " quantity = '" . (int)$data['TOTALBALANCE'] .  "', ". 

                     //   "', minimum = '" . (int)$data['minimum'] . 

                     //   "', subtract = '" . (int)$data['subtract'] .

                     //   "', stock_status_id = '" . (int)$data['stock_status_id'] . 

                     //   "', date_available = '" . $this->db->escape($data['date_available']) . 

                     //   "', manufacturer_id = '" . (int)$data['manufacturer_id'] . 

                     //   "', shipping = '" . (int)$data['shipping'] .

                       

                    //    "', showGeneralTab = '" . (int)$data['showGeneralTab'] .

                     //   "', showYoutubeTab = '" . (int)$data['showYoutubeTab'] .

                     //   "', showDownloadTab = '" . (int)$data['showDownloadTab'] .

                        

                        " price = '" . (float) $data['price'] . "', ". 

                     //   "', points = '" . (int)$data['points'] . 

                       " weight = '" . (float)$data['weight'] . "', ". 

                    //    "', weight_class_id = '" . (int)$data['weight_class_id'] . 

                    //    "', length = '" . (float)$data['length'] . 

                    //   "', width = '" . (float)$data['width'] . 

                    //    "', height = '" . (float)$data['height'] . 

                    //    "', length_class_id = '" . (int)$data['length_class_id'] . 

                        " status = '1', " . 

                        " tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', ". 

                    //    " sort_order = '" . (int)$data['sort_order'] . 

                        " date_added = NOW()");

                

		

		$product_id = $this->db->getLastId();

                 
        if (!file_exists(DIR_IMAGE .'catalog/'.$this->db->escape($data['model']) )) {
			mkdir(DIR_IMAGE .'catalog/'. $this->db->escape($data['model']), 0777, true);
	    }
		
        //Sync Images
        $PIMG = "catalog/images/".$data['ItemExtra1'].".jpg";
        $PIMGNew = "catalog/".$data['model']."/".$data['ItemExtra1'].".jpg";

        if (file_exists(DIR_IMAGE . $PIMG)) {
            if (copy(DIR_IMAGE . $PIMG, DIR_IMAGE . $PIMGNew)) {
                // copy( (DIR_IMAGE.$PIMG) , (DIR_IMAGE.$PIMGNew) ) ;
                $this->db->query("UPDATE " . DB_PREFIX . "product SET "
                . " image= '" . $this->db->escape(html_entity_decode($PIMGNew, ENT_QUOTES, 'UTF-8')) . "' "
                . " WHERE product_id = '" . (int)$product_id . "'");
            }
        }
				
		/*$queryR1 = $this->db->query(" SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID2'] ."'"  );
          
         if ($queryR1->num_rows > 0)
             {  
		     $filterId =    "( SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID2'] .  "' ) " ;
		     $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = " . $filterId . " ");				
             } */
                  

        /*      $queryR1 = $this->db->query(" SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID2'] ."'"  );
              if ($queryR1->num_rows > 0)
                    {        
                            $filterId =    "( SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID2'] .  "' ) " ;
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = " . $filterId . " ");	    
                    }			

               $queryR2 = $this->db->query(" SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID3'] ."'"  );

              if ($queryR2->num_rows > 0)
                    {      
                            $filterId =    "( SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID3'] .  "' ) " ;
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = " . $filterId . " ");	  
                    }	*/	
               
             
		 
       /*         
        $img_rel = "catalog/s1/".$data['ItemExtra3']."jjjjjj.jpg";
		$img_rel11 = "catalog/s1/".$data['ItemExtra3']."-1.jpg";
		 
        if (file_exists(DIR_IMAGE . $img_rel)) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET "
                         . " image= '" . $this->db->escape(html_entity_decode($img_rel, ENT_QUOTES, 'UTF-8')) . "' "
                         . " WHERE product_id = '" . (int)$product_id . "'");
                       
       } else if (file_exists(DIR_IMAGE . $img_rel11)) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET "
                         . " image= '" . $this->db->escape(html_entity_decode($img_rel11, ENT_QUOTES, 'UTF-8')) . "' "
                         . " WHERE product_id = '" . (int)$product_id . "'");
                       
       } 
       
       $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
  
  
        $img_rel1 = "catalog/s1/".$data['ItemExtra3']."-1.jpg";
        if (file_exists(DIR_IMAGE . $img_rel1)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel1, ENT_QUOTES, 'UTF-8')) . "', sort_order = '1'");
	    }
  
        $img_rel2 = "catalog/s1/".$data['ItemExtra3']."-2.jpg";
        if (file_exists(DIR_IMAGE . $img_rel2)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel2, ENT_QUOTES, 'UTF-8')) . "', sort_order = '2'");
	    }
		
        $img_rel3 = "catalog/s1/".$data['ItemExtra3']."-3.jpg";
        if (file_exists(DIR_IMAGE . $img_rel3)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel3, ENT_QUOTES, 'UTF-8')) . "', sort_order = '3'");
	    }
            
        $img_rel4 = "catalog/s1/".$data['ItemExtra3']."-4.jpg";
        if (file_exists(DIR_IMAGE . $img_rel4)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel4, ENT_QUOTES, 'UTF-8')) . "', sort_order = '4'");
	    }
         
        $img_rel5 = "catalog/s1/".$data['ItemExtra3']."-5.jpg";
        if (file_exists(DIR_IMAGE . $img_rel5)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel5, ENT_QUOTES, 'UTF-8')) . "', sort_order = '5'");
	    }
                */
                
                $newDCPrice =  (float)$data['price'] - (float)((float)$data['price'] *  ((float)$data['WEB_DISCNT']/(float)100));
                $newDCPrice4 =  (float)$data['PRICEW01'] - (float)((float)$data['PRICEW01'] *  ((float)$data['WEB_DISCNT']/(float)100));
            
                $priority = 0; 
               // $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
	            $queryCG = $this->db->query(" SELECT customer_group_id FROM " . DB_PREFIX . "customer_group where customer_group_id > 0"  );
	 
				foreach ($queryCG->rows as $result) {

                            if( (int)$result['customer_group_id']  == 4)  $curDCPrice = $newDCPrice4;
                            else $curDCPrice = $newDCPrice;


								$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET " .
                                        " product_id = '" . (int)$product_id . 
                                        "', customer_group_id = '" . (int)$result['customer_group_id'] . 
                                        "', priority = '" . (int)$priority . 
                                        "', price = '" . (float)$curDCPrice. //$data['WEB_DISCNT'] . 
                                        "', date_start = '0000-00-00', date_end = '0000-00-00' ");



                            if( (int)$result['customer_group_id']  == 4)  $curPrice = $data['PRICEW01'];
                            else $curPrice = $data['price'] ;
            
            
                                 $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET " .
                                        " product_id = '" . (int)$product_id . 
                                        "', customer_group_id = '" . (int)$result['customer_group_id'] . 
                                        "', quantity = '0" .
                                        "', priority = '" . (int)$priority . 
                                        "', price = '" . (float)$curPrice. //$data['WEB_DISCNT'] . 
                                        "', date_start = '0000-00-00', date_end = '0000-00-00' ");


					
                $priority++;
				}
			
				
                
/*
                $priority = 0; 

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		//if (isset($data['product_special'])) {

                        foreach ($data['PRICERPRC'] as $customer_group_softone_code => $value) {

                            

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET " .

                                        " product_id = '" . (int)$product_id . 

                                        "', customer_group_id = '" . (int)$customer_group_softone_code . 

                                        "', priority = '" . (int)$priority . 

                                        "', price = '" . (float)$value . 

                                        "', date_start = '0000-00-00', date_end = '0000-00-00' ");

                                

                                $priority++;

                                

			}

		//}
*/
                

                

               /* $this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_price WHERE product_id = '" . (int)$product_id . "'");

                

                foreach ($data['PRICERPRC'] as $customer_group_softone_code => $value) 

                    {

                       $this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_price SET "

                                . " product_id = '" . (int)$product_id . 

                                "', customer_group_id = '" .  $this->db->escape($customer_group_softone_code). 

                                "', price = '" . (double)$value . "'");

                    } */
                
                
                

                

		//if (isset($data['image'])) {

		//	$this->db->query("UPDATE " . DB_PREFIX . "product SET "

                //                . " image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "', "

                //                 . " image_banner = '" . $this->db->escape(html_entity_decode($data['image_banner'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");

		// }

		

                
				
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET "
                                . " product_id = '" . (int)$product_id . 
                                "', language_id = '" . (int) 1 . //$this->config->get('config_language_id'). 
                                "', name = '" . $this->db->escape($data['name']) . 
							    "', meta_title = '" . $this->db->escape($data['name']) . 
                                "', description = '" . $this->db->escape($data['descr']) . "'"
                        );
                
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET "
                                . " product_id = '" . (int)$product_id . 
                                "', language_id = '" . (int) 2 . //$this->config->get('config_language_id'). 
                                "', name = '" . $this->db->escape($data['name2']) . 
								"', meta_title = '" . $this->db->escape($data['name2']) . 
                                "', description = '" . $this->db->escape($data['descr2']) . "'"
                        );
                

                             //   "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . 

                            //    "', meta_description = '" . $this->db->escape($value['meta_description']) . 

                            //    "', description = '" . $this->db->escape($value['description']) . 

                            //    "',descriptionBanner = '" . $this->db->escape($value['descriptionBanner']) .

                            //    "',descriptionYoutube = '" . $this->db->escape($value['descriptionYoutube']) . 

                            //    "',descriptionDownload = '" . $this->db->escape($value['descriptionDownload']) . 

                            //    "',descriptionDownload_logged = '" . $this->db->escape($value['descriptionDownload_logged']) . 

                            //    "',descriptionYoutube_logged = '" . $this->db->escape($value['descriptionYoutube_logged']) . 

                          //      "', tag = '" . $this->db->escape($value['tag']) . "'");

                

                

	/*	foreach ($data['product_description'] as $language_id => $value) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET "

                                . " product_id = '" . (int)$product_id . 

                                "', language_id = '" . (int)$language_id . 

                                "', name = '" . $this->db->escape($value['name']) . 

                                "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . 

                            //    "', meta_description = '" . $this->db->escape($value['meta_description']) . 

                            //    "', description = '" . $this->db->escape($value['description']) . 

                            //    "',descriptionBanner = '" . $this->db->escape($value['descriptionBanner']) .

                            //    "',descriptionYoutube = '" . $this->db->escape($value['descriptionYoutube']) . 

                            //    "',descriptionDownload = '" . $this->db->escape($value['descriptionDownload']) . 

                            //    "',descriptionDownload_logged = '" . $this->db->escape($value['descriptionDownload_logged']) . 

                            //    "',descriptionYoutube_logged = '" . $this->db->escape($value['descriptionYoutube_logged']) . 

                                "', tag = '" . $this->db->escape($value['tag']) . "'"); 

		}*/

		

		//if (isset($data['product_store'])) {
			//foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0' ");
			//}
		//}



		/*if (isset($data['product_attribute'])) {

			foreach ($data['product_attribute'] as $product_attribute) {

				if ($product_attribute['attribute_id']) {

					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");

					}

				}

			}

		} */

	

		/*if (isset($data['product_option'])) {

			foreach ($data['product_option'] as $product_option) {

				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

				

					$product_option_id = $this->db->getLastId();

				

					if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0 ) {

						foreach ($product_option['product_option_value'] as $product_option_value) {

							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");

						} 

					}else{

						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");

					}

				} else { 

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");

				}

			}

		} */

		

		if (isset($data['SODISCOUNT'])) 
                    {
                    if($data['SODISCOUNT'] > 0)
                        {
                        $discountPrice= $priceTotal - ($priceTotal *($data['SODISCOUNT']/100));
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '1', quantity = '0', priority = '1', price = '" . (float)$discountPrice . "', date_start = '', date_end = ''");
                        }
                    }

                /*

		if (isset($data['product_special'])) {

			foreach ($data['product_special'] as $product_special) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");

			}

		}

		

		if (isset($data['product_image'])) {

			foreach ($data['product_image'] as $product_image) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");

			}

		}

		

		if (isset($data['product_download'])) {

			foreach ($data['product_download'] as $download_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");

			}

		} */

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = 20  ");
			
		//if (isset($data['CATEG_ID']) && $data['CATEG_ID'] != "-1"   ) { 
		//}
           
               /* if (isset($data['CATEG_ID2']) && $data['CATEG_ID2'] != "-1"   ) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id =  '".$data['CATEG_ID2']."' ");
		}
		
                if (isset($data['CATEG_ID3']) && $data['CATEG_ID3'] != "-1"   ) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '".$data['CATEG_ID3']."' ");
		}
		*/
		

		/*if (isset($data['product_category'])) {

			foreach ($data['product_category'] as $category_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");

			}

		}

		

		if (isset($data['product_filter'])) {

			foreach ($data['product_filter'] as $filter_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");

			}

		}

		*/

                /*

		if (isset($data['product_related'])) {

			foreach ($data['product_related'] as $related_id) {

				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");

				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");

			}

		}



		if (isset($data['product_reward'])) {

			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");

			}

		}



		if (isset($data['product_layout'])) {

			foreach ($data['product_layout'] as $store_id => $layout) {

				if ($layout['layout_id']) {

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");

				}

			}

		}

						

		if ($data['keyword']) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");

		}



		if (isset($data['product_profiles'])) {

			foreach ($data['product_profiles'] as $profile) {

				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_profile` SET `product_id` = " . (int) $product_id . ", customer_group_id = " . (int) $profile['customer_group_id'] . ", `profile_id` = " . (int) $profile['profile_id']);

			}

		} 

		*/

		$this->cache->delete('product');

	}



	public function editProduct($product_id, $data) {

           /* $addManufacturerSql = "";
           
		   
               if (isset($data['CATEG_ID2']) && $data['CATEG_ID2'] != "-1" && $data['CATEG_ID2'] != "" && $data['CATEG_ID2'] != " "   ) {
                  
                $queryR1 = $this->db->query(" SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE sort_order = '" . $data['CATEG_ID2'] ."'"  );
             
                if ($queryR1->num_rows > 0)
                    {   
                    $addManufacturerSql =    " manufacturer_id =  ( SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE sort_order = '" . $data['CATEG_ID2'] .  "' ), " ;
                    }
               }     */
                 
                    
              // $priceMain = (float) str_replace(",",".",$data['price']); 
             //   $priceExtra1 = (float) str_replace(",",".",$data['EXPVAL1']); 
              //  $priceExtra2 = (float) str_replace(",",".",$data['EXPVAL2']); 
              //  $priceExtra3 = (float) str_replace(",",".",$data['EXPVAL3']); 
              //  $priceTotal = $priceMain + $priceExtra1 + $priceExtra2 + $priceExtra3;
			  
            	$flagsSerialized = $data['ON_WEB'].','.$data['NEW_ITEM'].','.$data['PREV_SEASON'].','.$data['NEXT_SEASON'].','.$data['COMING_SOON'].','.$data['PROMO'];
               
						   
						   
             $priceTotal = (float) str_replace(",",".",$data['price']); 
		$this->db->query("UPDATE " . DB_PREFIX . "product SET " .

                        " model = '" . $this->db->escape($data['model']) . 

                        "', sku = '" . $this->db->escape($data['ItemExtra1']) . 

                        "', upc = '" . $this->db->escape($data['ItemExtra2']) . "', ".
                        
                        " ean = '" . $this->db->escape($data['ItemExtra3'])  .  "', ".       
                        " jan = '" . $this->db->escape($flagsSerialized)  .  "', ".
					    " isbn = '" . $this->db->escape($data['WEB_DISCNT'])  .  "', ".

                        " price = " . (float) $data['price'] . "  ".

             

                        ", weight = '" . (float)$data['weight'] . 

                        "', quantity = '" . (int)$data['TOTALBALANCE'] . 
                        "', location = '" . $this->db->escape($data['CCCIMAGE']) . 
             

                      //  "', status = '" . (int)1 .

                        "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . 

              

                        "', date_modified = NOW() " .

                        " WHERE model = '" . $this->db->escape($data['model']) . "'");

		/*				
     $queryR1 = $this->db->query(" SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID2'] ."'"  );
         $queryR1Exec = 0;
         if ($queryR1->num_rows > 0)
             {      
		     $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "' ");
		     $filterId =    "( SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID2'] .  "' ) " ;
		     $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = " . $filterId . " ");	
                     $queryR1Exec = 1;
             }			
						
	$queryR2 = $this->db->query(" SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID3'] ."'"  );
        
         if ($queryR2->num_rows > 0)
             {      
		    if($queryR1Exec == 1) $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "' ");
		     $filterId =    "( SELECT filter_id FROM " . DB_PREFIX . "filter WHERE sort_order = '" . $data['CATEG_ID3'] .  "' ) " ;
		     $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = " . $filterId . " ");	  
             }	*/					
						
      

    //Sync Images
    $PIMG = "catalog/images/".$data['ItemExtra1'].".jpg";
    $PIMGNew = "catalog/".$data['model']."/".$data['ItemExtra1'].".jpg";

    if (file_exists(DIR_IMAGE . $PIMG)) {
        if (copy(DIR_IMAGE . $PIMG, DIR_IMAGE . $PIMGNew)) {
            // copy( (DIR_IMAGE.$PIMG) , (DIR_IMAGE.$PIMGNew) ) ;
            $this->db->query("UPDATE " . DB_PREFIX . "product SET "
            . " image= '" . $this->db->escape(html_entity_decode($PIMGNew, ENT_QUOTES, 'UTF-8')) . "' "
            . " WHERE product_id = '" . (int)$product_id . "'");
        }
    }

    /*$qrProductImages = $this->db->query(" SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . $product_id ."'"  );
    
    foreach ($qrProductImages as $product_image) {
        
    $imgCurCounter = "";
    if($product_image['imgCounter']<10)  $imgCurCounter = "0".$product_image['imgCounter'];
    else $imgCurCounter = "".$product_image['imgCounter'];

    $PIMG = "catalog/images/".$data['ItemExtra1']."-".$product_image['imgLbl']."-".$imgCurCounter."jpg";
    $PIMGNew = "catalog/".$data['model']."/".$data['ItemExtra1']."-".$product_image['imgLbl']."-".$imgCurCounter."jpg";

    if (file_exists(DIR_IMAGE . $PIMG)) {
        if (copy(DIR_IMAGE . $PIMG, DIR_IMAGE . $PIMGNew)) {

            $this->db->query("UPDATE " . DB_PREFIX . "product_image ".
                " SET ".
                " image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "' ".
                " where product_id = '" . (int)$product_id . "' ".
                " and 	product_image_id = '".(int)$product_image['product_image_id'] . "'"
            );
        }
    }*/

  



/*
		$img_rel11 = "catalog/s1/".$data['ItemExtra3']."jjjj-1.jpg";
        $img_rel = "catalog/s1/".$data['ItemExtra3'].".jpg";
		
        $this->db->query("UPDATE " . DB_PREFIX . "product SET "
                         . " image= '" . $this->db->escape(html_entity_decode($img_rel, ENT_QUOTES, 'UTF-8')) . "' "
                         . " WHERE product_id = '" . (int)$product_id . "'");
                       
	   if (file_exists(DIR_IMAGE . $img_rel11)) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET "
                         . " image= '" . $this->db->escape(html_entity_decode($img_rel11, ENT_QUOTES, 'UTF-8')) . "' "
                         . " WHERE product_id = '" . (int)$product_id . "'");          
       } 
       
      
  
    
        $img_rel1 = "catalog/s1/".$data['ItemExtra3']."-1.jpg";
        if (file_exists(DIR_IMAGE . $img_rel1)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel1, ENT_QUOTES, 'UTF-8')) . "', sort_order = '1'");
	    }
  
  
        $img_rel2 = "catalog/s1/".$data['ItemExtra3']."-2.jpg";
        if (file_exists(DIR_IMAGE . $img_rel2)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel2, ENT_QUOTES, 'UTF-8')) . "', sort_order = '2'");
	    }
		
        $img_rel3 = "catalog/s1/".$data['ItemExtra3']."-3.jpg";
        if (file_exists(DIR_IMAGE . $img_rel3)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel3, ENT_QUOTES, 'UTF-8')) . "', sort_order = '3'");
	    }
            
        $img_rel4 = "catalog/s1/".$data['ItemExtra3']."-4.jpg";
        if (file_exists(DIR_IMAGE . $img_rel4)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel4, ENT_QUOTES, 'UTF-8')) . "', sort_order = '4'");
	    }
         
        $img_rel5 = "catalog/s1/".$data['ItemExtra3']."-5.jpg";
        if (file_exists(DIR_IMAGE . $img_rel5)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($img_rel5, ENT_QUOTES, 'UTF-8')) . "', sort_order = '5'");
	    }*/
            
		
		
	  /*  $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		if ($data['name'] != '' ) {
				$keyword = $product_id .'-'. $data['name'];
				$keyword = str_replace(" ", "-", $keyword);
				$keyword = str_replace("?", "-", $keyword);
				$keyword = str_replace("/", "-", $keyword);
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($keyword) . "'");
		} */
        	
			
			
            
		//if (isset($data['image'])) {
		//	$this->db->query("UPDATE " . DB_PREFIX . "product SET "
                //               . " image_banner = '" . $this->db->escape(html_entity_decode($data['image_banner'], ENT_QUOTES, 'UTF-8')) . "' "
                //             . " WHERE product_id = '" . (int)$product_id . "'");
                //	}

		
          //  if($data['UpdateTitle'] == "1")
            //{
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET "
                                . " product_id = '" . (int)$product_id . 
                                "', language_id = '" . (int) 1 . //$this->config->get('config_language_id'). 
                                "', name = '" . $this->db->escape($data['name']) . 
								"', meta_title = '" . $this->db->escape($data['name']) .
                                "', description = '" . $this->db->escape($data['descr']) . "'"
                        );
                
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET "
                                . " product_id = '" . (int)$product_id . 
                                "', language_id = '" . (int) 2 . //$this->config->get('config_language_id'). 
                                "', name = '" . $this->db->escape($data['name2']) . 
								"', meta_title = '" . $this->db->escape($data['name2']) . 
                                "', description = '" . $this->db->escape($data['descr2']) . "'"
                        );
           // }
            
            
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
 		if (isset($data['SODISCOUNT'])) 
                    {
                    if($data['SODISCOUNT'] > 0)
                        {
                        $discountPrice= $priceTotal - ($priceTotal *($data['SODISCOUNT']/100));
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '1', quantity = '0', priority = '1', price = '" . (float)$discountPrice . "', date_start = '', date_end = ''");
                        }
                    }
            
			
			
            
            
	//	foreach ($data['product_description'] as $language_id => $value) {

	//		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description "

         //                       . " SET product_id = '" . (int)$product_id . 

        //                        "', language_id = '" . (int)$language_id . 

         //                       "', name = '" . $this->db->escape($value['name']) . 

        //                        "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . 

         //                       "', meta_description = '" . $this->db->escape($value['meta_description']) . 

         //                       "', description = '" . $this->db->escape($value['description']) . 

         //                       "', descriptionBanner = '" . $this->db->escape($value['descriptionGeneral']) . 

         //                       "',descriptionYoutube = '" . $this->db->escape($value['descriptionYoutube']) . 

        //                        "',descriptionDownload = '" . $this->db->escape($value['descriptionDownload']) . 

         //                       "',descriptionDownload_logged = '" . $this->db->escape($value['descriptionDownload_logged']) . 

        //                        "',descriptionYoutube_logged = '" . $this->db->escape($value['descriptionYoutube_logged']) . 

         //                       "', tag = '" . $this->db->escape($value['tag']) . "'");

	//	}



               // echo "INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', descriptionBanner = '" . $this->db->escape($value['descriptionBanner']) . "', tag = '" . $this->db->escape($value['tag']) . "'";

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");


		//if (isset($data['product_store'])) {
			//foreach ($data['product_store'] as $store_id) {
		//		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $product_id . "', store_id = '0'");
			//}
		//} 

		

		/* $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");



		if (!empty($data['product_attribute'])) {

			foreach ($data['product_attribute'] as $product_attribute) {

				if ($product_attribute['attribute_id']) {

					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				

						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");

					}

				}

			}

		} */



		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

		

		/* if (isset($data['product_option'])) {

			foreach ($data['product_option'] as $product_option) {

				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

				

					$product_option_id = $this->db->getLastId();

				

					if (isset($product_option['product_option_value'])  && count($product_option['product_option_value']) > 0 ) {

						foreach ($product_option['product_option_value'] as $product_option_value) {

							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");

						}

					}else{

						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");

					}

				} else { 

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");

				}					

			}

		} */

		/* if (isset($data['product_discount'])) {

			foreach ($data['product_discount'] as $product_discount) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");

			}

		} */

		

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		

		/* if (isset($data['product_special'])) {

			foreach ($data['product_special'] as $product_special) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");

			}

		} */

		

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		

		/* if (isset($data['product_image'])) {

			foreach ($data['product_image'] as $product_image) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");

			}

		} */

		

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		

		/*if (isset($data['product_download'])) {

			foreach ($data['product_download'] as $download_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");

			}

		} */

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = 20  ");
			
		
		//if (isset($data['CATEG_ID']) && $data['CATEG_ID'] != "-1"   ) {
		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE softone_code = '".$data['CATEG_ID']."' ");
		//foreach ($query->rows as $result) 
		//     {	   
		//		 $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '".$data['CATEG_ID']."'  ");
		//     }		 
		//}
           
		
		//if (isset($data['CATEG_ID']) && $data['CATEG_ID'] != "-1"   ) {
        //            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '".$data['CATEG_ID']."'  ");
		//}

                /*
        if (isset($data['CATEG_ID2']) && $data['CATEG_ID2'] != "-1"   ) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '".$data['CATEG_ID2']."'  ");
		}
		
        if (isset($data['CATEG_ID3']) && $data['CATEG_ID3'] != "-1"   ) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '".$data['CATEG_ID3']."'  ");
		}
		*/

		/* if (isset($data['product_category'])) {

			foreach ($data['product_category'] as $category_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");

			}		

		} */

		

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		

		/* if (isset($data['product_filter'])) {

			foreach ($data['product_filter'] as $filter_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");

			}		

		} */

		

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");



		/* if (isset($data['product_related'])) {

			foreach ($data['product_related'] as $related_id) {

				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");

				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");

			}

		} */

		

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

/*

		if (isset($data['product_reward'])) {

			foreach ($data['product_reward'] as $customer_group_id => $value) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");



		if (isset($data['product_layout'])) {

			foreach ($data['product_layout'] as $store_id => $layout) {

				if ($layout['layout_id']) {

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");

				}

			}

		}

  					

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");

		

		if ($data['keyword']) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");

		}

						

		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_profile` WHERE product_id = " . (int) $product_id);		

                if (isset($data['product_profiles'])) {		

                    foreach ($data['product_profiles'] as $profile) {	

                        $this->db->query("INSERT INTO `" . DB_PREFIX . "product_profile` SET `product_id` = " . (int) $product_id . ", customer_group_id = " . (int) $profile['customer_group_id'] . ", `profile_id` = " . (int) $profile['profile_id']);			

                        }		

                    

                    }		

               */


                $newDCPrice =  (float)$data['price'] - (float)((float)$data['price'] *  ((float)$data['WEB_DISCNT']/(float)100));
                $newDCPrice4 =  (float)$data['PRICEW01'] - (float)((float)$data['PRICEW01'] *  ((float)$data['WEB_DISCNT']/(float)100));
		        $priority = 0; 
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
	            $queryCG = $this->db->query(" SELECT customer_group_id FROM " . DB_PREFIX . "customer_group where customer_group_id > 0"  );
	 
				foreach ($queryCG->rows as $result) {


                    if( (int)$result['customer_group_id']  == 4)  $curDCPrice = $newDCPrice4;
                    else $curDCPrice = $newDCPrice;

								$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET " .
                                        " product_id = '" . (int)$product_id . 
                                        "', customer_group_id = '" . (int)$result['customer_group_id'] . 
                                        "', priority = '" . (int)$priority . 
                                        "', price = '" . (float)$curDCPrice. //$data['WEB_DISCNT'] . 
                                        "', date_start = '0000-00-00', date_end = '0000-00-00' ");


                    if( (int)$result['customer_group_id']  == 4)  $curPrice = $data['PRICEW01'];
                    else $curPrice = $data['price'] ;
                        
                        
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET " .
                                        " product_id = '" . (int)$product_id . 
                                         "', customer_group_id = '" . (int)$result['customer_group_id'] . 
                                        "', quantity = '0" .
                                        "', priority = '" . (int)$priority . 
                                        "', price = '" . (float)$curPrice. 
                                        "', date_start = '0000-00-00', date_end = '0000-00-00' ");

					
				$priority++;		
				}
						
		
                    
/*
                $priority = 0; 

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		//if (isset($data['product_special'])) {

			foreach ($data['PRICERPRC'] as $customer_group_softone_code => $value) {

                            

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET " .

                                        " product_id = '" . (int)$product_id . 

                                        "', customer_group_id = '" . (int)$this->db->escape($customer_group_softone_code).

                                        "', priority = '" . (int)$priority . 

                                        "', price = '" . (double) $value . 

                                        "', date_start = '0000-00-00', date_end = '0000-00-00' ");

                                

                                $priority++;

                                

			}
*/
		//}

                

                

               /* $this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_price WHERE product_id = '" . (int)$product_id . "'");

                

                foreach ($data['PRICERPRC'] as $customer_group_softone_code => $value) 

                    {

                        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_price SET "

                                . " product_id = '" . (int)$product_id . 

                                "', customer_group_id = '" .  $this->db->escape($customer_group_softone_code). 

                                "', price = '" . (double) $value . "'");

                    } */

                

                

             $this->cache->delete('product');

	

                

            }

	

            

        public function deleteProduct($product_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int) $product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");

	//	$this->db->query("DELETE FROM `" . DB_PREFIX . "product_profile` WHERE `product_id` = " . (int) $product_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");

		

	//	$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");

		

		$this->cache->delete('product');

	}

	

            

            

            

            

            

	public function copyProduct($product_id) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		

		if ($query->num_rows) {

			$data = array();

			

			$data = $query->row;

			

			$data['sku'] = '';

			$data['upc'] = '';

			$data['viewed'] = '0';

			$data['keyword'] = '';

			$data['status'] = '0';

						

			$data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));

			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			

			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));

			$data = array_merge($data, array('product_filter' => $this->getProductFilters($product_id)));

			$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));		

			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));

			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));

			$data = array_merge($data, array('product_reward' => $this->getProductRewards($product_id)));

			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));

			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));

			$data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));

			$data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));

			$data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));

			$data = array_merge($data, array('product_profiles' => $this->getProfiles($product_id)));

			$this->addProduct($data);

		}

	}

	

	public function getProduct($product_id) {

		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				

		return $query->row;

	}

	

	public function getProducts($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		

		if (!empty($data['filter_category_id'])) {

			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			

		}

				

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 

		

		if (!empty($data['filter_name'])) {

			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";

		}



		if (!empty($data['filter_model'])) {

			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";

		}

		

		if (!empty($data['filter_price'])) {

			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";

		}

		

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {

			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";

		}

		

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {

			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";

		}

		

		$sql .= " GROUP BY p.product_id";

					

		$sort_data = array(

			'pd.name',

			'p.model',

			'p.price',

			'p.quantity',

			'p.status',

			'p.sort_order'

		);	

		

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {

			$sql .= " ORDER BY " . $data['sort'];	

		} else {

			$sql .= " ORDER BY pd.name";	

		}

		

		if (isset($data['order']) && ($data['order'] == 'DESC')) {

			$sql .= " DESC";

		} else {

			$sql .= " ASC";

		}

	

		if (isset($data['start']) || isset($data['limit'])) {

			if ($data['start'] < 0) {

				$data['start'] = 0;

			}				



			if ($data['limit'] < 1) {

				$data['limit'] = 20;

			}	

		

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

		}	

		

		$query = $this->db->query($sql);

	

		return $query->rows;

	}

	

	public function getProductsByCategoryId($category_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

								  

		return $query->rows;

	} 

	

	public function getProductDescriptions($product_id) {

		$product_description_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_description_data[$result['language_id']] = array(

				'name'             => $result['name'],

				'description'      => $result['description'],

                                'descriptionGeneral'      => $result['descriptionBanner'],

                                'descriptionYoutube'      => $result['descriptionYoutube'],

                                'descriptionDownload'      => $result['descriptionDownload'],   

                                'descriptionDownload_logged'      => $result['descriptionDownload_logged'],

                                'descriptionYoutube_logged'      => $result['descriptionYoutube_logged'],

				'meta_keyword'     => $result['meta_keyword'],

				'meta_description' => $result['meta_description'],

				'tag'              => $result['tag']

			);

		}

		

		return $product_description_data;

	}

		

	public function getProductCategories($product_id) {

		$product_category_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_category_data[] = $result['category_id'];

		}



		return $product_category_data;

	}

	

	public function getProductFilters($product_id) {

		$product_filter_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_filter_data[] = $result['filter_id'];

		}

				

		return $product_filter_data;

	}

	

	public function getProductAttributes($product_id) {

		$product_attribute_data = array();

		

		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");

		

		foreach ($product_attribute_query->rows as $product_attribute) {

			$product_attribute_description_data = array();

			

			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

			

			foreach ($product_attribute_description_query->rows as $product_attribute_description) {

				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);

			}

			

			$product_attribute_data[] = array(

				'attribute_id'                  => $product_attribute['attribute_id'],

				'product_attribute_description' => $product_attribute_description_data

			);

		}

		

		return $product_attribute_data;

	}

	

	public function getProductOptions($product_id) {

		$product_option_data = array();

		

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		

		foreach ($product_option_query->rows as $product_option) {

			$product_option_value_data = array();	

				

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

				

			foreach ($product_option_value_query->rows as $product_option_value) {

				$product_option_value_data[] = array(

					'product_option_value_id' => $product_option_value['product_option_value_id'],

					'option_value_id'         => $product_option_value['option_value_id'],

					'quantity'                => $product_option_value['quantity'],

					'subtract'                => $product_option_value['subtract'],

					'price'                   => $product_option_value['price'],

					'price_prefix'            => $product_option_value['price_prefix'],

					'points'                  => $product_option_value['points'],

					'points_prefix'           => $product_option_value['points_prefix'],						

					'weight'                  => $product_option_value['weight'],

					'weight_prefix'           => $product_option_value['weight_prefix']					

				);

			}

				

			$product_option_data[] = array(

				'product_option_id'    => $product_option['product_option_id'],

				'option_id'            => $product_option['option_id'],

				'name'                 => $product_option['name'],

				'type'                 => $product_option['type'],			

				'product_option_value' => $product_option_value_data,

				'option_value'         => $product_option['option_value'],

				'required'             => $product_option['required']				

			);

		}

		

		return $product_option_data;

	}

			

	public function getProductImages($product_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		

		return $query->rows;

	}

	

	public function getProductDiscounts($product_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

		

		return $query->rows;

	}

	

	public function getProductSpecials($product_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		

		return $query->rows;

	}

	

	public function getProductRewards($product_id) {

		$product_reward_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);

		}

		

		return $product_reward_data;

	}

		

	public function getProductDownloads($product_id) {

		$product_download_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_download_data[] = $result['download_id'];

		}

		

		return $product_download_data;

	}



	public function getProductStores($product_id) {

		$product_store_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");



		foreach ($query->rows as $result) {

			$product_store_data[] = $result['store_id'];

		}

		

		return $product_store_data;

	}



	public function getProductLayouts($product_id) {

		$product_layout_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_layout_data[$result['store_id']] = $result['layout_id'];

		}

		

		return $product_layout_data;

	}



	public function getProductRelated($product_id) {

		$product_related_data = array();

		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		

		foreach ($query->rows as $result) {

			$product_related_data[] = $result['related_id'];

		}

		

		return $product_related_data;

	}



	public function getProfiles($product_id) {

		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_profile` WHERE product_id = " . (int) $product_id)->rows;

	}



	public function getTotalProducts($data = array()) {

		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";



		if (!empty($data['filter_category_id'])) {

			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			

		}

		 

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		 			

		if (!empty($data['filter_name'])) {

			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";

		}



		if (!empty($data['filter_model'])) {

			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";

		}

		

		if (!empty($data['filter_price'])) {

			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";

		}

		

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {

			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";

		}

		

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {

			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";

		}

		

		$query = $this->db->query($sql);

		

		return $query->row['total'];

	}	

	

	public function getTotalProductsByTaxClassId($tax_class_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");



		return $query->row['total'];

	}

		

	public function getTotalProductsByStockStatusId($stock_status_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");



		return $query->row['total'];

	}

	

	public function getTotalProductsByWeightClassId($weight_class_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");



		return $query->row['total'];

	}

	

	public function getTotalProductsByLengthClassId($length_class_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");



		return $query->row['total'];

	}



	public function getTotalProductsByDownloadId($download_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");

		

		return $query->row['total'];

	}

	

	public function getTotalProductsByManufacturerId($manufacturer_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");



		return $query->row['total'];

	}

	

	public function getTotalProductsByAttributeId($attribute_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");



		return $query->row['total'];

	}	

	

	public function getTotalProductsByOptionId($option_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");



		return $query->row['total'];

	}	

	

	public function getTotalProductsByLayoutId($layout_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");



		return $query->row['total'];

	}

}

?>