
<div id="message1">


<?php echo $this->Form->create('formats',array('url' => '/Format/save','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array('label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>


	
<?php echo __("Hi, please choose a type below:")?>
<br><br>



<?php $options_new = array(
 		'Type1' => __('<div class="rhay_tooltip"><span>Type1</span>
					  <div class="rhay_tooltiptext"><ul><li>Description .......</li>
					 				<li>Description 2</li></ul></div>
					</div>'),
		'Type2' => __('<div class="rhay_tooltip"><span>Type2</span>
  <div class="rhay_tooltiptext">
  	<ul>
  		<li>Desc 1 .....</li>
				<li>Desc 2...</li></ul></div>
</div>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>

<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary hidden', 'id' => 'submitBtn')); ?>


<?php echo $this->Form->end();?>

</div>

<style>
.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}


.rhay_tooltip {
  position: relative;
  display: inline-block;
}

.rhay_tooltip .rhay_tooltiptext {
  visibility: hidden;
  width: 150px;
  background-color: white;
  color: black;
  text-align: center;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  top: -15px;
  left: 120%;
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5);
}

.rhay_tooltip .rhay_tooltiptext::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent white transparent transparent;
}

.rhay_tooltip:hover .rhay_tooltiptext {
  visibility: visible;
}


</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){
	// $(".dialog").dialog({
	// 	autoOpen: false,
	// 	width: '500px',
	// 	modal: true,
	// 	dialogClass: 'ui-dialog-blue'
	// });

	
	// $(".showDialog").click(function(){ var id = $(this).data('id'); $("#"+id).dialog('open'); });

	$(document).on("click","input[type=radio]",function(){
		$("#submitBtn").removeClass("hidden");
	});
})


</script>
<?php $this->end()?>