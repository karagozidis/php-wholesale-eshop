<?php 
class ControllerSoftoneOrder extends Controller {
	

    public function getOrders() {
      $json = array();
      $this->load->model('softone/order');

      $filter_date_added_from = $this->request->post['from'];
      $filter_date_added_to = $this->request->post['to'];    

      $filter_order_id = null;
      $filter_customer = null;
      $filter_order_status_id = null;
      $filter_total = null;  //Na to Do
      $filter_date_modified = null;
      $sort = 'o.order_id';
      $order = 'DESC';

      $data = array(
                'filter_order_id'        => $filter_order_id,
                'filter_customer'	     => $filter_customer,
                'filter_order_status_id' => $filter_order_status_id,
                'filter_total'           => $filter_total,
                'filter_date_added_from' => $filter_date_added_from,
                'filter_date_added_to'   => $filter_date_added_to,
                'filter_date_modified'   => $filter_date_modified,
                'sort'                   => $sort,
                'order'                  => $order,
                'start'                  => 0,
                'limit'                  => 1000
        );

        $results = $this->model_softone_order->getOrders($data);
		
		$t_results = array();
		
		   foreach ($results as $result) 
            {
			$order_totals = $this->model_softone_order->getOrderTotals($result['order_id']);
			$t_results[] = array(
				'date_added' => $result['date_added'] ,
				'order_id' => $result['order_id']  ,
				'softone_code' => $result['softone_code']  ,
				'customer' => $result['customer']  ,
				'total' => $result['total'],
				'sub_total' => $order_totals[0]['value'],
				'sub_title' => $order_totals[0]['title'],
				'shipping' => $order_totals[1]['value'],
				'shipping_title' => $order_totals[1]['title'],
				'ftotal' => $order_totals[2]['value'],
				'ftotal_title' => $order_totals[2]['title'],
				);
			}
		
        $this->response->setOutput(json_encode($t_results));   
    }
        
		
    public function getOrder() {
      $json = array();
      $this->load->model('softone/order');

      $oId = $this->request->post['oId'];
 
      $results = $this->model_softone_order->getOrderProducts($oId);
      $this->response->setOutput(json_encode($results));   
    }
    
    
}
?>