<link rel="stylesheet" type="text/css" href="<?php echo site_url();?>assets/datatable/css/jquery.dataTables.css">
<script type="text/javascript" language="javascript" src="<?php echo site_url();?>assets/datatable/js/jquery.dataTables.js"></script>
<script>
jQuery(document).ready(function() {
	 jQuery('#datatable').DataTable( {
        "processing": true,
        "serverSide": true,
        "paging": true,
        "iDisplayLength": 10,
        "bPaginate": true,
        "bServerSide": true,
        'bSort': false,
        "ajax": "<?php echo site_url();?>ajax/get_modules/1"
    } );
} );
</script>
 <section class="content">
	<div class="row">
    <div class="col-xs-12">
	<div class="box">
                <div class="box-header">
                <h3 class="box-title">
					  Module Manager
				</h3>
				<a href="<?php echo site_url();?>master/create">Add More</a>	
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="datatable" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sr</th>
								<th>Module Name</th>
								<th>Alias Name</th>
								<th>Created Date</th>
								<th>View</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
</section>
