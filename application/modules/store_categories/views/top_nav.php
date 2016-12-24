<ul class="nav navbar-nav">
<?php
	$this->load->module('store_categories');
	foreach($parent_categories as $key => $value)
	{
		$parent_category_id = $key;
		$parent_category_title = $value;
?>	
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $parent_category_title ?> <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <?php
    	$query = $this->store_categories->get_where_custom('parent_category_id', $parent_category_id);
    	foreach($query->result() as $row)
    	{
            $category_url = $row->category_url;
    		echo '<li><a href="'.$target_url_start.$category_url.'">'.$row->category_title.'</a></li>';
    	}
    ?>
    </ul>
  </li>
<?php
	}
?>
</ul>