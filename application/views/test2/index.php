
            <link rel="stylesheet" type="text/css" href="<?php echo site_url();?>assets/datatable/css/jquery.dataTables.css">
            <script type="text/javascript" language="javascript" src="<?php echo site_url();?>assets/datatable/js/jquery.dataTables.js"></script>
            <script>
            jQuery(document).ready(function() {
                     jQuery("#datatable").DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "paging": true,
                    "iDisplayLength": 10,
                    "bPaginate": true,
                    "bServerSide": true,
                    "bSort": false,
                    "ajax": "<?php echo site_url();?>test2/ajax_list"
                } );
            } );
            </script>
            
            <div class="row">
            <div class="col-md-12">
                <a href="<?php echo site_url();?>/test2/add">Add New Test2 </a>
            </div>
            <div class="col-md-12">
            <table id="datatable"  class="table table-bordered" width="100%">
            <thead>
                <tr>
                <th>Sr.</th><th>Edit</th><th>Delete</th><thead></tr></table>
                    </div></div>
                    </div>