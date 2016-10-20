<div class="container">
<?php
$attributes = array('class' => 'form', 'id' => 'create_user',  'onsubmit'=> 'return validateForm();');
echo form_open('jobs/edit', $attributes);
?>	
<div class="col-md-11">
	<div class="row">
	
		<table class="table" border="2">
		<tr id="regular">
			<td width="50%">
				Party Name: <?php echo $jobInfo['company_name'] ? $jobInfo['company_name'] : $jobInfo['name'];?>
			</td>
			
			<td>
				Mobile : 
				<?php echo $jobInfo['mobile'];?>
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%" class="table">
				<tr>
					<td colspan="2" align="right">
						Job Name :
					</td>
					<td colspan="2">
					<input type="text" name="job_name" id="job_name" required="required" value="<?php echo $jobInfo['job_name'];?>" class="form-control">
					</td>
				</tr>
				<tr>
					<th> Sr </th>
					<th> Calendar Name </th>
					<th> Details </th>
					<th> Qty </th>
					<th> Rate </th>
					<th> Sub Total </th>
				</tr>
				
				<?php
				for($i=1; $i<=5; $i++)
				{
					$j = $i - 1;
					
					$categoryValue = $detailsValue = $qtyValue = "";
					$rateValue = $subtotalValue = "";
					
					if(isset($jobDetails[$j]['category']) && !empty($jobDetails[$j]['category']))
					{
						$categoryValue 	= $jobDetails[$j]['category'];
						$detailsValue 	= $jobDetails[$j]['details'];
						$qtyValue 		= $jobDetails[$j]['qty'];
						$rateValue 		= $jobDetails[$j]['rate'];
						$subtotalValue 	= $jobDetails[$j]['sub_total'];
					}
				?>
				<tr>
					<td> <?php echo $i;?> </td>
					<td> 
						<select name="category_<?php echo $i;?>">
							<option> <?php echo $categoryValue;?> </option>
							<option> General </option>
							<option> Calendar-1 </option>
							<option> Calendar-2 </option>
							<option> Calendar-3 </option>
							<option> Calendar-4 </option>
							<option> Calendar-5 </option>
						</select>
					 </td>
					<td> <input type="text" class="form-control" name="details_<?php echo $i;?>" id="details_<?php echo $i;?>"  value="<?php echo $detailsValue;?>" > </td>
					<td> <input type="text" class="form-control" name="qty_<?php echo $i;?>" id="qty_<?php echo $i;?>" style="width:80px;"  value="<?php echo $qtyValue;?>" > </td>
					<td> <input type="text" class="form-control job_rate_class" data-id="<?php echo $i;?>" name="rate_<?php echo $i;?>" id="rate_<?php echo $i;?>" style="width:80px;"  value="<?php echo $rateValue;?>" > </td>
					<td> <input type="text" class="form-control" name="subtotal_<?php echo $i;?>" id="subtotal_<?php echo $i;?>" style="width:80px;"  value="<?php echo $subtotalValue;?>" > </td>
				</tr>
				
				<?php } ?>
					
				<tr>
					<td colspan="5" align="right">
						Sub Total :
					</td>
					<td>
						<input type="text" id="sub_total"  value="<?php echo $jobInfo['job_total'];?>"  name="sub_total">
					</td>
				</tr>
				
				<tr>
					<td colspan="5" align="right">
						Advance :
					</td>
					<td>
						<input type="text" id="advance"  value="<?php echo $jobInfo['job_advance'];?>"  name="advance">
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
						Payment Terms
						<textarea name="payment_term" class="form-control"><?php echo $jobInfo['job_payment_term'];?></textarea>
					</td>
					<td align="right">
						Due :
					</td>
					<td>
						<input type="text" id="due" name="due"  value="<?php echo $jobInfo['job_due'];?>" >
					</td>
				</tr>
			</table>
			
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="text-center"> 
				<input type="hidden" name="id"  value="<?php echo $jobInfo['job_id'];?>">
				<input type="hidden" name="customer_id"  value="<?php echo $jobInfo['customer_id'];?>">
				<input type="submit" name="save" value="Save" class="btn btn-primary btn-flat">
				<input type="reset" name="reset" value="Reset" class="btn btn-primary btn-flat">
			</td>
		</tr>
		</table>
	</div>
</div>

<script>
jQuery(document).ready(function() 
{
	jQuery(".content-header").remove();
	jQuery(".navbar-static-top").remove();
	
	jQuery(".job_rate_class").on('blur', function()
	{
		var key 	= (jQuery(this).data('id'));
		var qtyVal 	= jQuery("#qty_" + key).val();
		var rateVal	= jQuery("#rate_" + key).val();
		var subtotal = qtyVal * rateVal;
		jQuery("#subtotal_" + key).val(subtotal);
	});
	
	jQuery("#sub_total").on('focus', function(){
		calculateSubTotal();
	});

	jQuery("#due").on('focus', function(){
		calculateDue();
	});
});

function checkCustomer()
{
	var customerType =  jQuery("#customer_type").val();
	
	if(customerType == 1 )
	{
		if(jQuery("#customer_name").val().length  < 1 )
		{
			jQuery("#customer_name").focus();
			alert("Customer Name Required");
			return false;
		}
	}
	
	if(customerType == 0 )
	{
		if(jQuery("#customer_id").val() == 0 )
		{
			alert("Please select Customer");
			return false;
		}
	}
}

function calculateSubTotal()
{
	var total = 0;
	for(i=1; i<=5; i++)
	{
		if(jQuery("#subtotal_" + i).val().length > 1 )
		{
			total = total + parseFloat(jQuery("#subtotal_" + i).val());
		}
	}
	
	jQuery("#sub_total").val(total);
	return true;
}

function calculateDue()
{
	var subTotal = jQuery("#sub_total").val();
	var advance  =  0;
	
	if(jQuery("#advance").val().length > 0 )
	{
		advance  = jQuery("#advance").val();
	}
	
	var due = parseFloat(subTotal) - parseInt(advance);
	
	jQuery("#due").val(due);
	
	return true;
}

function validateForm()
{
	var status = "";
	
	if(jQuery("#job_name").val().length < 1 )
	{
		jQuery("#job_name").focus();
		return false;
	}
	
	if(jQuery("#sub_total").val().length < 1 )
	{
		jQuery("#sub_total").focus();
		return false;
	}
	
	calculateSubTotal();
	calculateDue();
	
	status = checkCustomer();
	
	if(status == false)
	{
		return false;
	}
	
	return true;
}	
</script>

