<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<section class="content">
<div class="row">
    <div class="col-xs-12">
	<div class="box">
		
		<div class="box-header">
			<h3 class="box-title">
				 <?php echo $page_title;?>
			</h3>
			
			<a href="javascript:void(0);" class="btn btn-primary" id="addBalance">
				Add Balance
			</a>
			
			<div id="createBalance" class="col-md-12" style="display:none;"> 
				<div class="row">
					<div class="col-md-6">
						Amount : <input type="number"  name="amount" id="amount" class="form-control">
					</div>
					
					<div class="col-md-6">
						Details : <textarea name="details" id="details" class="form-control">Cash Added</textarea>
					</div>
					
					<div class="col-md-12 text-center">
						<button class="btn btn-success" id="saveButton">
							Save
						</button>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="box-body">
			<table id="datatable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Sr</th>
					<th>Job Id</th>
					<th>Job name</th>
					<th>Credit</th>
					<th>Debit</th>
					<th>Balance</th>
					<th>Details</th>
					<th>Created At</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$sr 		= 1;
				$balance 	= 0;
				foreach($accounts as $account) {
					
					if($account['t_type'] ==  CREDIT)
					{
						$balance = 	$balance + $account['amount'];
					}
					else
					{
						$balance = 	$balance - $account['amount'];
					}
			?>
				<tr>
					<td>
						<?php echo $sr;?>
					</td>
					<td>
						<?php echo $account['job_id'];?> 	
					</td>
					<td>
						<a href="#job_view" class="fancybox" onclick="viewJobById('<?php echo $account['job_id'];?>');">
						<?php echo $account['job_name'];?> 	
						</a>
					</td>
					<td>
						<?php 
							if($account['t_type'] ==  CREDIT)
								echo $account['amount'];
						?> 		
					</td>
					<td>
						<?php 
							if($account['t_type'] ==  DEBIT)
								echo $account['amount'];
						?> 		
					</td>
					<td>
						<?php echo $balance;?>
					</td>
					<td>
						<?php 
							echo $account['details'];
						?> 		
					</td>
					<td>
						<?php 
							echo date('d-m-Y H:i A', strtotime($account['created_at']));
						?> 		
					</td>
				</tr>
			<?php
				$sr++;
				}
			?>
			</tbody>
			</tfoot>
			</table>
		</div>
		
		<div class="container">
			<div class="row">
			<div class="col-md-12 text-center">
				<h2>Balance : <?php echo $balance;?></h2>
				<hr>
			</div>	
			
			<div class="col-md-12">
				<div class="col-md-6">
					<p>Company Name : <?php echo $customerInfo['company_name'];?></p>
					<p>Name : <?php echo $customerInfo['name'];?></p>
					<p>Contact Number : <?php echo $customerInfo['mobile'];?></p>
				</div>
				<div class="col-md-6">
					<p>Other Contact Number : <?php echo $customerInfo['contact_number'];?></p>
					<p>Email Id : <?php echo $customerInfo['emailid'];?></p>
					<p>Address : <?php echo $customerInfo['address'];?></p>
				</div>
			</div>
			</div>
		</div>
		
	</div>
	</div>
</div>
</section>

<div id="job_view" style="display:none;"></div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.fancybox.js')?>" type="text/javascript"></script>

<script type="text/javascript">
jQuery(document).ready( function()
{
	jQuery('#datatable').dataTable({
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": true,
		"bDestroy": true,
		"iDisplayLength": 50
	});
	
	jQuery("#addBalance").on('click', function()
	{
		jQuery("#createBalance").toggle();
	});
	
	jQuery("#saveButton").on('click', function()
	{
		addUserBalance();
	});
	

    jQuery('.fancybox').fancybox({
		'width':1000,
        'height':600,
        'autoSize' : false,
        'afterClose':function () {
			//fancy_box_closed();
		},
    });

});

function changeUserStatus(id, status)
{
	jQuery.ajax({
		url : "<?php echo site_url();?>ajax/changeUserStatus",
		type : 'POST',
		data : { "id":id, "status": status },
		dataType: "json",
		success: function(data)
				{
					if(data.status == true && status == 1)
					{
						var updateLink = "<a class='green' href='javascript:void(0);' onclick='changeUserStatus("+id+",0)'>Active</a>";
						jQuery("#userStatus_"+id).html(updateLink);
					}
					else if(data.status == true && status == 0)
					{
						var updateLink = "<a class='green' href='javascript:void(0);' onclick='changeUserStatus("+id+",1)'>Inactive</a>";
						jQuery("#userStatus_"+id).html(updateLink);
					}
					else
					{
						return false;
					}
				}
	});
}	

function addUserBalance()
{
	var amount 	= jQuery("#amount").val(),
		details	= jQuery("#details").val(),
		id 		= "<?php echo $customerInfo['id'];?>";
	
	if(amount.length < 1 ) 
	{
		alert("Must require Valid Amount");
		jQuery("#amount").focus();
		return false;
	}
	
	jQuery("#saveButton").prop('disabled', true);
	
	jQuery.ajax({
		url : "<?php echo site_url();?>ajax/addCashUserAccount",
		type : 'POST',
		data : { "customerId":id, "amount": amount, "details":details },
		dataType: "json",
		success: function(data)
				{	
					if(data.status == true)
					{
						alert("Account Updated - Please Refresh To Check Effect.");
					}
					else
					{
						alert("Contact Support");
					}
					
					jQuery("#createBalance").toggle();
					return true;
				}
	});
	
}

function viewJobById(id)
{
	jQuery.ajax(
	{
		url : "<?php echo site_url();?>ajax/getAjaxJobDetails",
		type : 'POST',
		data : { "id": id},
		dataType: "html",
		success: function(data)
		{	
			jQuery("#job_view").html(data);
		}
	});
}
</script>            
