<div class="alert  ">
    <button class="close" data-dismiss="alert"></button>
    Question: Advanced Input Field
</div>
<p>
    1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.
</p>
<p>
    2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field
    <?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]
</p>
<div class="alert alert-success">
    <button class="close" data-dismiss="alert"></button>
    The table you start with
</div>
<table class="table table-striped table-bordered table-hover" id="invoiceTable">
    <thead>
        <th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
            <i class="icon-plus"></i></span>
        </th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit Price</th>
    </thead>
    <tbody>
        <tr class="table-tr">
            <td></td>
            <td class="description-td">
            	<p class="description-display"></p>
            	<textarea name="data[1][description]" class="m-wrap description required" rows="2" style="display: none;white-space: pre-wrap;"></textarea>
            </td>
            <td class="quantity-td">
            	<p class="quantity-display"></p>
            	<input name="data[1][quantity]" type="number" class="quantity" style="display: none;" />
            </td>
            <td class="unit-price-td">
            	<p class="unit-price-display"></p>
            	<input name="data[1][unit_price]" type="number" class="unit-price" style="display: none;">
            </td>
        </tr>
    </tbody>
</table>
<p></p>
<div class="alert alert-info ">
    <button class="close" data-dismiss="alert"></button>
    Video Instruction
</div>
<p style="text-align:left;">
    <video width="78%"   controls>
        <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
        Your browser does not support the video tag.
    </video>
</p>
<?php $this->start('script_own');?>
<script>
    $(document).ready(function(){
    
    	$("#add_item_button").click(function(){
    		// alert("suppose to add a new row");
    		var trCount = $(".table-tr").length+1;

    		var newTr = '<tr>';
    			newTr += '<td><button class="btn btn-danger delete-row">X</button></td>';
    			newTr += '<td class="description-td">';
    				newTr += '<p class="description-display"></p>';
    				newTr += '<textarea name="data['+trCount+'][description]" class="m-wrap description required" rows="2" style="display: none;white-space: pre-wrap;"></textarea>';
    			newTr += '</td>';
    			newTr += '<td class="quantity-td">';
    				newTr += '<p class="quantity-display"></p>';
    				newTr += '<input name="data['+trCount+'][quantity]" type="number" class="quantity" style="display: none;" />';
    			newTr += '</td>';
    			newTr += '<td class="unit-price-td">';
    				newTr += '<p class="unit-price-display"></p>';
    				newTr += '<input name="data['+trCount+'][unit-price]" type="number" class="unit-price" style="display: none;" />';
    			newTr += '</td>';
    		newTr += '<tr>';

    		$("#invoiceTable tbody").append(newTr);

		});

		$(document).on("click",".description-td",function(){
			// alert($(this).find('.description-display').is(":visible"));
			// if($(this).find('textarea').is(":visible")){
				$(this).find('.description-display').hide();
				$(this).find("textarea").show();
				$(this).find("textarea").focus();
			// }
				
		});

		$(document).on("change blur",".description",function(){
			var val = $(this).val();
			$(this).prev(".description-display").show();
			$(this).prev(".description-display").html(val);
			$(this).hide();
		});

		$(document).on("click",".quantity-td",function(){
			if($(this).find('.quantity-display').is(":visible")){
				$(this).find('.quantity-display').hide();
				$(this).find(".quantity").show();
				$(this).find(".quantity").focus();
			}
				
		});

		$(document).on("change blur",".quantity",function(){
			var val = $(this).val();
			$(this).prev(".quantity-display").show();
			$(this).prev(".quantity-display").html(val);
			$(this).hide();
		});

		$(document).on("click",".unit-price-td",function(){
			if($(this).find('.unit-price-display').is(":visible")){
				$(this).find('.unit-price-display').hide();
				$(this).find(".unit-price").show();
				$(this).find(".unit-price").focus();
			}
			
		});

		$(document).on("change blur",".unit-price",function(){
			var val = $(this).val();
			$(this).prev(".unit-price-display").show();
			$(this).prev(".unit-price-display").html(val);
			$(this).hide();
		});

		$(document).on("click",".delete-row",function(){
			$(this).closest('tr').remove();
		});
    
    	
    });
</script>
<?php $this->end();?>