<?php

echo $this->Form->create('Migrate',array("enctype" => "multipart/form-data"));
echo $this->Form->input('file', array('label' => 'Please upload xls file to migrate data', 'type' => 'file'));
echo $this->Form->submit('Migrate', array('class' => 'btn btn-primary'));
echo $this->Form->end();

if(!empty($error)){
	echo $error;
}

if(!empty($data)){
	echo "<h5>Migrated Data: array format</h5>";
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
?>

