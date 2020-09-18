<?php 
class ControllerSoftoneCustomerGroup extends Controller {
	
	     
public function Sync() {
        $json = array();	
        $this->load->model('softone/customer_group');
        
        $data = array(
                'softone_code' => $this->request->post['CODE'],
                'name' => $this->request->post['NAME'],
                'description' => $this->request->post['NAME']
                );
        
        $exists = $this->model_softone_customer_group->checkIfExists($this->request->post['CODE']);

        if ($exists)
            {
            $this->model_softone_customer_group->editCustomerGroup($exists['customer_group_id'],$data);
            $json = array(
                        'actions' => "Ενημερώθηκαν τα στοιχεία της τιμολογιακής κατηγορίας."
                );
            $this->response->setOutput(json_encode($json));
            }
        else 
            {
            $this->model_softone_customer_group->addCustomerGroup($data);
            $json = array(
                        'actions' => "Δημιουργήθηκε η τιμολογιακή κατηγορία."
                );
            $this->response->setOutput(json_encode($json));
            }

        $this->response->setOutput(json_encode($json));
	}

        
        
   public function getId() {
        $json = array();	
        $this->load->model('softone/customer_group');
        $customer_group = $this->model_softone_customer_group->getIdBySoftoneCode($this->request->post['CODE']);
        if (isset($customer_group ['customer_group_id']) )
            {       
            $this->response->setOutput(json_encode($customer_group['customer_group_id']));
            }
        else 
            {       
            $this->response->setOutput(json_encode("-1"));
            }
	}
        
  
public function delete() {
        $json = array();	
        $this->load->model('softone/customer_group');
        
         $exists = $this->model_softone_customer_group->checkIfExists($this->request->post['CODE']);
         
         if (!$exists)
            {
            $json = array('actions' => "0");
            $this->response->setOutput(json_encode($json));
            }
         else 
            {
            $total = $this->model_softone_customer_group->countCustomersInCustomerGroup($exists['customer_group_id']);
            if($total["number"] == 0 )
                {
                $this->model_softone_customer_group->deleteCustomerGroup($exists['customer_group_id']);
                $json = array('actions' => "1") ;
                $this->response->setOutput(json_encode($json));
                }
            else 
                {
                 $json = array('actions' => "2");
                 $this->response->setOutput(json_encode($json));
                }
            }  
	}
        
        
    /*  public function isActiveCustomer() {
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
           
	} */
        
        
/* public function activate() {
        $json = array();	
        $this->load->model('softone/product');
        
         $active = $this->model_softone_product->checkIfActive($this->request->post['CODE']);
         if (isset($active['status']) )
            {
            if ($active['status'] == 0)
                {
                $this->model_softone_product->activate($this->request->post['CODE']);
                $json = array('actions' => "1") ;
                $this->response->setOutput(json_encode($json));
                }
             else 
                {
                $this->model_softone_product->deActivate($this->request->post['CODE']);
                $json = array('actions' => "0") ;
                $this->response->setOutput(json_encode($json));
                }
            }
         else 
            {
            $json = array('actions' => "2") ;
            $this->response->setOutput(json_encode($json));
            }
           
	} */
        
        
        
        
        
        
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