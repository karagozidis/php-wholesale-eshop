<?php
class ModelExtensionTotalTotal extends Model {
	public function getTotal($total) {
		$this->load->language('extension/total/total');
        $totl = $this->cart->getTotal();
	
	    $discountpercnt = (float) $this->customer->getDiscountpercnt();
		if($discountpercnt > 0 &&  $discountpercnt < 100)	
					{
					$discVal = ((float)((float)$discountpercnt/(float)100)) * $totl;
		        	$totl = $totl - $discVal;
					}
		
		
		$total['totals'][] = array(
			'code'       => 'total',
			'title'      => $this->language->get('text_total'),
			'value'      => $totl ,//max(0, $total['total']),
			'sort_order' => $this->config->get('total_total_sort_order')
		);
	}
}