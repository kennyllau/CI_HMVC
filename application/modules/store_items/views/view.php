<div class="row">
	<div class="col-md-4" style="margin-top: 24px;">
		<img src="<?= base_url()?>big_pics/<?= $big_pic ?>" class="img-responsive" alt="<?= $item_title ?>">
	</div>
	<div class="col-md-5">
		<h1><?= $item_title ?></h1>
		<div style="clear:both">
			<?= nl2br($item_description) ?>
		</div>
	</div>
	<div class="col-md-3">.col-md-3</div>
</div>