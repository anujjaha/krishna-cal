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
		</table>
	</div>
