<?php

function getUserId()
{
	$ci = & get_instance();
	
	return $ci->ion_auth->user()->row()->id;
}
function get_users_groups() {
	$ci = & get_instance();
	$ci->db->select('*')
			->from('groups')
			->order_by('name');
	$query = $ci->db->get();
	return $query->result_array();
}

function pr($data, $status = true)
{
	if($status)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die;
	}
	
	echo "<pre>";
	print_r($data);
	echo "<pre>";
	
	return true;
}

function getPartiesDropdown()
{
	$ci = & get_instance();
	
	$ci->db->select('id,company_name,name')
		   ->from('customers')
		   ->order_by('company_name');
		   
	$query 	= $ci->db->get();
	
	$result = $query->result_array();
	
	$html 	= '<select name="customer_id" id="customer_id" class="form-control" onchange="getCustomerMobileNumber();">';
	$html  .= '<option value="0" selected>Select Customer</option>';
	foreach($result as $data)
	{
		$option = $data['company_name'] ? $data['company_name'] : $data['name'];
		
		$html .= '<option value="'.$data['id'].'"> '.$option.' </option>';
	}
	
	$html .= '</select>';
	
	return $html;
}

function addUserBalance($operation = 'add', $customerId = null, $balance = 0)
{
	if($customerId && $balance > 0)
	{
		$ci = & get_instance();
		$ci->db->select('balance')
				->from('customers')
				->where('id', $customerId);
		
		$query = $ci->db->get();
		
		if($operation == 'add')
		{
			$updateUserBalance 	= $query->row()->balance + $balance;
		}
		else
		{
			$updateUserBalance 	= $query->row()->balance - $balance;
		}
		
		$updateData 		= array('balance' => $updateUserBalance);
		
		$ci->db->where('id', $customerId);
		$ci->db->update('customers', $updateData);
		return true;
	}

	return true;
}

function getUserBalance($userId = null)
{
	if($userId)
	{
		$ci = & get_instance();
		$ci->db->select('balance')
					->from('customers')
					->where('id', $userId);
		$query = $ci->db->get();
		
		return $query->row()->balance;
	}
	
	return 0;
}

function getStockItemList($name = "title", $stockItem = null)
{
	$ci = & get_instance();
	$ci->db->select('*')
			   ->from('stock_manage')
			   ->order_by('id');

	$query = $ci->db->get();			 
	$result = $query->result_array();

	$html = "<select class='form-control' name='" . $name . "'>";
	foreach($result as $stock)
	{
		$selected = "";

		if(isset($stockItem) && $stockItem == $stock)
		{
			$selected = 'selected="selected"';
		}
		$html .= "<option ". $selected .">". $stock['title'] ."</option>";
	}

	$html .= "</select>";

	return $html;
}

function getJobStockItemList($name = "title", $stockItem = null)
{
	$ci = & get_instance();
	$ci->db->select('DISTINCT(title)')
			   ->from('stock_manage')
			   ->order_by('id');

	$query = $ci->db->get();			 
	$result = $query->result_array();

	$html = "<select class='form-control' name='" . $name . "' id='" . $name . "'>";
	foreach($result as $stock)
	{
		$selected = "";

		if(isset($stockItem) && $stockItem == $stock)
		{
			$selected = 'selected="selected"';
		}
		$html .= "<option ". $selected .">". $stock['title'] ."</option>";
	}

	$html .= "</select>";

	return $html;
}

function create_pdf($content=null,$size ='A5-L', $fileName = "krishna") {
	if($content) {
		$ci = & get_instance();

		$ci->load->library('Pdf');

		$mpdf = new mPDF('', $size,8,'',4,4,10,2,4,4);
		//$mpdf->SetHeader('CYBERA Print ART');
		$mpdf->defaultheaderfontsize=8;
		//$mpdf->SetFooter('{PAGENO}');
		$mpdf->WriteHTML($content);
		$mpdf->shrink_tables_to_fit=0;
		$mpdf->list_indent_first_level = 0;  
		$mpdf->keep_table_proportions = true;
		$fname = "pdf_receipt/".$fileName.".pdf";
		$mpdf->Output($fname,'F');
		return base_url().$fname;
	}
}

function generate_pdf($html = null, $returnLink = true)
{

}

function getJobPaymentDetails($jobId = null)
{
	$html = "";
	if($jobId)
	{
		$ci = & get_instance();
		$ci->db->select('*')
			->from('customer_account')
			->where('job_id', $jobId)
			->where('t_type', CREDIT)
			->order_by('id');
		
		$query = $ci->db->get();
		
		if($query->result_array())
		{
			$sr = 1;
			foreach($query->result_array()  as $data)
			{
				$html .= $sr.". ".$data['title']." ( ".$data['details'] .") <br>";
				$sr++;
			}
		}
	}
	return $html;
}

function getUserInfoById($customerId = null)
{
	if($customerId)
	{
		$ci=& get_instance();
		$ci->load->database(); 
		$ci->db->select('*')
			->from('customers')
			->where('id', $customerId);

		$query = $ci->db->get();

		return $query->row();
	}

	return false;
}

function send_sms($mobile, $sms_text = null) 
{
	if(! SEND_SMS )
	{
		return true;
	}

	$msg = str_replace(" ", "+", $sms_text);
	$url = "http://ip.infisms.com/smsserver/SMS10N.aspx?Userid=krishnamulti&UserPassword=kmulti123&PhoneNumber=$mobile&Text=$msg&GSM=KMULTI";
	$request = "";
	$url = urlencode($url);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, urldecode($url));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	$response = curl_exec($ch);
	curl_close($ch);
	return true;
}

function getPdfReceipt($jobInfo, $jobDetails)
{
	$compName 		= $jobInfo['company_name'] ? $jobInfo['company_name'] : $jobInfo['name'];
	$paymentTerms 	= getJobPaymentDetails($jobInfo['job_id']);

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
	return create_pdf($phtml, 'A4', 'K-Receipt');
}

function getReceiptContent($jobInfo, $jobDetails)
{
	$compName 		= $jobInfo['company_name'] ? $jobInfo['company_name'] : $jobInfo['name'];
	$paymentTerms 	= getJobPaymentDetails($jobInfo['job_id']);

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
	return $phtml;
}

function send_mail($to, $from, $fromName, $subject="Calender Job Created", $file = null, $content=null) 
{
	if(! SEND_EMAIL )
	{
		return true;
	}

	$mail = new PHPMailer();
	$mail->Host     	= "smtp.gmail.com"; // SMTP server
	$mail->SMTPAuth 	= TRUE; // enable SMTP authentication
	$mail->SMTPSecure  	= "tls"; //Secure conection
	$mail->Port        	= 587; // set the SMTP port
	$mail->Username   	= 'cyberaprintart@gmail.com'; // SMTP account username
	$mail->Password    	= 'cyb_1215@printart'; // SMTP account password
	$mail->SetFrom($from, $fromName);
	$mail->AddAddress($to);
	$mail->isHTML( TRUE );

	if($file)
	{
		$mail->AddAttachment($file);
	}
	$mail->Subject  = $subject;
	$mail->Body     = $content;
	if(!$mail->Send()) {
		//echo 'Message was not sent.';
	  	//echo 'Mailer error: ' . $mail->ErrorInfo;
		return false;
	} else {
	  return true;
	}
}

function getTodayReport()
{
	$ci=& get_instance();
	$ci->load->database(); 

	$startDatetoday = date('Y-m-d'). " 00:00:00";
	$endDatetoday = date('Y-m-d'). " 59:59:59";

	$ci->db->select('count(id) as todayJobs, SUM(job_total) as todayJobsTotal, SUM(job_advance) as todayJobsAdvance, SUM(job_due) as todayJobsDue')
		->from('jobs')
		->where("created_at >=" , $startDatetoday)
		->where("created_at <=" , $endDatetoday);;
	$query = $ci->db->get();
	return  $query->row();	
}

function getMonthlyReport($jobMonth)
{
	$ci=& get_instance();
	$ci->load->database(); 

	$ci->db->select('count(id) as monthlyJobs, SUM(job_total) as monthlyJobsTotal, SUM(job_advance) as monthlyJobsAdvance, SUM(job_due) as monthlyJobsDue')
		->from('jobs')
		->where("job_month", $jobMonth);
	$query = $ci->db->get();
	return  $query->row();	
}