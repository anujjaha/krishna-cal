<div class="container">
<?php
$attributes = array('class' => 'form', 'id' => 'create_user', 'onsubmit'=> 'return validateForm();');
echo form_open('jobs/add', $attributes);
?>	
<div class="col-md-11">
	<div class="row">
	
		<table class="table" border="2">
		<tr>
			<td colspan="2">
				Select Party :
				<label>
					<input type="radio" onclick="changePartyType(1);" checked="checked" name="partyType" id="partyType" value="0">Regular
				</label>
				<label>
					<input type="radio"  onclick="changePartyType(0);" name="partyType" id="partyType" value="1">New
				</label>
			</td>
		</tr>
		
		<tr id="regular">
			<td width="50%">
				Party Name:
				<?php echo getPartiesDropdown();?>
			</td>
			
			<td>
				Mobile : 
				<input type="text" name="mobile" id="mobile" class="form-control">
			</td>
		</tr>
		
		<tr id="new"  style="display:none;">
			<td colspan="2">
				<table class="table"  width="100%">
					<tr>
						<td> Name : <input type="text" id="customer_name"  class="form-control" name="name"> </td>
						<td> Company Name : <input type="text"  class="form-control" name="company_name"> </td>
					</tr>
					<tr>
						<td> Mobile : <input type="text"  class="form-control" name="customer_mobile"> </td>
						<td> Address : <textarea name="address" class="form-control"></textarea></td>
					</tr>
				</table>
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
					<input type="text" name="job_name" id="job_name" class="form-control">
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
				?>
				<tr>
					<td> <?php echo $i;?> </td>
					<td> 
						<?php echo getJobStockItemList('category_'.$i);?>
					</td>
					<td> <input type="text" class="form-control"  name="details_<?php echo $i;?>" id="details_<?php echo $i;?>"> </td>
					<td> <input type="text" class="form-control" name="qty_<?php echo $i;?>" id="qty_<?php echo $i;?>" style="width:80px;"> </td>
					<td> <input type="text" class="form-control job_rate_class" data-id="<?php echo $i;?>" name="rate_<?php echo $i;?>" id="rate_<?php echo $i;?>" style="width:80px;"> </td>
					<td> <input type="text" class="form-control" name="subtotal_<?php echo $i;?>" id="subtotal_<?php echo $i;?>" style="width:80px;"> </td>
					
				</tr>
				
				<?php } ?>
					
				<tr>
					<td colspan="5" align="right">
						Sub Total :
					</td>
					<td>
						<input type="text" id="sub_total" name="sub_total">
					</td>
				</tr>
				
				<tr>
					<td colspan="5" align="right">
						Advance :
					</td>
					<td>
						<input type="text" id="advance" name="advance" value="0">
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
						Payment Terms
						<textarea name="payment_term" class="form-control"></textarea>
					</td>
					<td align="right">
						Due :
					</td>
					<td>
						<input type="text" id="due" name="due">
					</td>
				</tr>
				
				
			</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="text-center"> 
				<input type="submit" name="save" value="Save" class="btn btn-primary btn-flat">
				<input type="reset" name="reset" value="Reset" class="btn btn-primary btn-flat">
			</td>
		</tr>
		</table>
	</div>
</div>


<input type="hidden" name="customer_type" id="customer_type" value="0">

<script>
function changePartyType(type)
{
	if(type == 1 )
	{
		jQuery("#new").hide();
		jQuery("#regular").show();
		jQuery("#customer_type").val(0);
		return true;
	}
	
	jQuery("#new").show();
	jQuery("#regular").hide();
	jQuery("#customer_type").val(1);
	return true;
}

function getCustomerMobileNumber()
{
	var id = jQuery("#customer_id").val();
	
	jQuery.ajax(
	{
		url: "<?php echo site_url();?>ajax/getCustomerMobileNumberById",
		data: { "id" : id },
		method: "POST",
		dataType: "json",
		success: function(data)
		{
			if(data.status == true)
			{
				jQuery("#mobile").val(data.mobile);
				return true;
			}
			
			return false;
		}
	});
}

jQuery(document).ready(function() 
{
	jQuery(".content-header").remove();
	jQuery(".navbar-static-top").remove();
	
	jQuery(".job_rate_class").on('blur', function(){
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



