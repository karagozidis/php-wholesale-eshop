<?php 
class ControllerSoftoneProduct extends Controller {
	
public function UpdateProductImages()
{
 	$this->load->model('softone/product');
	$customer_exists = $this->model_softone_product->checkIfExists($this->request->post['CODE']);
    if ($customer_exists)
            {
            $this->model_softone_product->UpdateProductImages($customer_exists["product_id"],$this->request->post);
			}	
}
	
public function SyncRelatedProducts() {
        $json = array();	
        $this->load->model('softone/product');

	    $this->model_softone_product->SyncRelatedProducts($this->request->post);
      
        $json = array(
                     'actions' => "Τα σχετικά προιόντα έχουν συσχετηστεί με το είδος."
                     );
						
        $this->response->setOutput(json_encode($json));       
	}    
	
	
public function SyncOption() {
        $json = array();	
        $this->load->model('softone/product');

	    $this->model_softone_product->deleteOption($this->request->post);
        $this->model_softone_product->addOption($this->request->post);
	    $this->model_softone_product->addOptionOnProduct($this->request->post);
	
	    $this->model_softone_product->DeleteProductFilters($this->request->post);
	    $this->model_softone_product->addFilterColors($this->request->post);
	    $this->model_softone_product->addFilterGeneralColors($this->request->post);
        $this->model_softone_product->addFiltersSizes($this->request->post);
	    $this->model_softone_product->addFilterGeneralSizes($this->request->post);
	
	
	    $this->model_softone_product->UpdateProductColorImages($this->request->post);
	
	
        $json = array(
                     'actions' => "Τα χαρακτηριστικά του είδους ενημερώθηκαν στο Web."
                     );
						
        $this->response->setOutput(json_encode($json));       
	}    
    
    
public function SyncOptionQty() {
        $json = array();	
        $this->load->model('softone/product');

        //foreach ($this->request->post['QTYS'] as $softone_code => $value) 
        //    {
            $this->model_softone_product->updateOptionQty($this->request->post);
       //     }                               
			
            $json = array(
                        'actions' => "Τα αποθέματα των χαρακτηριστικών ενημερώθηκαν στο Web."
                        );
						
            $this->response->setOutput(json_encode($json));       
	}	 
    
     
public function SyncQty() {
        $json = array();	
        $this->load->model('softone/product');

        foreach ($this->request->post['QTYS'] as $softone_code => $value) 
            {
            $this->model_softone_product->updateQty($softone_code ,$value );
            } 
			
            $json = array(
                        'actions' => "0"
                        );
						
            $this->response->setOutput(json_encode($json));       
	}	 
    
    
		 
public function Sync() {
        $json = array();	
       
        $this->load->model('softone/product');
        $PRICERPRC = array();
        $this->load->model('softone/customer_group');

        if(isset($this->request->post['PRICERPRC']))
        foreach ($this->request->post['PRICERPRC'] as $customer_group_softone_code => $value) 
            {
            $customer_group_exists = $this->model_softone_customer_group->checkIfExists($customer_group_softone_code);

            if ($customer_group_exists)
                    {
                    $PRICERPRC[$customer_group_exists['customer_group_id'] ] =  $value ;
                    }
            }
	
	    $qty1 = 0;
        if($this->request->post['QTY'] < 0 )
			$qty1 = 0; 
	    else $qty1 = $this->request->post['QTY'];
			
        $data = array(
                'model' => $this->request->post['CODE'],
			    'CODE' => $this->request->post['CODE'],
                'name' => $this->request->post['NAME'],
                'name2' => $this->request->post['NAME2'],
                'descr' => $this->request->post['DESCR'],
                'descr2' => $this->request->post['DESCR2'],
                'price' => $this->request->post['PRICE'],
			    'PRICEW01' => $this->request->post['PRICEW01'],
                'PRICERPRC' => $PRICERPRC,
                'CATEG_ID'  => $this->request->post['CATEG_ID'],
			    'MTRCATEGORYNAME'  => $this->request->post['MTRCATEGORYNAME'],
			    'TOTALBALANCE'  => $this->request->post['TOTALBALANCE'],
                'CATEG_ID2'  => '',// $this->request->post['CATEG_ID2'],
                'CATEG_ID3'  => '', //$this->request->post['CATEG_ID3'],
				'quantity'  => $qty1,
				'UpdateDescr' => $this->request->post['UpdateDescr'],
				'UpdateTitle' => $this->request->post['UpdateTitle'],
				'weight' => '0' ,
				'tax_class_id' => '9',
				'ItemExtra1' => $this->request->post['ItemExtra1'],
                'ItemExtra2' => $this->request->post['ItemExtra2'],
                'ItemExtra3' => $this->request->post['ItemExtra3'],
			    'ON_WEB' => $this->request->post['ON_WEB'],
			    'NEW_ITEM' => $this->request->post['NEW_ITEM'],
				'PREV_SEASON' => $this->request->post['PREV_SEASON'],
				'NEXT_SEASON' => $this->request->post['NEXT_SEASON'],
				'COMING_SOON' => $this->request->post['COMING_SOON'],
				'PROMO' => $this->request->post['PROMO'],
                'WEB_DISCNT' => $this->request->post['WEB_DISCNT'],
                'MTRLCODE' => $this->request->post['MTRLCODE'],
                'CCCIMAGE' => $this->request->post['CCCIMAGE']
            );
        
        $product_exists = $this->model_softone_product->checkIfExists($this->request->post['CODE']);
 
            if ($product_exists)
                    {
                    $this->model_softone_product->editProduct($product_exists["product_id"],$data);
				 
				    $this->model_softone_product->DeleteProductFiltersOnly5($data);
					$this->model_softone_product->UpdateProductCategoryFilter($data);
				    $this->model_softone_product->UpdateProductCategoryFlagFilters($data);
				
                    if(  $this->request->post['QTY'] != "-30000")
   
                    $json = array(
                        'actions' => "Τα στοιχεία του είδους ενημερώθηκαν στο Web."
                        );
                    $this->response->setOutput(json_encode($json));
                    }
			else 
                    {
                    $this->model_softone_product->addProduct($data);
			
				    $this->model_softone_product->DeleteProductFiltersOnly5($data);
                    $this->model_softone_product->UpdateProductCategoryFilter($data);
				    $this->model_softone_product->UpdateProductCategoryFlagFilters($data);
				
                    $json = array(
					'actions' => "Το είδος άνοιξε στο Web."
                        );
                    $this->response->setOutput(json_encode($json));
                    }
		

	}


	

	public function SyncImage() {

        $json = array();	

        $this->load->model('softone/product');

		

      //  $product_exists = $this->model_softone_product->checkIfExists($this->request->post['CODE']);

     //   $this->model_softone_product->editProductImage($this->request->post['CODE'],$this->request->post['Url']);

        $json = array(

		'actions' => "0"

        );

        $this->response->setOutput(json_encode($json));            

	}

	

	

	public function SyncCategory() {

	

        $json = array();	

        $this->load->model('softone/product');

       

        $this->load->model('softone/customer_group');



        $data = array(

                'MTRGROUP' => $this->request->post['MTRGROUP'],

                'NAME' => $this->request->post['NAME']

            );



        $categ_exists = $this->model_softone_product->checkIfCategExists($this->request->post['MTRGROUP']);



                if ($categ_exists)

                    {

                    $this->model_softone_product->editCategory($categ_exists["category_id"] , $data);

					//  $this->model_softone_product->addCategory($data);

                    $json = array(

					'actions' => "0"

                        );

                    $this->response->setOutput(json_encode($data));

                    }

				else 

                    {

                    $this->model_softone_product->addCategory($data);

                    $json = array(

					'actions' => "1"

                        );

                    $this->response->setOutput(json_encode($json));

                    }

	}

	



   public function getPId() {

        $json = array();	

        $this->load->model('softone/product');

        $product_id = $this->model_softone_product->getIdByModel($this->request->post['CODE']);

         if (isset($product_id['product_id']) )

            {

			 $json = array(

					'actions' => $product_id['product_id']

                        );

            $this->response->setOutput(json_encode($json));

            }

         else 

            {

			$json = array(

					'actions' => "-1"

                        );

            $this->response->setOutput(json_encode($json));

            }

	}

   

   

    

public function delete() {

        $json = array();	

        $this->load->model('softone/product');

        

         $customer_exists = $this->model_softone_product->checkIfExists($this->request->post['CODE']);

         

         if (!$customer_exists)

            {

            $json = array('actions' => "Δεν βρέθηκε το είδος στο Web.");

            $this->response->setOutput(json_encode($json));

            }

         else 

            {

            $product_id = $this->model_softone_product->getIdByModel($this->request->post['CODE']);

            $this->model_softone_product->deleteProduct($product_id['product_id']);

            $json = array('actions' => "Tο είδος έχει διαγραφεί απο το Web.") ;

            $this->response->setOutput(json_encode($json));

            }  

	}

        

        

      public function isActiveCustomer() {

        $json = array();	

        $this->load->model('softone/customer');

        

         $customer_active = $this->model_softone_customer->checkIfActive($this->request->post['CODE']);

         if (isset($customer_active['status']) )

            {

            if ($customer_active['status'] == 0)

                {

                $json = array('actions' => "0");

                $this->response->setOutput(json_encode($json));

                }

             else 

                {

                $json = array('actions' => "1") ;

                $this->response->setOutput(json_encode($json));

                }

            }

         else 

            {

            $json = array('actions' => "2") ;

            $this->response->setOutput(json_encode($json));

            }

           

	}

        

        

	public function activate() {

        $json = array();	

        $this->load->model('softone/product');

        

         $active = $this->model_softone_product->checkIfActive($this->request->post['CODE']);

         if (isset($active['status']) )
            {
            if ($active['status'] == 0)
                {
                $this->model_softone_product->activate($this->request->post['CODE']);
                $json = array('actions' => "Το είδος ενεργοποιήθηκε στο Web.") ;
                $this->response->setOutput(json_encode($json));
                }
             else 
                {
                $this->model_softone_product->deActivate($this->request->post['CODE']);
                $json = array('actions' => "Το είδος απενεργοποιήθηκε απο το Web.") ;
                $this->response->setOutput(json_encode($json));
                }
            }

         else 
            {
            $json = array('actions' => "Το είδος δεν υπάρχει στο Web.") ;
            $this->response->setOutput(json_encode($json));
            }

           

	}

        

	public function connectToProduct() {
        $json = array();	
        $this->load->model('softone/product');
          
        $this->model_softone_product->connectToProduct($this->request->post['ITEM_ID'],$this->request->post['CODE']);
        $json = array('actions' => "1") ;
        $this->response->setOutput(json_encode($json));    
	}

		  

	public function getProducts() {
        $json = array();	
        $this->load->model('softone/product');


		 $data = array(
			'filter_category_id'              => null, 
			'filter_name'             => null, 
			'filter_model' => null, 
			'filter_price'            => null, 
			'filter_quantity'          => null, 
			'filter_status'        => null,
			'sort'                     => 'name',
			'order'                    => 'ASC',
			'start'                    => 0,
			'limit'                    => 10000
		);


		$results = $this->model_softone_product->getProducts($data);

        $this->response->setOutput(json_encode($results));

	}
          
        

}

?>