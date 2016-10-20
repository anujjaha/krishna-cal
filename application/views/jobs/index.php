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
		
			<a href="<?php echo site_url();?>jobs/add">
				Add More
			</a>	
		</div>
		
		<div class="box-body">
			<table id="datatable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Sr</th>
					<th>Customer Name</th>
					<th>Job Name</th>
					<th>Sub Total</th>
					<th>Advance</th>
					<th>Due</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
				<tbody>
			<?php
				$sr = 1;
				foreach($jobs as $job) {
					$name = $job['company_name'] ? $job['company_name'] : $job['name'];
			?>
				<tr>
					<td> <?php echo $sr;?> 							</td>
					<td> <?php echo $name;?> 	</td>
					<td> <?php echo $job['job_name'];?> 			</td>
					<td> <?php echo $job['job_total'];?> 			</td>
					<td> <?php echo $job['job_advance'];?> 		</td>
					<td> <?php echo $job['job_due'];?> 		</td>
					<td> <?php echo $job['job_status'];?> 		</td>
					<td>
						<a href="<?php echo site_url();?>jobs/jobprint/<?php echo $job['job_id'];?>">
							Print
						</a>
						|| 
						<a href="#job_view" class="fancybox" onclick="quickEditJob('<?php echo $job['job_id'];?>');">
							QuickEdit
						</a>
						|| 
						<a href="<?php echo site_url();?>jobs/edit/<?php echo $job['job_id'];?>">
							Edit
						</a>
						|| 
						<a href="<?php echo site_url();?>jobs/edit/<?php echo $job['job_id'];?>">
							Delete
						</a>
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

    jQuery('.fancybox').fancybox(
    {
		'width':1000,
        'height':600,
        'autoSize' : false,
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

function quickEditJob(jobId)
{
	jQuery.ajax(
	{
		url : "<?php echo site_url();?>ajax/getAjaxQuickJobEdit",
		type : 'POST',
		data : { "id": jobId},
		dataType: "html",
		success: function(data)
		{	
			jQuery("#job_view").html(data);
		}
	});
}


function payJob(jobId, customerIid)
{
	var amount 	= jQuery("#amount").val(),
		details	= jQuery("#details").val();
	
	if(amount.length < 1 ) 
	{
		alert("Must require Valid Amount");
		jQuery("#amount").focus();
		return false;
	}
	
	jQuery("#saveButton").prop('disabled', true);
	
	jQuery.ajax({
		url : "<?php echo site_url();?>ajax/ajaxPayJob",
		type : 'POST',
		data : { "jobId": jobId, "amount": amount, "details":details, 'customerIid': customerIid},
		dataType: "json",
		success: function(data)
				{	
					if(data.status == true)
					{
						alert("Payment Added - Please Refresh To Check Effect.");
						jQuery.fancybox.close();
					}
					else
					{
						alert("Contact Support");
					}
					
					jQuery("#saveButton").prop('disabled', false);
					return true;
				}
	});
	
}
</script>            
