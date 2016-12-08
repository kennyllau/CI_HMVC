<h1><?= $headline ?></h1>
<?php 
	$manage_item_url = base_url()."store_accounts/manage";
?>
	<p style="margin-top: 50px;">
	<a href="<?= $manage_item_url ?>"><button type="button" class="btn btn-primary">Manage Accounts</button></a>
	</p> 
<?= validation_errors("<p style='color: red;'>", "</p>") ?>
<?php
	if (isset($flash))
	{
		echo $flash;
	}

	if (is_numeric($update_id)) { ?> 
	<!-- if there is an update id, this div buttons will appear -->
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon white edit"></i><span class="break"></span>Account Options</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			<div class="box-content">

				<a href="<?= base_url() ?>store_accounts/update_password/<?= $update_id ?>"><button type="button" class="btn btn-primary">Update Password</button></a>
				<a href="<?= base_url() ?>store_accounts/deleteconf/<?= $update_id ?>"><button type="button" class="btn btn-danger">Delete Account</button></a>

			</div>
		</div><!--/span-->
	</div><!--/row-->

<?php } ?>

<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Account Details</h2>
			<div class="box-icon">
				<!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

<?php
	$form_location = base_url()."store_accounts/create/".$update_id;
?>
		<div class="box-content">
			<form class="form-horizontal" action="<?= $form_location ?>" method="post">
				<fieldset>
					<div class="control-group"> 
						<label class="control-label" for="typeahead">First Name </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="first_name" value="<?= $first_name ?>"> 
						</div> 
					</div>
					<div class="control-group"> 
						<label class="control-label" for="typeahead">Last Name </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="last_name" value="<?= $last_name ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Company </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="company" value="<?= $company ?>"> 
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Address Line 1 </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="address1" value="<?= $address1 ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Address Line 2 </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="address2" value="<?= $address2 ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">City </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="city" value="<?= $city ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">State </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="state" value="<?= $state ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Postal Code </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="postal_code" value="<?= $postal_code ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Phone Number </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="phone_number" value="<?= $phone_number ?>"> 
						</div> 
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Email </label> 
						<div class="controls"> 
							<input type="text" class="span6" name="email" value="<?= $email ?>"> 
						</div> 
					</div>


					<div class="form-actions">
						<button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
						<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
					</div>
				</fieldset>
			</form>   
		</div>
	</div><!--/span-->
</div> <!-- /row -->