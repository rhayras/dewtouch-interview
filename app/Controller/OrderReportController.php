<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');


			// To Do - write your own array in this format
			$order_reports = array('Order 1' => array(
										'Ingredient A' => 1,
										'Ingredient B' => 12,
										'Ingredient C' => 3,
										'Ingredient G' => 5,
										'Ingredient H' => 24,
										'Ingredient J' => 22,
										'Ingredient F' => 9,
									),
								  'Order 2' => array(
								  		'Ingredient A' => 13,
								  		'Ingredient B' => 2,
								  		'Ingredient G' => 14,
								  		'Ingredient I' => 2,
								  		'Ingredient D' => 6,
								  	),
								);
			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));

			$answer = array();
			if(!empty($orders)){
				foreach($orders as $order){

					$orderSum = array();
					if(!empty($order['OrderDetail'])){
						$ingredientArray = array();
						foreach($order['OrderDetail'] as $orderDetail){
							$qty = $orderDetail['quantity'];
							$itemId = $orderDetail['item_id'];

							//portion data
							$portionData = $portions[$itemId-1];

							if(!empty($portionData['PortionDetail'])){
								foreach($portionData['PortionDetail'] as $portionDetails){
									if(!array_key_exists($portionDetails['Part']['name'], $ingredientArray)){
										$ingredientArray[$portionDetails['Part']['name']] = $portionDetails['value']*$qty;
									}else{
										$ingredientArray[$portionDetails['Part']['name']] = $ingredientArray[$portionDetails['Part']['name']] + $portionDetails['value']*$qty;
									}
								}
							}

							$orderSum[] = array('item' => $orderDetail['Item']['name'],'quantity' => $qty);
						}
					}
					// $answer[$order['Order']['name']]['orderSummary'] = $orderSum;
					ksort($ingredientArray);
					$answer[$order['Order']['name']] = $ingredientArray;

				}
			}

			$this->set('order_reports',$answer);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}