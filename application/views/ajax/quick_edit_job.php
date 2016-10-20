<div class="col-md-12">
	<div class="row">
	
		<table class="table" border="2" align="center">
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
					<?php echo $jobInfo['job_name'];?>
					</td>
				</tr>
				<tr>
					<th> Sr </th>
					<th> Category </th>
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
					<td> <?php echo $detailsValue;?> </td>
					<td> <?php echo $qtyValue;?> </td>
					<td> <?php echo $rateValue;?> </td>
					<td> <?php echo $subtotalValue;?> </td>
				</tr>
				<?php } ?>
					
				<tr>
					<td colspan="5" align="right">
						Sub Total :
					</td>
					<td>
						<?php echo $jobInfo['job_total'];?>
					</td>
				</tr>
				
				<tr>
					<td colspan="5" align="right">
						Advance :
					</td>
					<td>
						<?php echo $jobInfo['job_advance'];?>
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
						Payment Terms
						<?php echo $jobInfo['job_payment_term'];?>
					</td>
					<td align="right">
						Due :
					</td>
					<td>
						<?php echo $jobInfo['job_due'];?>
					</td>
				</tr>
			</table>
			
			</td>
		</tr>
		<?php
			if(isset($jobInfo['job_due']) && $jobInfo['job_due'] > 0)
			{
		?>
			<tr>
				<td colspan="6">
					<table class="table">
						<tr>
							<td>
								<label>Amount:</label>
								<input type="number" name="amount" id="amount" value="<?php echo $jobInfo['job_due'];?>">
							</td>

							<td>
								<label>Details:</label>
								<textarea name="details" id="details"></textarea>
							</td>

							<td>
								<button class="btn btn-success btn-flat" id="saveButton" onclick="payJob('<?php echo $jobInfo['job_id'];?>','<?php echo $jobInfo['customer_id'];?>');">
									Save Payment 
								</button>
							</td>
						</tr>
					</table>
				</td>
			</tr>

		<?php		
			}
		?>

		<tr>
			<td colspan="6" align="center">
				Status : 
				<label><input type="radio" name="job_status" value="Pending" 
				<?php if($jobInfo['job_status'] == "Pending") { echo "checked='checked'";} ?> >Pending</label>
				
				<label><input type="radio" name="job_status" value="Printing" 
				<?php if($jobInfo['job_status'] == "Printing") { echo "checked='checked'";} ?> >Printing</label>
		
				<label><input type="radio" name="job_status" value="Pattie" 
				<?php if($jobInfo['job_status'] == "Pattie") { echo "checked='checked'";} ?> >Pattie</label>
	
				<label><input type="radio" name="job_status" value="Completed"
				 <?php if($jobInfo['job_status'] == "Completed") { echo "checked='checked'"; } ?>>Completed</label>
				 
				 <a href="javascript:void(0);" class="btn btn-primary" id="updateJobStatus" onclick="updateJobStatus(<?php echo $jobInfo['job_id'];?>);">
				 	Save Status	
				 </a>	
				 <p id="message"></p>
			</td>
		</tr>
		</table>
	</div>

<script>
function updateJobStatus(jobId)
{
	var jobStatus = jQuery('input[name=job_status]:checked').val();
	jQuery.ajax(
	{
		url: "<?php echo site_url();?>/ajax/updateJobStatus",
		data: { 'job_id':jobId, 'job_status': jobStatus},
		type: "POST",
		responseType: "json",
		success: function(data)
		{
			jQuery("#message").html("<h3>Job Status Successfully Updated</h3>");
			jQuery.fancybox.close();
		}

	});
}
</script>
