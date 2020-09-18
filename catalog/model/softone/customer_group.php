<?php
class ModelSoftoneCustomerGroup extends Model {

    
        public function getIdBySoftoneCode($softone_code) {
		$query = $this->db->query("SELECT DISTINCT customer_group_id FROM " . DB_PREFIX . "customer_group WHERE softone_code = '" . $this->db->escape($softone_code) . "'");
		return $query->row;
	}
    
    
        public function checkIfExists($softone_code) {
		$query = $this->db->query("SELECT DISTINCT customer_group_id FROM " . DB_PREFIX . "customer_group WHERE softone_code = '" . $this->db->escape($softone_code) . "'");
		return $query->row;
	}
           
        public function countCustomersInCustomerGroup($customer_group_id) {
		//$query = $this->db->query("SELECT DISTINCT customer_group_id FROM " . DB_PREFIX . "customer_group WHERE softone_code = '" . $this->db->escape($customer_group_id) . "'");
                $query = $this->db->query(" SELECT count(`customer_id`) AS number FROM `m7s0p_customer` WHERE `customer_group_id` = '" . (int) $customer_group_id . "' ");
               
		return $query->row;
	}
   
        
       // public function checkIfActive($softone_code) {
	//	$query = $this->db->query("SELECT status FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($softone_code) . "'");
	//	return $query->row;
	//}

       // public function activate($softone_code) {
        //        	$this->db->query("UPDATE " . DB_PREFIX . "product  SET status = '1' where model='". $this->db->escape($softone_code) . "'");
	//}
        
       // public function deActivate($softone_code) {
        //        	$this->db->query("UPDATE " . DB_PREFIX . "product  SET status = '0' where model='". $this->db->escape($softone_code) . "'");
	//}
        public function deleteCustomerGroup($customer_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
        
        
        
        public function addCustomerGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group SET approval = '" . (int)0 . "', " //0 = true
                        . " softone_code = '" . $this->db->escape($data['softone_code']) . "', "
                        . " sort_order = '" . (int)1 . "'");
	
		$customer_group_id = $this->db->getLastId();
		
		//foreach ($data['customer_group_description'] as $language_id => $value) {
		$this->db->query(
                                "INSERT INTO " . DB_PREFIX . "customer_group_description SET "
                                . " customer_group_id = '" . (int)$customer_group_id . "', "
                                . " language_id = '" . (int)(int)$this->config->get('config_language_id') . "', "
                                . " name = '" . $this->db->escape($data['name']) . "', "
                                . " description = '" . $this->db->escape($data['description']) . "'"
                                );
		//}	
	}
	
	public function editCustomerGroup($customer_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET "
                        . " softone_code = '" . $this->db->escape($data['softone_code']) . "' "
                        . " WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description"
                        . " WHERE "
                        . " customer_group_id = '" . (int)$customer_group_id . "'"
                        . " AND language_id = '" . (int)(int)$this->config->get('config_language_id') . "' ");

                $this->db->query(
                             "INSERT INTO " . DB_PREFIX . "customer_group_description SET "
                                . " customer_group_id = '" . (int)$customer_group_id . "', "
                                . " language_id = '" . (int)(int)$this->config->get('config_language_id') . "', "
                                . " name = '" . $this->db->escape($data['name']) . "', "
                                . " description = '" . $this->db->escape($data['description']) . "'"
                                );
		//foreach ($data['customer_group_description'] as $language_id => $value) {
		//	$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		//}
	}
        

	
}
?>
