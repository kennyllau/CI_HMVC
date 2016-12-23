<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_category_assign extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}

	function _delete_for_item($item_id)
	{
		$mysql_query = "delete from store_item_colors where item_id = $item_id";
		$query = $this->_custom_query($mysql_query);
	}

	function delete($update_id)
	{
		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		// fetch the item_id
		$query = $this->get_where($update_id);
		foreach($query->result() as $row)
		{
			$item_id = $row->item_id;
		}

		$this->_delete($update_id);

		$flash_msg = "The option was successfully deleted.";
		$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);

		redirect('store_category_assign/update/'.$item_id);
	}

	function submit($item_id)
	{
		if (!is_numeric($item_id))
		{
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$submit = $this->input->post('submit', true);
		$category_id = trim($this->input->post('category_id', true));

		if ($submit=="Finished")
		{
			redirect('store_items/create/'.$item_id);
		} elseif ($submit == "Submit") {
			// attempt an insert
			if($category_id!="")
			{
				$data['item_id'] = $item_id;
				$data['category_id'] = $category_id;
				$this->_insert($data);

				$this->load->module('store_categories');
				$category_title = $this->store_categories->_get_category_title($category_id);

				$flash_msg = "The item was successfully assigned ".$category_title." to the category.";
				$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
			}
		}

		redirect('store_category_assign/update/'.$item_id);

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
		$sub_categories = $this->store_categories->_get_all_sub_cats_for_dropdown();
		
		// get an array of all assigned categories
		$query = $this->get_where_custom('item_id', $item_id);
		$data['query'] = $query;
		$data['num_rows'] = $query->num_rows();

			foreach ($query->result() as $row) 
			{
				$category_title = $this->store_categories->_get_category_title($row->category_id);
				$parent_category_title = $this->store_categories->_get_parent_category_title ($row->category_id);
				$assigned_categories[$row->category_id]	= $parent_category_title. " > " .$category_title; 
			}	

			if (!isset($assigned_categories))
			{
				$assigned_categories = "";
			}
			else // the item has been assigned to at least one category
			{
				$sub_categories = array_diff($sub_categories, $assigned_categories);
			}

		$data['options'] = $sub_categories;
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