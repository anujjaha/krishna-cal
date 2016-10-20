<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<section class="content">
<div class="row">
    <div class="col-xs-12">
	<div class="box">
		
		<div class="box-header">
			<h3 class="box-title">
				 <?php echo $page_title;?>
			</h3>
		
			<a href="<?php echo site_url();?>stock/add">
				Add New Stock 
			</a>	
		</div>
		
		<div class="box-body">
			<table id="datatable" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Sr</th>
					<th>Title</th>
					<th>stock</th>
					<th>Created On</th>
					<!--<th>Actions</th>-->
				</tr>
			</thead>
				<tbody>
			<?php
				$sr = 1;
				foreach($stock as $item) {
			?>
				<tr>
					<td> <?php echo $sr;?> 							</td>
					<td> <?php echo $item['title'];?> 	</td>
					<td> <?php echo $item['stock'];?> 		</td>
					<td> <?php echo $item['created_at'];?> 		</td>
					<!--<td> Delete </td>-->
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

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

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
</script>            
