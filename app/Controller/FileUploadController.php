<?php


class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));

		if ($this->request->is('post')){
			if($this->request->data['FileUpload']['file']['name']){
				$file = $this->request->data['FileUpload']['file']; 
	            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); 
	            $arr_ext = array('csv'); 

	            //only process if the extension is valid
	            if(in_array($ext, $arr_ext)){
	                $fileDestionation = WWW_ROOT .'uploads' . DS . $file['name'];
	                move_uploaded_file($file['tmp_name'], $fileDestionation);

	                $students = array();
	                 
					if (($open = fopen($fileDestionation, "r")) !== FALSE) {

			            while(($data = fgetcsv($open,1000,"\r")) !== FALSE){

							$i = 0;
			            	foreach($data as $row){
			            		if($i > 0){
				            		$rowData = explode(",",$row);
				            		$insertArr = array(
				            			'name' => $rowData[0],
				            			'email' => $rowData[1],
				            			'created' => date('Y-m-d H:i:s')
				            		);
				            		$this->FileUpload->save($insertArr);
				            		$this->FileUpload->clear();
			            		}
				            	$i++;
			            	}
			            }

			            fclose($open);
			        }
			        unlink($fileDestionation);

			        $this->set('students', $students);
	            }else{
	            	$this->set('error',"CSV FILE ONLY!");
	            }
			}
	    }

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
	}

}