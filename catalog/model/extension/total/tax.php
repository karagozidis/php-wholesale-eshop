<?php
class ModelExtensionTotalTax extends Model {
	public function getTotal($total) {
		/* foreach ($total['taxes'] as $key => $value) {
			if ($value > 0) {
				$total['totals'][] = array(
					'code'       => 'tax',
					'title'      => $this->tax->getRateName($key),
					'value'      => $value,
					'sort_order' => $this->config->get('total_tax_sort_order')
				);

				$total['total'] += $value;
			}
		} */
		
		$this->load->language('extension/total/total');
		$totl = $this->cart->getTotal();
		
	    $discountpercnt = (float) $this->customer->getDiscountpercnt();
		if($discountpercnt > 0 &&  $discountpercnt < 100)	
					{
					$discVal = ((float)((float)$discountpercnt/(float)100)) * $totl;
		        	$totl = $totl - $discVal;
					}
		
		if($this->config->get('config_customer_group_id') == 4 || $this->config->get('config_customer_group_id') == 5) return $totl ;	
		else $totl  = $totl * 1.24;
		
		$total['totals'][] = array(
			'code'       => 'tax',
			'title'      => $this->language->get('text_after_tax'),
			'value'      => $totl ,
			'sort_order' => $this->config->get('total_tax_sort_order')
		);	
		
		
		
		
	}
}