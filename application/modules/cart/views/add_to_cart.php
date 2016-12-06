<div style="background-color: #ddd; border-radius: 7px; margin-top: 24px; padding: 7px;">

	<table class="table">
		<tr>
			<td>ID:</td>
			<td><?= $item_id ?></td>
		</tr>
		<tr>
		<?php if ($num_colors > 0 ) { ?>
			<td>Color:</td>
			<td>
		<?php
  			$additional_drop_down_code = 'class="form-control"';

  			echo form_dropdown('status', $color_options, $submitted_color, $additional_drop_down_code); 
		?> 
			</td>
		</tr>
		<?php } ?>

		<tr>
		<?php if ($num_sizes > 0 ) { ?>
			<td>Size:</td>
			<td>
		<?php
  			$additional_drop_down_code = 'class="form-control"';

  			echo form_dropdown('status', $color_options, $submitted_color, $additional_drop_down_code); 
		?> 
			</td>
		</tr>
		<?php } ?>

		<tr>
			<td>Quantity:</td>
			<td>
				<div class="col-sm-5" style="padding-left: 0px;">
					<input type="text" class="form-control">
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;"><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</button></td>
		</tr>
	</table>

</div>