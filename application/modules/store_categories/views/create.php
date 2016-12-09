<h1><?= $headline ?></h1>
<?php 
	$manage_item_url = base_url()."store_items/manage";
?>
	<p style="margin-top: 50px;">
	<a href="<?= $manage_item_url ?>"><button type="button" class="btn btn-primary">Manage Items</button></a>
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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Create New Category</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

<?php
	$form_location = base_url()."store_categories/create/".$update_id;
?>
		<div class="box-content">
			<form class="form-horizontal" action="<?= $form_location ?>" method="post">
				<fieldset>

					<div class="control-group">
						<label class="control-label" for="typeahead">Category Title </label>
					    <div class="controls">
							<input type="text" class="span6" name="category_title" value="<?= $category_title ?>">
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

