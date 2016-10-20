<?php
		$compName = $jobInfo['company_name'] ? $jobInfo['company_name'] : $jobInfo['name'];
		$paymentTerms = getJobPaymentDetails($jobInfo['job_id']);
		
		$html = '<table align="center" width="90%" border="0" style="border:0px solid;font-size:9px;height:5.1in;">
		<tr>
		<td width="50%">
				<h2><strong>Job Number : '. $jobInfo['job_id'] .' </strong></h2>
			</td>
			<td>
				<h2>Date : 
				'. date('d-m-Y',strtotime($jobInfo['created_at'])) .' (
				'. date('H:i A',strtotime($jobInfo['created_at'])) .' )
				</h2>
			</td>
		</tr>
		<tr id="regular">
			<td width="50%">
				<h2> <strong>Party Name: <u> '. $compName .' </u> </strong></h2>
			</td>
			<td>
				<h2>Mobile : '. $jobInfo['mobile'] .'</h2>
			</td>
		</tr>
		<tr>
		<td colspan="2">
			<h3> <strong>Address : </strong> ' . $jobInfo['address'] . '</h3>
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%" class="table">
				<tr>
					<td colspan="2" align="right">
						<h3>Job Name : </h3>
					</td>
					<td colspan="2"><h3>
					'. $jobInfo['job_name']. '
					</h3>
					</td>
				</tr>
				<tr>
					<td style="font-size: 20px; font-weight:bold;"> Sr </td>
					<td style="font-size: 20px; font-weight:bold;"> Category </td>
					<td style="font-size: 20px; font-weight:bold;"> Details </td>
					<td style="font-size: 20px; font-weight:bold;"> Qty </td>
					<td style="font-size: 20px; font-weight:bold;"> Rate </td>
					<td style="font-size: 20px; font-weight:bold;"> Sub Total </td>
				</tr>';
				
				for($i=1; $i<= count($jobDetails); $i++)
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
				$html .= '<tr>
							<td style="font-size: 18px;"> ' .$i. ' </td>
							<td style="font-size: 18px;"> ' .$categoryValue . '</td>
							<td style="font-size: 18px;"> '. $detailsValue . ' </td>
							<td style="font-size: 18px;"> '. $qtyValue . ' </td>
							<td style="font-size: 18px;"> '. $rateValue .' </td>
							<td style="font-size: 18px;"> '. $subtotalValue.' </td>
						</tr>';
				} 
				$html .= '<tr>
							<td colspan="5"  style="font-size: 18px;" align="right">
								Sub Total :
							</td>
							<td  style="font-size: 18px;"> <strong>'. $jobInfo['job_total']. '</strong>
					</td>
				</tr>
				
				<tr>
					<td colspan="5"  style="font-size: 18px;" align="right">
						Advance :
					</td>
					<td  style="font-size: 18px;">
						<strong> '. $jobInfo['job_advance']. ' </strong>
					</td>
				</tr>
				
				<tr>
					<td  style="font-size: 18px;" colspan="4">
						<h3><strong> Payment Terms &nbsp; :  &nbsp;&nbsp;&nbsp;'. $paymentTerms . '</strong></h3>
						<br><br>
					</td>
					<td  style="font-size: 18px;" align="right">
						Due :
					</td>
					<td  style="font-size: 18px;">
						<strong>'. $jobInfo['job_due']. '</strong>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
		';
		
		$phtml = '<table align="center" border="2" style="width: 100%; border:1px solid;">
		<tr>
		<td width="50%" style=" border:1px solid;">
				<h2><strong>Job Number : '. $jobInfo['job_id'] .' </strong></h2>
			</td>
			<td style=" border:1px solid;">
				<h2>Date : 
				'. date('d-m-Y',strtotime($jobInfo['created_at'])) .' (
				'. date('H:i A',strtotime($jobInfo['created_at'])) .' )
				</h2>
			</td>
		</tr>
		<tr id="regular">
			<td width="50%" style=" border:1px solid;">
				<h2> <strong>Party Name: <u> '. $compName .' </u> </strong></h2>
			</td>
			<td style=" border:1px solid;">
				<h2>Mobile : '. $jobInfo['mobile'] .'</h2>
			</td>
		</tr>
		<tr>
		<td colspan="2" style=" border:1px solid;">
			<h3> <strong>Address : </strong> ' . $jobInfo['address'] . '</h3>
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<table align="center" border="2" style="width: 100%; border:1px solid;">
				<tr>
					<td colspan="6" align="center" width="100%" style=" border:1px solid;">
						<h3>Job Name :
					'. $jobInfo['job_name']. '
					</h3>
					</td>
				</tr>
				<tr>
					<td style="font-size: 20px; font-weight:bold; border:1px solid;"> Sr </td>
					<td style="font-size: 20px; font-weight:bold; border:1px solid;"> Category </td>
					<td style="font-size: 20px; font-weight:bold; border:1px solid;"> Details </td>
					<td style="font-size: 20px; font-weight:bold; border:1px solid;"> Qty </td>
					<td style="font-size: 20px; font-weight:bold; border:1px solid;"> Rate </td>
					<td style="font-size: 20px; font-weight:bold; border:1px solid;"> Sub Total </td>
				</tr>';
				
				for($i=1; $i<= count($jobDetails); $i++)
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
				$phtml .= '<tr>
							<td style="font-size: 18px; border:1px solid;"> ' .$i. ' </td>
							<td style="font-size: 18px; border:1px solid;"> ' .$categoryValue . '</td>
							<td style="font-size: 18px; border:1px solid;"> '. $detailsValue . ' </td>
							<td style="font-size: 18px; border:1px solid;"> '. $qtyValue . ' </td>
							<td style="font-size: 18px; border:1px solid;"> '. $rateValue .' </td>
							<td style="font-size: 18px; border:1px solid;"> '. $subtotalValue.' </td>
						</tr>';
				} 
				$phtml .= '<tr>
							<td colspan="5"  style="font-size: 18px; border:1px solid;" align="right">
								Sub Total :
							</td>
							<td  style="font-size: 18px; border:1px solid;"> <strong>'. $jobInfo['job_total']. '</strong>
					</td>
				</tr>
				
				<tr>
					<td colspan="5"  style="font-size: 18px; border:1px solid;" align="right">
						Advance :
					</td>
					<td  style="font-size: 18px; border:1px solid">
						<strong> '. $jobInfo['job_advance']. ' </strong>
					</td>
				</tr>
				
				<tr>
					<td style="font-size: 18px; border:1px solid; width:100%" colspan="4">
						<h3><strong> Payment Terms &nbsp; : </strong></h3>
						'. $paymentTerms . '
					</td>
					<td  style="font-size: 18px;  border:1px solid;" align="right">
						Due :
					</td>
					<td  style="font-size: 18px;  border:1px solid;">
						<strong>'. $jobInfo['job_due']. '</strong>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
		';
			$abcd = '<div style="height: 520px;">
						'.$phtml.'
					</div>';	
			$printhtml = $abcd.'<div style="height: 15px;"><hr></div>'.'<div style="height: 15px;"><hr></div>'.$abcd;
		?>
<?php 
	$printLink = create_pdf($printhtml, 'A4');
?>
<div class="col-md-12">
	<div class="row">

		<div class="col-md-12">
			<input type="hidden" name="printLink" id="printLink" value="<?php echo $printLink;?>">
			<a href="<?php echo $printLink;?>" target="_blank" class="btn btn-success btn-flat">PRINT NOW</a>
		</div>

		<div class="col-md-12">
			<?php echo $html; ?>
		</div>
	</div>
</div>

