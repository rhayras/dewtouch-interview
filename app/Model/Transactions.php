<?php

class Transactions extends AppModel {


	var $hasMany = array('TransactionItems' => array(
			'conditions' => array('TransactionItems.valid' => 1)
		)
	);
}