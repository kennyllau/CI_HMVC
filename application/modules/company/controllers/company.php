<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Company extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}

	function models ()
	{
		// figure out what the item id is
		$category_url = $this->uri->segment(3);
		$this->load->module('store_categories');
		$category_id = $this->store_categories->_get_category_id_from_category_url($category_url);
		
		$this->store_categories->view($category_id);
	}

}