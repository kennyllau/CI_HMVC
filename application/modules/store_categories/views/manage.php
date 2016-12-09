<h1>Manage Categories</h1>
<?php
	if (isset($flash))
	{
		echo $flash;
	}
	$create_category_url = base_url()."store_categories/create";
?>

<p style="margin-top: 50px;">
	<a href="<?= $create_category_url ?>"><button type="button" class="btn btn-primary">Add New Category</button></a>
</p>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Existing Categories</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr>
					  <th>Category Title</th>
					  <th>Parent Category</th>
					  <th>Sub Categories</th>
					  <th>Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
<?php 
	$this->load->module('store_categories');
	foreach($query->result() as $row) 
	{
		$num_sub_category = $this->store_categories->_count_sub_categories($row->id);
		$edit_category_url = base_url()."store_categories/create/".$row->id;
		$view_category_url = base_url()."store_categories/view/".$row->id;

		if ($row->parent_category_id == 0) {
			$parent_category_title = "-";
		} else {
			$parent_category_title = $this->store_categories->_get_category_title($row->parent_category_id);
		}	
?>
				<tr>
					<td><?= $row->category_title ?></td>
					<td class="center"><?= $parent_category_title ?></td>
					<td class="center">
					<?php if ($num_sub_category < 1 ) {
						echo "-";
					} else {

						if ($num_sub_category == 1) {
							$entity = "Category";
						} else {
							$entity = "Categories";
						}
						$sub_category_url = base_url()."store_categories/manage/".$row->id;
					?>
						<a class="btn btn-success" href="<?= $sub_category_url ?>">
							<i class="halflings-icon white zoom-in"></i>  
						<?php echo $num_sub_category." ".$entity; ?>
						</a>
					<?php
					}
					?>
					</td>
					<td class="center">
						<a class="btn btn-success" href="<?= $view_category_url ?>">
							<i class="halflings-icon white zoom-in"></i>  
						</a>
						<a class="btn btn-info" href="<?= $edit_category_url ?>">
							<i class="halflings-icon white edit"></i>  
						</a>
					</td>
				</tr>
<?php } ?>
			  </tbody>
		  </table>            
		</div>
	</div><!--/span-->

</div><!--/row-->