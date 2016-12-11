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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>New Category</h2>
			<div class="box-icon">
				<!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

<?php
	$form_location = base_url()."store_item_colors/submit/".$item_id;
?>
		<div class="box-content">
		<p>Submit new categories as required. </p>
			<form class="form-horizontal" action="<?= $form_location ?>" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="typeahead">New Option </label>
					    <div class="controls">
							
					    <?php
					    	$additional_dd_code = 'id="selectError3"';
					    	echo form_dropdown('category_id', $options, $category_id, $additional_dd_code); 
					    ?>

					  	</div>
					</div> 

						<div class="form-actions">
							<button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
							<button type="submit" class="btn" name="submit" value="Finished">Finished</button>
						</div>
				</fieldset>
			</form>   
		</div>
	</div><!--/span-->
</div> <!-- /row -->


<?php if ($num_rows > 0) { ?>
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Existing Color Options</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr>
					  <th>Count</th>
					  <th>Color</th>
					  <th>Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
<?php
	$count = 0; 
	foreach($query->result() as $row) { 
		$count++;
		$delete_url = base_url()."store_item_colors/delete/".$row->id;
?>
				<tr>
					<td><?= $count ?></td>
					<td class="center"><?= $row->color ?></td>
				
					<td class="center">
						<a class="btn btn-danger" href="<?= $delete_url ?>">
							<i class="halflings-icon white trash"></i>Remove Option  
						</a>					
					</td>
				</tr>
<?php } ?>
			  </tbody>
		  </table>            
		</div>
	</div><!--/span-->

</div><!--/row-->
<?php } ?>