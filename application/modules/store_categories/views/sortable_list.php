<style type="text/css">
	.sort {
		list-style: none;
		border: 1px #aaa solid;
		color: #333;
		padding: 10px;
		margin-bottom: 4px;
	}
</style>

<ul id="sortlist">
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
	<li class="sort" id="<?= $row->id ?>"><i class="icon-sort"></i><?= $row->category_title ?>

	<?= $parent_category_title ?>

					<?php if ($num_sub_category < 1 ) {
						echo "&nbsp;";
					} else {

						if ($num_sub_category == 1) {
							$entity = "Category";
						} else {
							$entity = "Categories";
						}
						$sub_category_url = base_url()."store_categories/manage/".$row->id;
					?>
						<a class="btn btn-success" href="<?= $sub_category_url ?>">
							<i class="halflings-icon white eye-open"></i>  
						<?php echo $num_sub_category." Sub ".$entity; ?>
						</a>
						<a class="btn btn-info" href="<?= $edit_category_url ?>">
							<i class="halflings-icon white edit"></i>  
						</a>
					<?php
					}
					?>


	</li>
	<?php } ?>
</ul>