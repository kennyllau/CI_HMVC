<style type="text/css">

 .cleditorMain{ 

  width: 670px !important;

 }

</style>
<h1><?= $headline ?></h1>
<?php 
	$manage_item_url = base_url()."blog/manage";
?>
	<p style="margin-top: 50px;">
	<a href="<?= $manage_item_url ?>"><button type="button" class="btn btn-primary">Manage Blog Entrys</button></a>
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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Blog Entry Details</h2>
			<div class="box-icon">
				<!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

<?php
	$form_location = base_url()."blog/create/".$update_id;
?>
		<div class="box-content">
			<form class="form-horizontal" action="<?= $form_location ?>" method="post">
				<fieldset>

					<div class="control-group">
						<label class="control-label" for="typeahead">Blog Entry Title </label>
					    <div class="controls">
							<input type="text" class="span6" name="page_title" value="<?= $page_title ?>">
					  	</div>
					</div> 

					<div class="control-group hidden-phone">
						<label class="control-label">Blog Entry Keywords</label>
						<div class="controls">
							<textarea rows="3" class="span6" name="page_keywords"><?= $page_keywords?></textarea>
						</div>
					</div>

					<div class="control-group hidden-phone">
						<label class="control-label">Blog Entry Description</label>
						<div class="controls">
							<textarea rows="3" class="span6" name="page_description"><?= $page_description?></textarea>
						</div>
					</div>

					<div class="control-group hidden-phone">
						<label class="control-label" for="textarea2">Blog Entry Content</label>
						<div class="controls">
							<textarea class="cleditor" id="textarea2" rows="3" name="page_content"><?= $page_content?></textarea>
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-primary" name="submit" value="Submit">Save changes</button>
						<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
					</div>
				</fieldset>
			</form>   
		</div>
	</div><!--/span-->
</div> <!-- /row -->
<?php
	if (is_numeric($update_id)) { ?> 
	<!-- if there is an update id, this div buttons will appear -->
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon white edit"></i><span class="break"></span>Additional Options</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			<div class="box-content">

				<a href="<?= base_url().$page_url ?>"><button type="button" class="btn btn-default">View Blog Entry</button></a>
				<?php
					if ($update_id > 2) { ?>
				<a href="<?= base_url() ?>blog/deleteconf/<?= $update_id ?>"><button type="button" class="btn btn-danger">Delete Blog Entry</button></a>
				<?php } ?>

			</div>
		</div><!--/span-->
	</div><!--/row-->
	<?php
	}
?>
