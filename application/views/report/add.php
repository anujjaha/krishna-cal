<div class="container">
<?php
$attributes = array('class' => 'form', 'id' => 'create_stock');
echo form_open('stock/add', $attributes);
?>	
<div class="col-md-12">
	<div class="row">
		<div class="col-md-10">
		  <div class="box box-success">
			<div class="box-header with-border">
			  <h3 class="box-title">Stock Item</h3>
			</div>
			
			<div class="box-body" id="newItem" style="display: none;">
			Title
				<?php
				$title = array( 
					'name'		=> 'title',
					'id'		=> 'title',
					'class'		=> 'form-control',
				);	
				echo form_input($title);
				?>
			</div>

			<div class="box-body" id="useItem">
			Title
				<?php echo getStockItemList();?>

				<br>
				<a href="javascript:void(0);" class="btn btn-primary btn-flat" onclick="showCreateItem();">
					Create Item
				</a>
			</div>
			
			<div class="box-body">
			Stock
				<?php
				$stock = array(
					'type'		=> 'number',
					'name'		=> 'stock',
					'id'		=> 'stock',
					'class'		=> 'form-control',
					'required'	=> 'required'
				);	
				echo form_input($stock);
				?>
			</div>
			
		  </div><!-- /.box -->
		</div>
</div>
<div class="col-md-10 text-center">
<?php	
	$submit = array(
			'id'    => 'submit',
			'class' => 'btn btn-primary btn-flat'
	);

	$reset = array(
			'id'    => 'submit',
			'class' => 'btn btn-primary btn-flat'
	);

	echo form_submit('submit', 'Save',$submit);
	echo form_reset('reset', 'Reset',$reset);
?>
</div>
</div>
</div>

<script>
function showCreateItem()
{
	jQuery("#newItem").show();
	jQuery("#useItem").remove();
}
</script>