<?php
	
	App::import('Vendor', 'php-excel-reader/excel_reader2');
	class MigrationController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Migration of data to multiple DB table');
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
			
		}

		public function index(){
			ini_set('memory_limit', '500M');
			ini_set("precision", "15");
			$this->loadModel('Members');
			$this->loadModel('Transactions');
			$this->loadModel('TransactionItems');

			$data = $this->Members->find('all');

			if ($this->request->is('post')){
				if($this->request->data['Migrate']['file']['name']){
					$file = $this->request->data['Migrate']['file']; 
		            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); 
		            $arr_ext = array('xls'); 

		            //only process if the extension is valid
		            if(in_array($ext, $arr_ext)){

		            	$fileDestionation = WWW_ROOT .'uploads' . DS . $file['name'];
	                	move_uploaded_file($file['tmp_name'], $fileDestionation);

						$xls = new Spreadsheet_Excel_Reader(WWW_ROOT .'uploads' . DS . $file['name'], true);
					    $xlsData = $xls->dumptoarray();
					    $this->log($xlsData, 'debug');

					    $header = array();
					    $returnArr = array();
				    	if(!empty($xlsData)){
				    		$header = $xlsData[1];

				    		for($x = 2; $x <= count($xlsData);$x++){
				    			$memberId = $x-1;
				    			//for member table
				    			$memberName = $xlsData[$x][3];
				    			$typeNo = explode(' ',$xlsData[$x][4]);
				    			$no = "";

				    			$membersArray = array(
				    				'type' => $typeNo[0],
				    				'no' => $typeNo[1],
				    				'name' => $memberName,
				    			);
				    			
				    			$returnArr[$memberId]['Members'] = $membersArray;

				    			//for transaction table

				    			$transactionArray = array(
				    				'member_id' => $memberId,
				    				'member_name' => $memberName,
				    				'member_paytype' => $xlsData[$x][5],
				    				'member_company' => ($xlsData[$x][6] != "") ? $xlsData[$x][6] : NULL,
				    				'date' => date('Y-m-d',strtotime($xlsData[$x][1])),
				    				'year' => date('Y',strtotime($xlsData[$x][1])),
				    				'month' => date('n',strtotime($xlsData[$x][1])),
				    				'ref_no' => $xlsData[$x][2],
				    				'receipt_no' => $xlsData[$x][9],
				    				'payment_method' => $xlsData[$x][7],
				    				'batch_no' => $xlsData[$x][8],
				    				'cheque_no' => ($xlsData[$x][10] != "") ? $xlsData[$x][10] : NULL,
				    				'payment_type' => $xlsData[$x][11],
				    				'renewal_year' => $xlsData[$x][12],
				    				'remarks' => NULL,
				    				'subtotal' => (float)$xlsData[$x][13],
				    				'tax' => $xlsData[$x][14],
				    				'total' => (float)$xlsData[$x][15]
				    			);

				    			$returnArr[$memberId]['Transaction'] = $transactionArray;

				    			//for transaction item

				    			$transactionItemArray = array(
				    				'transaction_id' => $memberId,
				    				'description' => "Being Payment for : ".$transactionArray['payment_type']." : ".$transactionArray['year'],
				    				'quantity' => 1,
				    				'unit_price' => (float)$transactionArray['subtotal'],
				    				'sum' => (float)$transactionArray['subtotal'],
				    				'table' => 'Member',
				    				'table_id' => 1
				    			);

				    			$returnArr[$memberId]['TransactionItems'] = $transactionItemArray;

				    			//insert member table
				    			$this->Members->save($membersArray);
			            		$this->Members->clear();

			            		//insert transaction table
			            		$this->Transactions->save($transactionArray);
			            		$this->Transactions->clear();
			            		
			            		//insert transaction items table
			            		$this->TransactionItems->save($transactionItemArray);
			            		$this->TransactionItems->clear();
				    		}
				    	}

						$this->set("data",$returnArr);
						unlink($fileDestionation);

				    }else{
	            		$this->set('error',"XLS FILE ONLY!");
	            	}
				}else{
					$this->set('error',"No File Selected!");
				}
			}

		}
		
	}