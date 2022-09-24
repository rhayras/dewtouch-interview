<?php

class Members extends AppModel {
	var $hasMany = array('Transactions' => array(
			'conditions' => array('Transactions.valid' => 1)
		)
	);
}