<?php 
class ControllerSoftoneCustomer extends Controller {
	
public function relatedHistory(){

	$json = array();
	$this->load->model('softone/customer');
	$this->model_softone_customer->createRelatedCustomers($this->request->post);
                              
            $json = array(
                        'actions' => "Επιτυχής συγχρονισμός Related Customers."
                        );
						
            $this->response->setOutput(json_encode($json));
}
	     
public function orderHistory() {
        $json = array();	
        $this->load->model('softone/customer');

   
            $this->model_softone_customer->createOrderHistory($this->request->post);
                              
			
            $json = array(
                        'actions' => "H καρτέλα του πελάτη δημιουργήθηκε."
                        );
						
            $this->response->setOutput(json_encode($json));       
	}		
	
public function Sync() {
	
        $json = array();	
        //$this->load->model('localisation/country');
        $this->load->model('softone/customer');
        $this->load->model('softone/customer_group');
        
        
         $customer_group_exists = $this->model_softone_customer_group->checkIfExists($this->request->post['PRCCATEGORY']);
        
         if ($customer_group_exists)
                    {
                    $cg_id = $customer_group_exists['customer_group_id'];
                    }
        else
                    {
                    $cg_id = 1;
                    }
        
        
        
        $data = array(
                'softone_code' => $this->request->post['CODE'],
                'firstname' => $this->request->post['NAME'],
                'lastname' => $this->request->post['LASTNAME'],
                'email' => $this->request->post['EMAIL'], 
                'telephone' => $this->request->post['PHONE01'],
                'fax' => $this->request->post['FAX'], 
                'customer_group_id' => $cg_id,
                'password' => $this->request->post['AFM'],
                'JOBTYPETRD' => $this->request->post['JOBTYPETRD'],
                'ADDRESS' => $this->request->post['ADDRESS'],
                'ZIP' => $this->request->post['ZIP'],
                'CITY' => $this->request->post['CITY'],
                'AFM' => $this->request->post['AFM'],
			    'DISCOUNTPERCNT' => $this->request->post['MAXPRCDISC'],
			    'COUNTRY' => $this->request->post['COUNTRY'],
			    'ZONE' => $this->request->post['ZONE']
        );
        

                    
        $customer_exists = $this->model_softone_customer->checkIfExists($this->request->post['CODE']);
        
        if ($customer_exists)
                    {
                    $this->model_softone_customer->editCustomer($data,$customer_exists['customer_id']);
					 $json = array(
					'actions' => "Τα στοιχεια του πελάτη ενημερώθηκαν στο Web."
					        );

                    $this->response->setOutput(json_encode($json));
                    }
		else 
                    {
                    $this->model_softone_customer->addCustomer($data);
					 $json = array(
					'actions' => "O πελάτης δημιουργήθηκε στο Web."
					        );
		
                    $this->response->setOutput(json_encode($json));
                    }
		
		//$this->response->setOutput(json_encode($json));
		//$this->response->setOutput(json_encode(2345));
	}
        

 public function setSpd()   
 {
  $json = array();	
        $this->load->model('softone/customer');
        $this->load->model('softone/customer_group');

                    
        $customer_exists = $this->model_softone_customer->checkIfExists($this->request->post['CODE']);
        
                if ($customer_exists)
                    {
                    $this->model_softone_customer->changePass($this->request->post['PSD'],$this->request->post['CODE']);
                    $json = array(
				'actions' => "0"
                        );
                    $this->response->setOutput(json_encode($json));
                    }
		else 
                    {
                    $json = array(
				'actions' => "1"
                        );
                    $this->response->setOutput(json_encode($json));
                    }
		
	$this->response->setOutput(json_encode($json));
	}     
        
        
public function deleteCustomer() {
        $json = array();	
        $this->load->model('softone/customer');
        
         $customer_exists = $this->model_softone_customer->checkIfExists($this->request->post['CODE']);
         
         if (!$customer_exists)
            {
            $json = array('actions' => "Ο πελάτης δεν υπάρχει στο Web");
            $this->response->setOutput(json_encode($json));
            }
         else 
            {
            $this->model_softone_customer->deleteCustomerBySoftone($this->request->post['CODE']);
            $json = array('actions' => "O πελάτης έχει διαγφραφεί απο το Web.") ;
            $this->response->setOutput(json_encode($json));
            } 
           
	}
        
        
        
     
    public function getCId() {
        $json = array();	
        $this->load->model('softone/customer');
         $customer_id = $this->model_softone_customer->getIdByS1Code($this->request->post['CODE']);
         if (isset($customer_id['customer_id']) )
            {
			$json = array('CId' => $customer_id['customer_id']) ;
            $this->response->setOutput(json_encode($json));
            }
         else 
            {
			$json = array('CId' => "-1") ;
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
        
        
public function activateCustomer() {
        $json = array();	
        $this->load->model('softone/customer');
        
         $customer_active = $this->model_softone_customer->checkIfActive($this->request->post['CODE']);
         if (isset($customer_active['status']) )
            {
            if ($customer_active['status'] == 0)
                {
                $this->model_softone_customer->activateCustomer($this->request->post['CODE']);
                $json = array('actions' => "Ο πελάτης ενεργοποιήθηκε στο Web.") ;
                $this->response->setOutput(json_encode($json));
                }
             else 
                {
                $this->model_softone_customer->deActivateCustomer($this->request->post['CODE']);
                $json = array('actions' => "O Πελάτης απενεργοποιήθηκε απο το Web.") ;
                $this->response->setOutput(json_encode($json));
                }
            }
         else 
            {
            $json = array('actions' => "Ο πελάτης δεν υπάρχει στο Web") ;
            $this->response->setOutput(json_encode($json));
            }
           
	}
       
public function connectToCustomer() {
        $json = array();	
        $this->load->model('softone/customer');
          
        $this->model_softone_customer->connectToCustomer($this->request->post['CUSTOMER_ID'],$this->request->post['CODE']);
        $json = array('actions' => "1") ;
        $this->response->setOutput(json_encode($json));    
	}
	   
	   
	   
        
        
     public function getCustomers() {
         
        $json = array();
        $this->load->model('softone/customer');
        
        $data = array(
			'filter_name'              => null, 
			'filter_email'             => null, 
			'filter_customer_group_id' => null, 
			'filter_status'            => null, 
			'filter_approved'          => null, 
			'filter_date_added'        => null,
			'filter_ip'                => null,
			'sort'                     => 'name',
			'order'                    => 'ASC',
			'start'                    => 0,
			'limit'                    => 10000
		);
        

           $results = $this->model_softone_customer->getCustomers($data);
       
            $this->response->setOutput(json_encode($results));
          
          //      $responce = "";
        //foreach ($results as $result) 
          //  {
          //  $responce .= $result['customer_id'] . " " .$result['name'] . "  ~~~  ";
          //  }
        
        
          //   $this->response->setOutput(json_encode($responce));
	}       
        
        
        
        
        /*public function Sync() {
		$json = array();
		
        $this->load->model('localisation/country');
        $this->load->model('softone/customer');
        
    	//$country_info = $this->model_localisation_country->postCountry($this->request->post['country_id']);
	
        $customer_exists = $this->model_softone_customer->checkIfExists($this->request->post['CODE']);
        
                if ($customer_exists){
                    $json = array(
				'exists'        => "Yes"
				
			);
                    $this->response->setOutput(json_encode($json));
                }
        
		else if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->postZonesByCountryId($this->request->post['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	} */
        
        
        
        
        
}
?>