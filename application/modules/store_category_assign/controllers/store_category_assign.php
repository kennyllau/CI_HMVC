<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_category_assign extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}

	function update ($item_id)
	{
		if (!is_numeric($item_id))
		{
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		// get an array of all sub categories on the site
		$this->load->module('store_categories');
		$query = $this->store_categories->get_where_custom('parent_category_id !=', '0');
		foreach ($query->result() as $row)
		{
			$sub_catgories[$row->id] = $row->category_title;
		}

		// get an array of all assigned categories
		$query = $this->get_where_custom('item_id', $item_id);
		$data['num_rows'] = $query->num_rows();
		foreach ($query->result() as $row) 
		{
			$assigned_categories[$row->category_id]	= $row->category_title;
		}

		if (!isset($assigned_categories))
		{
			$assigned_categories = "";
		}

		$data['options'] = $sub_catgories;
		$data['category_id'] = $this->input->post('category_id', true);

		$data['headline'] = "Assign Category";
		$data['item_id'] = $item_id;
		$data['flash'] = $this->session->flashdata('item');

		$data['view_file'] = "update";
		$this->load->module('templates');
		$this->templates->admin($data);

	}

	function get($order_by) 
	{
		$this->load->model('mdl_store_category_assign');
		$query = $this->mdl_store_category_assign->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) 
	{
		$this->load->model('mdl_store_category_assign');
		$query = $this->mdl_store_category_assign->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) 
	{
		$this->load->model('mdl_store_category_assign');
		$query = $this->mdl_store_category_assign->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) 
	{
		$this->load->model('mdl_store_category_assign');
		$query = $this->mdl_store_category_assign->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) 
	{
		$this->load->model('mdl_store_category_assign');
		$this->mdl_store_category_assign->_insert($data);
	}

	function _update($id, $data) 
	{
		$this->load->model('mdl_store_category_assign');
		$this->mdl_store_category_assign->_update($id, $data);
	}

	function _delete($id) 
	{
		$this->load->model('mdl_store_category_assign');
		$this->mdl_store_category_assign->_delete($id);
	}

	function count_where($column, $value) 
	{
		$this->load->model('mdl_store_category_assign');
		$count = $this->mdl_store_category_assign->count_where($column, $value);
		return $count;
	}

	function get_max()
	{
		$this->load->model('mdl_store_category_assign');
		$max_id = $this->mdl_store_category_assign->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) 
	{
		$this->load->model('mdl_store_category_assign');
		$query = $this->mdl_store_category_assign->_custom_query($mysql_query);
		return $query;
	}

}