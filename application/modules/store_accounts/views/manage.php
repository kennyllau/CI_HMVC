<h1>Manage Accounts</h1>
<?php
	if (isset($flash))
	{
		echo $flash;
	}
	$create_account_url = base_url()."store_accounts/create";
?>

<p style="margin-top: 50px;">
	<a href="<?= $create_account_url ?>"><button type="button" class="btn btn-success">Add New Account</button></a>
</p>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white briefcase"></i><span class="break"></span>Customer Accounts</h2>
			<div class="box-icon">
				<!-- <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a> -->
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr>
					  <th>First Name</th>
					  <th>Last Name</th>
					  <th>Company</th>
					  <th>Date Created</th>
					  <th>Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
<?php 
	foreach($query->result() as $row) 
	{ 
		$edit_account_url = base_url()."store_accounts/create/".$row->id;
		// edit_account_url is link to update Account button in inventory
		$view_accounts_url = base_url()."store_accounts/view/".$row->id;
?>
				<tr>
					<td><?= $row->first_name ?></td>
					<td class="center"><?= $row->last_name ?></td>
					<td class="center"><?= $row->company ?></td>
					<td class="center"><?= $row->date_made ?></td>

					<td class="center">

						<a class="btn btn-info" href="<?= $edit_account_url ?>">
							<i class="halflings-icon white edit"></i>  
						</a>
<!-- 									<a class="btn btn-danger" href="#">
							<i class="halflings-icon white trash"></i> 
						</a> -->
					</td>
				</tr>
<?php } ?>
			  </tbody>
		  </table>            
		</div>
	</div><!--/span-->

</div><!--/row-->