<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_accounts extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}
	function manage()
	{
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['flash'] = $this->session->flashdata('item');

		$data['query'] = $this->get('last_name');		
		// $data['view_module'] = "store_items";
		$data['view_file'] = "manage";
		$this->load->module('templates');
		$this->templates->admin($data);
	}
	/**    common functions    **/
	function get($order_by) 
	{
		$this->load->model('mdl_store_accounts');
		$query = $this->mdl_store_accounts->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) 
	{
		$this->load->model('mdl_store_accounts');
		$query = $this->mdl_store_accounts->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) 
	{
		$this->load->model('mdl_store_accounts');
		$query = $this->mdl_store_accounts->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) 
	{
		$this->load->model('mdl_store_accounts');
		$query = $this->mdl_store_accounts->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) 
	{
		$this->load->model('mdl_store_accounts');
		$this->mdl_store_accounts->_insert($data);
	}

	function _update($id, $data) 
	{
		$this->load->model('mdl_store_accounts');
		$this->mdl_store_accounts->_update($id, $data);
	}

	function _delete($id) 
	{
		$this->load->model('mdl_store_accounts');
		$this->mdl_store_accounts->_delete($id);
	}

	function count_where($column, $value) 
	{
		$this->load->model('mdl_store_accounts');
		$count = $this->mdl_store_accounts->count_where($column, $value);
		return $count;
	}

	function get_max()
	{
		$this->load->model('mdl_store_accounts');
		$max_id = $this->mdl_store_accounts->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) 
	{
		$this->load->model('mdl_store_accounts');
		$query = $this->mdl_store_accounts->_custom_query($mysql_query);
		return $query;
	}

}