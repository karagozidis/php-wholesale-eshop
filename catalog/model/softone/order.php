<?php

class ModelSoftoneOrder extends Model {

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");
		return $query->rows;
	}

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$reward = 0;
                        
			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}			

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
                                $payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}
	
			if ($order_query->row['affiliate_id']) {
				$affiliate_id = $order_query->row['affiliate_id'];
			} else {
				$affiliate_id = 0;
			}				
				
		//	$this->load->model('sale/affiliate');
				
			//$affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);
			
		//	if ($affiliate_info) {
		//		$affiliate_firstname = $affiliate_info['firstname'];
		//		$affiliate_lastname = $affiliate_info['lastname'];
		//	} else {
				$affiliate_firstname = '';
				$affiliate_lastname = '';				
		//	}

		//	$this->load->model('localisation/language');
			
		//	$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);
			
		//	if ($language_info) {
		//		$language_code = $language_info['code'];
		//		$language_filename = $language_info['filename'];
		//		$language_directory = $language_info['directory'];
		//	} else {
				$language_code = '';
				$language_filename = '';
				$language_directory = '';
		//	}
           
            $amazonOrderId = '';

            

            if ($this->config->get('amazon_status') == 1) {

                $amazon_query = $this->db->query("

                    SELECT `amazon_order_id`

                    FROM `" . DB_PREFIX . "amazon_order`

                    WHERE `order_id` = " . (int) $order_query->row['order_id'] . "

                    LIMIT 1")->row;



                if (isset($amazon_query['amazon_order_id']) && !empty($amazon_query['amazon_order_id'])) {

                    $amazonOrderId = $amazon_query['amazon_order_id'];

                }

            }

            

            if ($this->config->get('amazonus_status') == 1) {

                $amazon_query = $this->db->query("

                        SELECT `amazonus_order_id`

                        FROM `" . DB_PREFIX . "amazonus_order`

                        WHERE `order_id` = " . (int) $order_query->row['order_id'] . "

                        LIMIT 1")->row;



                if (isset($amazon_query['amazonus_order_id']) && !empty($amazon_query['amazonus_order_id'])) {

                    $amazonOrderId = $amazon_query['amazonus_order_id'];

                }

            }
			
			return array(

                'amazon_order_id'         => $amazonOrderId,

				'order_id'                => $order_query->row['order_id'],

				'invoice_no'              => $order_query->row['invoice_no'],

				'invoice_prefix'          => $order_query->row['invoice_prefix'],

				'store_id'                => $order_query->row['store_id'],

				'store_name'              => $order_query->row['store_name'],

				'store_url'               => $order_query->row['store_url'],

				'customer_id'             => $order_query->row['customer_id'],

				'customer'                => $order_query->row['customer'],

				'customer_group_id'       => $order_query->row['customer_group_id'],

				'firstname'               => $order_query->row['firstname'],

				'lastname'                => $order_query->row['lastname'],

				'telephone'               => $order_query->row['telephone'],

				'fax'                     => $order_query->row['fax'],

				'email'                   => $order_query->row['email'],

				'payment_firstname'       => $order_query->row['payment_firstname'],

				'payment_lastname'        => $order_query->row['payment_lastname'],

				'payment_company'         => $order_query->row['payment_company'],

				'payment_company_id'      => $order_query->row['payment_company_id'],

				'payment_tax_id'          => $order_query->row['payment_tax_id'],

				'payment_address_1'       => $order_query->row['payment_address_1'],

				'payment_address_2'       => $order_query->row['payment_address_2'],

				'payment_postcode'        => $order_query->row['payment_postcode'],

				'payment_city'            => $order_query->row['payment_city'],

				'payment_zone_id'         => $order_query->row['payment_zone_id'],

				'payment_zone'            => $order_query->row['payment_zone'],

				'payment_zone_code'       => $payment_zone_code,

				'payment_country_id'      => $order_query->row['payment_country_id'],

				'payment_country'         => $order_query->row['payment_country'],

				'payment_iso_code_2'      => $payment_iso_code_2,

				'payment_iso_code_3'      => $payment_iso_code_3,

				'payment_address_format'  => $order_query->row['payment_address_format'],

				'payment_method'          => $order_query->row['payment_method'],

				'payment_code'            => $order_query->row['payment_code'],				

				'shipping_firstname'      => $order_query->row['shipping_firstname'],

				'shipping_lastname'       => $order_query->row['shipping_lastname'],

				'shipping_company'        => $order_query->row['shipping_company'],

				'shipping_address_1'      => $order_query->row['shipping_address_1'],

				'shipping_address_2'      => $order_query->row['shipping_address_2'],

				'shipping_postcode'       => $order_query->row['shipping_postcode'],

				'shipping_city'           => $order_query->row['shipping_city'],

				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],

				'shipping_zone'           => $order_query->row['shipping_zone'],

				'shipping_zone_code'      => $shipping_zone_code,

				'shipping_country_id'     => $order_query->row['shipping_country_id'],

				'shipping_country'        => $order_query->row['shipping_country'],

				'shipping_iso_code_2'     => $shipping_iso_code_2,

				'shipping_iso_code_3'     => $shipping_iso_code_3,

				'shipping_address_format' => $order_query->row['shipping_address_format'],

				'shipping_method'         => $order_query->row['shipping_method'],

				'shipping_code'           => $order_query->row['shipping_code'],

				'comment'                 => $order_query->row['comment'],

				'total'                   => $order_query->row['total'],

				'reward'                  => $reward,

				'order_status_id'         => $order_query->row['order_status_id'],

				'affiliate_id'            => $order_query->row['affiliate_id'],

				'affiliate_firstname'     => $affiliate_firstname,

				'affiliate_lastname'      => $affiliate_lastname,

				'commission'              => $order_query->row['commission'],

				'language_id'             => $order_query->row['language_id'],

				'language_code'           => $language_code,

				'language_filename'       => $language_filename,

				'language_directory'      => $language_directory,				

				'currency_id'             => $order_query->row['currency_id'],

				'currency_code'           => $order_query->row['currency_code'],

				'currency_value'          => $order_query->row['currency_value'],

				'ip'                      => $order_query->row['ip'],

				'forwarded_ip'            => $order_query->row['forwarded_ip'], 

				'user_agent'              => $order_query->row['user_agent'],	

				'accept_language'         => $order_query->row['accept_language'],					

				'date_added'              => $order_query->row['date_added'],

				'date_modified'           => $order_query->row['date_modified']

			);

		} else {

			return false;

		}

	}

	public function getOrders($data = array()) {
		$sql = "SELECT o.order_id, c.softone_code , CONCAT(o.firstname, ' ', o.lastname) AS customer,"
                        . " (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified "
                        . "FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "customer` c on o.customer_id = c.customer_id ";

		if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		/* if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		} */
                
		if (!empty($data['filter_date_added_from'])  && !empty($data['filter_date_added_to']) ) {
			$sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_added_from']) . "') "
                             .  " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_added_to']) . "') ";
		}
               
		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'o.order_id',
			'customer',
			'status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
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

	

	public function getOrderProducts($order_id) {

        $query = $this->db->query(
        " SELECT p.*, op.value as opvalue , op.quantity as opquantity  ".
        " FROM " . DB_PREFIX . "order_product p ".
        " LEFT OUTER JOIN " . DB_PREFIX . "order_option op ".
        " ON op.order_product_id  = p.order_product_id AND op.order_id = p.order_id  ".
        " WHERE p.order_id = '" . (int)$order_id . "'");

		
		return $query->rows;

	}

	

	public function getOrderOption($order_id, $order_option_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_option_id = '" . (int)$order_option_id . "'");



		return $query->row;

	}

	

	public function getOrderOptions($order_id, $order_product_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");



		return $query->rows;

	}



	public function getOrderDownloads($order_id, $order_product_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");



		return $query->rows;

	}

	

	public function getOrderVouchers($order_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		

		return $query->rows;

	}

	

	public function getOrderVoucherByVoucherId($voucher_id) {

      	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");



		return $query->row;

	}

				


	public function getTotalOrders($data = array()) {

      	$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";



		if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {

			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";

		} else {

			$sql .= " WHERE order_status_id > '0'";

		}



		if (!empty($data['filter_order_id'])) {

			$sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";

		}



		if (!empty($data['filter_customer'])) {

			$sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";

		}



		if (!empty($data['filter_date_added'])) {

			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";

		}

		

		if (!empty($data['filter_date_modified'])) {

			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";

		}

		

		if (!empty($data['filter_total'])) {

			$sql .= " AND total = '" . (float)$data['filter_total'] . "'";

		}



		$query = $this->db->query($sql);



		return $query->row['total'];

	}



	public function getTotalOrdersByStoreId($store_id) {

      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");



		return $query->row['total'];

	}



	public function getTotalOrdersByOrderStatusId($order_status_id) {

      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");



		return $query->row['total'];

	}



	public function getTotalOrdersByLanguageId($language_id) {

      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");



		return $query->row['total'];

	}



	public function getTotalOrdersByCurrencyId($currency_id) {

      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");



		return $query->row['total'];

	}

	

	public function getTotalSales() {

      	$query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'");



		return $query->row['total'];

	}



	public function getTotalSalesByYear($year) {

      	$query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . (int)$year . "'");



		return $query->row['total'];

	}



	public function createInvoiceNo($order_id) {

		$order_info = $this->getOrder($order_id);

			

		if ($order_info && !$order_info['invoice_no']) {

			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

	

			if ($query->row['invoice_no']) {

				$invoice_no = $query->row['invoice_no'] + 1;

			} else {

				$invoice_no = 1;

			}

		

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

			

			return $order_info['invoice_prefix'] . $invoice_no;

		}

	}

	

	public function addOrderHistory($order_id, $data) {

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");



		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$data['order_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");



		$order_info = $this->getOrder($order_id);



		// Send out any gift voucher mails

		if ($this->config->get('config_complete_status_id') == $data['order_status_id']) {

			$this->load->model('sale/voucher');



			$results = $this->getOrderVouchers($order_id);

			

			foreach ($results as $result) {

				$this->model_sale_voucher->sendVoucher($result['voucher_id']);

			}

		}



      	if ($data['notify']) {

			$language = new Language($order_info['language_directory']);

			$language->load($order_info['language_filename']);

			$language->load('mail/order');



			$subject = sprintf($language->get('text_subject'), $order_info['store_name'], $order_id);



			$message  = $language->get('text_order') . ' ' . $order_id . "\n";

			$message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

			

			$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				

			if ($order_status_query->num_rows) {

				$message .= $language->get('text_order_status') . "\n";

				$message .= $order_status_query->row['name'] . "\n\n";

			}

			

			if ($order_info['customer_id']) {

				$message .= $language->get('text_link') . "\n";

				$message .= html_entity_decode($order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";

			}

			

			if ($data['comment']) {

				$message .= $language->get('text_comment') . "\n\n";

				$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";

			}



			$message .= $language->get('text_footer');



			$mail = new Mail();

			$mail->protocol = $this->config->get('config_mail_protocol');

			$mail->parameter = $this->config->get('config_mail_parameter');

			$mail->hostname = $this->config->get('config_smtp_host');

			$mail->username = $this->config->get('config_smtp_username');

			$mail->password = $this->config->get('config_smtp_password');

			$mail->port = $this->config->get('config_smtp_port');

			$mail->timeout = $this->config->get('config_smtp_timeout');

			$mail->setTo($order_info['email']);

			$mail->setFrom($this->config->get('config_email'));

			$mail->setSender($order_info['store_name']);

			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));

			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));

			$mail->send();

		}

        

        $this->load->model('payment/amazon_checkout');

        $this->model_payment_amazon_checkout->orderStatusChange($order_id, $data);

	}

		

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {

		if ($start < 0) {

			$start = 0;

		}

		

		if ($limit < 1) {

			$limit = 10;

		}	

				

		$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);



		return $query->rows;

	}

	

	public function getTotalOrderHistories($order_id) {

	  	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");



		return $query->row['total'];

	}	

		

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {

	  	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");



		return $query->row['total'];

	}	

	

	public function getEmailsByProductsOrdered($products, $start, $end) {

		$implode = array();

		

		foreach ($products as $product_id) {

			$implode[] = "op.product_id = '" . $product_id . "'";

		}

		

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

	

		return $query->rows;

	}

	

	public function getTotalEmailsByProductsOrdered($products) {

		$implode = array();

		

		foreach ($products as $product_id) {

			$implode[] = "op.product_id = '" . $product_id . "'";

		}

				

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . $start . "," . $end);	

		

		return $query->row['total'];

	}	

}

?>