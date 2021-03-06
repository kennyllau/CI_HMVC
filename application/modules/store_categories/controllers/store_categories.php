<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_categories extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}

	function view ($update_id)
	{
		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		// fetch the item
		$data = $this->fetch_data_from_db($update_id);


		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
		$data['view_module'] = 'store_categories';
		$data['view_file'] = "view";
		$this->load->module('templates');
		$this->templates->public_bootstrap($data);
	}

	function _get_category_id_from_category_url($category_url)
	{
		$query = $this->get_where_custom('category_url', $category_url);
		foreach($query->result() as $row)
		{
			$category_id = $row->id;
		}

		if (!isset($category_id))
		{
			$category_id = 0;
		}

		return $category_id;
	}

	// function update all the null rows for store_categories category_url
	// function fix ()
	// {
	// 	$query = $this->get('id');
	// 	foreach($query->result() as $row)
	// 	{
	// 		$data['category_url'] = url_title($row->category_title);
	// 		$this->_update($row->id, $data);
	// 	}

	// 	echo "finished updateing url";
	// }

	function _draw_top_nav ()
	{
		$mysql_query = "select * from store_categories where parent_category_id = 0 order by priority";
		$query = $this->_custom_query($mysql_query);
		foreach( $query->result() as $row)
		{
			$parent_categories[$row->id] = $row->category_title;
		}

		$this->load->module('site_settings');
		$items_segments = $this->site_settings->_get_items_segments();
		$data['target_url_start'] = base_url().$items_segments;

		$data['parent_categories'] = $parent_categories;
		$this->load->view('top_nav', $data);
	}

	function _get_parent_category_title ($update_id)
	{
		$data = $this->fetch_data_from_db($update_id);
		$parent_category_id = $data['parent_category_id'];
		$parent_category_title = $this->_get_category_title($parent_category_id);
		return $parent_category_title;
	}

	function _get_all_sub_cats_for_dropdown ()
	{
		// NOTE: this gets used on store_category_assign
		$mysql_query = "select * from store_categories where parent_category_id != 0 order by parent_category_id, category_title";
		$query = $this->_custom_query($mysql_query);
		foreach($query->result() as $row)
		{
			$parent_category_title = $this->_get_category_title($row->parent_category_id);
			$sub_categories[$row->id] = $parent_category_title." > ".$row->category_title;
		}

		if (!isset($sub_categories))
		{
			$sub_categories = "";
		}

		return $sub_categories;
	}

	function sort ()
	{
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$number = $this->input->post('number', true);
		for ($i=0; $i<=$number; $i++)
		{
			$update_id = $_POST['order'.$i];
			$data['priority'] = $i;
			$this->_update($update_id, $data);
		}


		// to test posted info column
		// $info = "The following was posted
		// ";
		// foreach ($_POST as $key => $value) {
		// 	$info.= "key of $key with value of $value
		// 	";

		// }
		// $data['posted_info'] = $info;
		// $update_id = 1;
		// $this->_update($update_id, $data);
	}

	function _draw_sortable_list ($parent_category_id)
	{
		// $data['query'] = $this->get_where_custom('parent_category_id', $parent_category_id);
		$mysql_query = "select * from store_categories where parent_category_id = $parent_category_id order by priority";
		$data['query'] = $this->_custom_query($mysql_query);
		$this->load->view('sortable_list', $data);	
	}

	function _count_sub_categories($update_id)
	{
		// return the number of sub categories, belonging to this category
		$query = $this->get_where_custom('parent_category_id', $update_id);
		$num_rows = $query->num_rows();

		return $num_rows;
	}

	function _get_category_title ($update_id)
	{
		$data = $this->fetch_data_from_db($update_id);
		$category_title = $data['category_title'];

		return $category_title;
	}

	function fetch_data_from_post ()
	{
		$data['category_title'] = $this->input->post('category_title', true);
		$data['parent_category_id'] = $this->input->post('parent_category_id', true);

		return $data;
	}

	function fetch_data_from_db ($update_id)
	{

		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}

		$query= $this->get_where($update_id);
		foreach($query->result() as $row )
		{
			$data['category_title'] = $row->category_title;
			$data['category_url'] = $row->category_url;
			$data['parent_category_id'] = $row->parent_category_id;
		}

		if(!isset($data))
		{
			$data = "";
		}

		return $data;
	}

	function _get_dropdown_options($update_id)
	{
		if (!is_numeric($update_id))
		{
			$update_id = 0;
		}

		$options[''] = "Please Select...";
		// build array of all parent categories
		// dont want the category that we are already on to be an option
		$mysql_query = "select * from store_categories where parent_category_id = 0 and id != $update_id";
		$query = $this->_custom_query($mysql_query);

		foreach($query->result() as $row)
		{
			$options[$row->id] = $row->category_title;
		}

		return $options;
	}

	function create()
	{
		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$update_id = $this->uri->segment(3);
		$submit = $this->input->post('submit', true);

		if ($submit == "Submit")
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category_title', 'Category Title', 'required|max_length[35]');

			if ($this->form_validation->run() == TRUE)
			{
				// get the variables
				$data = $this->fetch_data_from_post();
				$data['category_url'] = url_title($data['category_title']);

				if (is_numeric($update_id))
				{
					// update the category details
					$this->_update($update_id, $data);
					$flash_msg = "The category details were successfully updated.";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_categories/create/'.$update_id);
				} else {
					// insert new category
					$this->_insert($data);
					$update_id = $this->get_max(); // get ID of new category
					$flash_msg = "The category was successfully added";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_categories/create/'.$update_id);
				}
			}
		} elseif ($submit == "Cancel") {
			redirect('store_categories/manage');
		}

		if ((is_numeric($update_id)) && ($submit != "Submit"))
		{
			$data = $this->fetch_data_from_db($update_id);
		} else {
			$data = $this->fetch_data_from_post();
		}

		if (!is_numeric($update_id))
		{
			$data['headline'] = "Add New Category";
		} else {
			$data['headline'] = "Update Category";
		}

		// _get_dropdown_options function above^
		$data['options'] = $this->_get_dropdown_options($update_id);
		$data['num_dropdown_options'] = count($data['options']);

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
		$data['view_file'] = "create";
		$this->load->module('templates');
		$this->templates->admin($data);
	}

	function manage()
	{
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$parent_category_id = $this->uri->segment(3);
		if (!is_numeric($parent_category_id))
		{
			$parent_category_id = 0;
		}

		$data['sort_this'] = true;

		$data['parent_category_id'] = $parent_category_id;
		$data['flash'] = $this->session->flashdata('item');

		$data['query'] = $this->get_where_custom('parent_category_id', $parent_category_id);		
		$data['view_file'] = "manage";
		$this->load->module('templates');
		$this->templates->admin($data);
	}

	function get($order_by) 
	{
		$this->load->model('mdl_store_categories');
		$query = $this->mdl_store_categories->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) 
	{
		$this->load->model('mdl_store_categories');
		$query = $this->mdl_store_categories->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) 
	{
		$this->load->model('mdl_store_categories');
		$query = $this->mdl_store_categories->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) 
	{
		$this->load->model('mdl_store_categories');
		$query = $this->mdl_store_categories->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) 
	{
		$this->load->model('mdl_store_categories');
		$this->mdl_store_categories->_insert($data);
	}

	function _update($id, $data) 
	{
		$this->load->model('mdl_store_categories');
		$this->mdl_store_categories->_update($id, $data);
	}

	function _delete($id) 
	{
		$this->load->model('mdl_store_categories');
		$this->mdl_store_categories->_delete($id);
	}

	function count_where($column, $value) 
	{
		$this->load->model('mdl_store_categories');
		$count = $this->mdl_store_categories->count_where($column, $value);
		return $count;
	}

	function get_max()
	{
		$this->load->model('mdl_store_categories');
		$max_id = $this->mdl_store_categories->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) 
	{
		$this->load->model('mdl_store_categories');
		$query = $this->mdl_store_categories->_custom_query($mysql_query);
		return $query;
	}

}