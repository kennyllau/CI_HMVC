<style type="text/css">

 .cleditorMain{ 

  width: 670px !important;

 }

</style>

<h1><?= $page_headline ?></h1>
<?php 
	$manage_item_url = base_url()."webpages/manage";
?>
	<p style="margin-top: 50px;">
	<a href="<?= $manage_item_url ?>"><button type="button" class="btn btn-primary">Manage Pages</button></a>
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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Page Details</h2>
			<div class="box-icon">
				<!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

<?php
	$form_location = base_url()."webpages/create/".$update_id;
?>
		<div class="box-content">
			<form class="form-horizontal" action="<?= $form_location ?>" method="post">
				<fieldset>

					<div class="control-group">
						<label class="control-label" for="typeahead">Page Title </label>
					    <div class="controls">
							<input type="text" class="span6" name="page_title" value="<?= $page_title ?>">
					  	</div>
					</div> 

					<div class="control-group hidden-phone">
						<label class="control-label">Page Keywords</label>
						<div class="controls">
							<textarea rows="3" class="span6" name="page_keywords"><?= $page_keywords?></textarea>
						</div>
					</div>

					<div class="control-group hidden-phone">
						<label class="control-label">Page Description</label>
						<div class="controls">
							<textarea rows="3" class="span6" name="page_description"><?= $page_description?></textarea>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="typeahead">Page Headline </label>
					    <div class="controls">
							<input type="text" class="span6" name="page_headline" value="<?= $page_headline ?>">
					  	</div>
					</div>

					<div class="control-group hidden-phone">
						<label class="control-label" for="textarea2">Page Content</label>
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
