<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Blog extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}
		function _process_delete($item_id)
	{
		// delete the page from blog
		$this->_delete($item_id);
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

		$submit = $this->input->post('submit', true);

		if ($submit == "Cancel")
		{
			redirect('blog/create/'.$update_id);
		} elseif ($submit == "Yes - Delete Blog Entry") {
			// process the delete item
			$this->_process_delete($update_id);
			// flash item was successfully deleted
			$flash_msg = "The blog was successfully deleted.";
			$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
			$this->session->set_flashdata('item', $value);

			redirect('blog/manage');
		}
	}

	function deleteconf($update_id)
	{
		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}
		elseif ($update_id < 3) 
		{
			// prevent deleting home and contact page
			redirect('site_security/not_allowed');
		}

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['headline'] = "Delete Blog Entry";
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
		$data['view_file'] = "deleteconf";
		$this->load->module('templates');
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
			$this->form_validation->set_rules('page_title', 'Blog Entry Title', 'required|max_length[250]');
			$this->form_validation->set_rules('page_content', 'Blog Entry Content', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// get the variables
				$data = $this->fetch_data_from_post();
				$data['page_url'] = url_title($data['page_title']);

				if (is_numeric($update_id))
				{  // update the details

					if ($update_id < 3)
					{
						unset($data['page_url']);
					}

					$this->_update($update_id, $data);
					$flash_msg = "The blog entry details were successfully updated.";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('blog/create/'.$update_id);
				} else {
					// insert new page
					$this->_insert($data);
					$update_id = $this->get_max(); // get ID of new page
					$flash_msg = "The blog entry was successfully added";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('blog/create/'.$update_id);
				}
			}
		} elseif ($submit == "Cancel") {
			redirect('blog/manage');
		}


		if ((is_numeric($update_id)) && ($submit != "Submit"))
		{
			$data = $this->fetch_data_from_db($update_id);
		} else {
			$data = $this->fetch_data_from_post();
		}

		if (!is_numeric($update_id))
		{
			$data['headline'] = "Create New Blog Entry";
		} else {
			$data['headline'] = "Update Blog Entry Details";
		}

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');

		$data['view_file'] = "create";
		$this->load->module('templates');
		// load heirarchy module and pass $data to it
		$this->templates->admin($data);
	}

	function fetch_data_from_post()
	{
		$data['page_title'] = $this->input->post('page_title', true);
		$data['page_keywords'] = $this->input->post('page_keywords', true);
		$data['page_description'] = $this->input->post('page_description', true);
		$data['page_content'] = $this->input->post('page_content', true);

		return $data;
	}

	function fetch_data_from_db($update_id)
	{

		if (!is_numeric($update_id))
		{
			redirect('site_security/not_allowed');
		}

		$query= $this->get_where($update_id);
		foreach($query->result() as $row )
		{
			$data['page_title'] = $row->page_title;
			$data['page_url'] = $row->page_url;
			$data['page_keywords'] = $row->page_keywords;
			$data['page_description'] = $row->page_description;
			$data['page_content'] = $row->page_content;
		}

		if(!isset($data))
		{
			$data = "";
		}

		return $data;
	}

	function manage ()
	{
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['flash'] = $this->session->flashdata('item');

		$data['query'] = $this->get('page_url');		

		$data['view_file'] = "manage";
		$this->load->module('templates');
		$this->templates->admin($data);
	}

	function get($order_by) 
	{
		$this->load->model('mdl_blog');
		$query = $this->mdl_blog->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) 
	{
		$this->load->model('mdl_blog');
		$query = $this->mdl_blog->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) 
	{
		$this->load->model('mdl_blog');
		$query = $this->mdl_blog->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) 
	{
		$this->load->model('mdl_blog');
		$query = $this->mdl_blog->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) 
	{
		$this->load->model('mdl_blog');
		$this->mdl_blog->_insert($data);
	}

	function _update($id, $data) 
	{
		$this->load->model('mdl_blog');
		$this->mdl_blog->_update($id, $data);
	}

	function _delete($id) 
	{
		$this->load->model('mdl_blog');
		$this->mdl_blog->_delete($id);
	}

	function count_where($column, $value) 
	{
		$this->load->model('mdl_blog');
		$count = $this->mdl_blog->count_where($column, $value);
		return $count;
	}

	function get_max()
	{
		$this->load->model('mdl_blog');
		$max_id = $this->mdl_blog->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) 
	{
		$this->load->model('mdl_blog');
		$query = $this->mdl_blog->_custom_query($mysql_query);
		return $query;
	}

}