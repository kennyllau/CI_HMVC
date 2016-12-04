<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_items extends MX_Controller
{

	function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
        $this->form_validation->CI =& $this;
	}

	function do_upload($update_id)
	{
		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$submit = $this->input->post('submit', TRUE);

		if ($submit == "Cancel")
		{
			redirect('store_items/create/'.$update_id);
		}

		// taken from CI documentation
		$config['upload_path']          = './big_pics/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
            // foreach($error as $key => $value)
            // {
            // 	echo $value."<br>";
            // }
	        $data['headline'] = "Upload Image";
			$data['update_id'] = $update_id;
			$data['flash'] = $this->session->flashdata('item');
			$data['view_file'] = "upload_image";
			$this->load->module('templates');
			$this->templates->admin($data);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $data['headline'] = "Upload Success";
			$data['update_id'] = $update_id;
			$data['flash'] = $this->session->flashdata('item');
			$data['view_file'] = "upload_success";
			$this->load->module('templates');
			$this->templates->admin($data);
        }
	}

	function upload_image($update_id)
	{
		// goes to the update image view page.
		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['headline'] = "Upload Image";
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');

		$data['view_file'] = "upload_image";
		$this->load->module('templates');
		// load heirarchy module and pass $data to it
		$this->templates->admin($data);
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
			$this->form_validation->set_rules('item_title', 'Item Title', 'required|max_length[240]|callback_item_check');
			$this->form_validation->set_rules('item_price', 'Item Price', 'required|numeric');
			$this->form_validation->set_rules('was_price', 'Was Price', 'numeric');
			$this->form_validation->set_rules('status', 'Status', 'required|numeric');
			$this->form_validation->set_rules('item_description', 'Item Description', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// get the variables
				$data = $this->fetch_data_from_post();
				$data['item_url'] = url_title($data['item_title']);

				if (is_numeric($update_id))
				{
					// update the details
					$this->_update($update_id, $data);
					$flash_msg = "The item details were successfully updated.";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_items/create/'.$update_id);
				} else {
					// insert new item
					$this->_insert($data);
					$update_id = $this->get_max(); // get ID of new item
					$flash_msg = "The item was successfully added";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_items/create/'.$update_id);
				}
			}
		} elseif ($submit == "Cancel") {
			redirect('store_items/manage');
		}

		if ((is_numeric($update_id)) && ($submit != "Submit"))
		{
			$data = $this->fetch_data_from_db($update_id);
		} else {
			$data = $this->fetch_data_from_post();
		}

		if (!is_numeric($update_id))
		{
			$data['headline'] = "Add New Item";
		} else {
			$data['headline'] = "Item Details";
		}

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');

		// $data['view_module'] = "store_items";
		$data['view_file'] = "create";
		$this->load->module('templates');
		// load heirarchy module and pass $data to it
		$this->templates->admin($data);
	}

	function manage()
	{
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['query'] = $this->get('item_title');		
		// $data['view_module'] = "store_items";
		$data['view_file'] = "manage";
		$this->load->module('templates');
		$this->templates->admin($data);
	}

	function fetch_data_from_post()
	{
		$data['item_title'] = $this->input->post('item_title', true);
		$data['item_price'] = $this->input->post('item_price', true);
		$data['was_price'] = $this->input->post('was_price', true);
		$data['item_description'] = $this->input->post('item_description', true);
		$data['status'] = $this->input->post('status', true);

		return $data;
	}

	function fetch_data_from_db($update_id)
	{
		$query= $this->get_where($update_id);
		foreach($query->result() as $row )
		{
			$data['item_title'] = $row->item_title;
			$data['item_url'] = $row->item_url;
			$data['item_price'] = $row->item_price;
			$data['item_description'] = $row->item_description;
			$data['big_pic'] = $row->big_pic;
			$data['small_pic'] = $row->small_pic;
			$data['was_price'] = $row->was_price;
			$data['status'] = $row->status;
		}

		if(!isset($data))
		{
			$data = "";
		}

		return $data;
	}

	function get($order_by) 
	{
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) 
	{
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) 
	{
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) 
	{
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) 
	{
		$this->load->model('mdl_store_items');
		$this->mdl_store_items->_insert($data);
	}

	function _update($id, $data) 
	{
		$this->load->model('mdl_store_items');
		$this->mdl_store_items->_update($id, $data);
	}

	function _delete($id) 
	{
		$this->load->model('mdl_store_items');
		$this->mdl_store_items->_delete($id);
	}

	function count_where($column, $value) 
	{
		$this->load->model('mdl_store_items');
		$count = $this->mdl_store_items->count_where($column, $value);
		return $count;
	}

	function get_max() 
	{
		$this->load->model('mdl_store_items');
		$max_id = $this->mdl_store_items->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) 
	{
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_custom_query($mysql_query);
		return $query;
	}

	// all the callbacks go in the bottom
	// this function is from form validation set rules
	function item_check($str)
    {
    	$item_url = url_title($str);
    	$mysql_query = "select * from store_items where item_title='$str' and item_url='$item_url'";

    	$update_id = $this->uri->segment(3);
    	if (is_numeric($update_id))
    	{
    		$mysql_query.= "and id!=$update_id";
    	} 

    	$query = $this->_custom_query($mysql_query);
    	$num_rows = $query->num_rows();

        if ($num_rows > 0)
        {
            $this->form_validation->set_message('item_check', 'The item title you have selected is not available');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}