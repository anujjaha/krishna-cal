<div class="container">
<?php
$attributes = array('class' => 'form', 'id' => 'create_user');
echo form_open('customers/edit', $attributes);
?>	
<div class="col-md-12">
	<div class="row">
		<div class="col-md-5">
		  <div class="box box-success">
			<div class="box-header with-border">
			  <h3 class="box-title">Customer Details</h3>
			</div>
			
			<div class="box-body">
			Company Name
				<?php
				$company_name = array( 
					'name'		=> 'company_name',
					'id'		=> 'company_name',
					'class'		=> 'form-control',
					'value'		=> $customerInfo['company_name']
				);	
				echo form_input($company_name);
				?>
			</div>
			
			<div class="box-body">
			Name
				<?php
				$name = array(
					'name'		=> 'name',
					'id'		=> 'name',
					'class'		=> 'form-control',
					'required'	=> 'required',
					'value'		=> $customerInfo['name']
				);	
				echo form_input($name);
				?>
			</div>
			
			<div class="box-body">
				Mobile Number
				<?php
				$phone = array( 
					'name'		=> 'mobile',
					'id'		=> 'mobile',
					'class'		=> 'form-control',
					'required'	=> 'required',
					'value'		=> $customerInfo['mobile']
				);	
				echo form_input($phone);
				?>
			</div>
			
			<div class="box-body">
				Other Contact Number
				<?php
				$contact_number = array( 
					'name'		=> 'contact_number',
					'id'		=> 'contact_number',
					'class'		=> 'form-control',
					'value'		=> $customerInfo['contact_number']
				);	
				echo form_input($contact_number);
				?>
			</div>
			
			<div class="box-body">
				Email Id
				<?php
				$emailid = array( 
					'name'		=> 'emailid',
					'id'		=> 'emailid',
					'class'		=> 'form-control',
					'value'		=> $customerInfo['emailid']
				);	
				echo form_input($emailid);
				?>
			</div>
			
		  </div>
		</div>

		<div class="col-md-5">
		  <div class="box box-success">
			<div class="box-header with-border">
			  <h3 class="box-title">Address Details</h3>
			</div>
			
			<div class="box-body">
				Address
				<?php
				$address = array(
					'name'		=> 'address',
					'id'		=> 'address',
					'class'		=> 'form-control',
					'rows' 		=> '5',
					'value'		=> $customerInfo['address']
				);	
				echo Form_textarea($address);
				?>
			</div>
			
			<div class="box-body">
				City
				<?php
				$city = array(
					'name'		=> 'city',
					'id'		=> 'city',
					'class'		=> 'form-control',
					'value'		=> 'Ahmedabad',
					'required'	=> 'required',
					'value'		=> $customerInfo['city']
				);	
				echo form_input($city);
				?>
			</div>
			
			<div class="box-body">
				State
				<?php
				$state = array(
					'name'		=> 'state',
					'id'		=> 'state',
					'class'		=> 'form-control',
					'value' 	=> 'Gujarat',
					'required'	=> 'required',
					'value'		=> $customerInfo['state']
				);	
				echo form_input($state);
				?>
			</div>
			
			<div class="box-body">
				Pin Code
				<?php
				$pincode = array(
					'name'		=> 'pincode',
					'id'		=> 'pincode',
					'class'		=> 'form-control',
					'value' 	=> '380001',
					'required'	=> 'required',
					'value'		=> $customerInfo['pincode']
				);	
				echo form_input($pincode);
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
	
	$id = array( 
		'name'	=> 'id',
		'type' 	=> 'hidden',
		'value'	=> $customerInfo['id']
	);	
	echo form_input($id);
	
	echo form_submit('submit', 'Save',$submit);
	echo form_reset('reset', 'Reset',$reset);
?>
</div>
</div>
</div>
