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
?>

<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Update Account Form</h2>
			<div class="box-icon">
				<!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

<?php
	$form_location = base_url()."store_accounts/update_password/".$update_id;
?>
		<div class="box-content">
			<form class="form-horizontal" action="<?= $form_location ?>" method="post">
				<fieldset>
					<div class="control-group"> 
						<label class="control-label" for="typeahead">Password </label> 
						<div class="controls"> 
							<input type="password" class="span6" name="password" value=""> 
						</div> 
					</div>
					<div class="control-group"> 
						<label class="control-label" for="typeahead">Confirm Password </label> 
						<div class="controls"> 
							<input type="password" class="span6" name="confirm_password" value=""> 
						</div> 
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-primary" name="submit" value="Submit">Update</button>
						<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
					</div>
				</fieldset>
			</form>   
		</div>
	</div><!--/span-->
</div> <!-- /row -->