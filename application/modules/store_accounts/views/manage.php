<h1>Manage Accounts</h1>
<?php
	if (isset($flash))
	{
		echo $flash;
	}
	$create_account_url = base_url()."store_accounts/create";
?>

<p style="margin-top: 50px;">
	<a href="<?= $create_account_url ?>"><button type="button" class="btn btn-primary">Add New Account</button></a>
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
		$edit_Account_url = base_url()."store_accounts/create/".$row->id;
		// edit_Account_url is link to update Account button in inventory

		$status = $row->status;

		if ($status == 1)
		{
			$status_label = "success";
			$status_description = "Active";
		} else {
			$status_label = "default";
			$status_description = "inActive";
		}
?>
				<tr>
					<td><?= $row->account_title ?></td>
					<td class="center"><?= $row->account_price ?></td>
					<td class="center"><?= $row->account_price ?></td>
					<td class="center">
						<span class="label label-<?= $status_label?>"><?= $status_description ?></span>
					</td>
					<td class="center">
						<a class="btn btn-success" href="#">
							<i class="halflings-icon white zoom-in"></i>  
						</a>
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