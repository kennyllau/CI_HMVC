<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_accounts extends MX_Controller
{
	function __construct() {

		parent::__construct();

	}

	function update_password()
	{
		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$update_id = $this->uri->segment(3);
		$submit = $this->input->post('submit', true);

		if (!is_numeric($update_id))
		{
			redirect('store_accounts/manage');
		} 
		elseif ($submit == "Cancel")
		{
			redirect('store_accounts/create/'.$update_id);
		}

		if ($submit == "Submit")
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[35]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run() == TRUE)
			{
				// get the variables
				$data['password'] = $this->input->post('password', true);

				// update account details
				$this->_update($update_id, $data);
				$flash_msg = "The account password was successfully updated.";
				$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_accounts/create/'.$update_id);

			}

		} 
		elseif ($submit == "Cancel") 
		{
			redirect('store_accounts/manage');
		}

		$data['headline'] = "Update Account Password";

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');

		// $data['view_module'] = "store_items";
		$data['view_file'] = "update_password";
		$this->load->module('templates');
		// load heirarchy module and pass $data to it
		$this->templates->admin($data);
	}

	function fetch_data_from_post()
	{
		$data['first_name'] = $this->input->post('first_name', true);
		$data['last_name'] = $this->input->post('last_name', true);
		$data['company'] = $this->input->post('company', true);
		$data['address1'] = $this->input->post('address1', true);
		$data['address2'] = $this->input->post('address2', true);
		$data['city'] = $this->input->post('city', true);
		$data['state'] = $this->input->post('state', true);
		$data['postal_code'] = $this->input->post('postal_code', true);
		$data['phone_number'] = $this->input->post('phone_number', true);
		$data['email'] = $this->input->post('email', true);

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
			$data['first_name'] = $row->first_name;
			$data['last_name'] = $row->last_name;
			$data['company'] = $row->company;
			$data['address1'] = $row->address1;
			$data['address2'] = $row->address2;
			$data['city'] = $row->city;
			$data['state'] = $row->state;
			$data['postal_code'] = $row->postal_code;
			$data['phone_number'] = $row->phone_number;
			$data['email'] = $row->email;
			$data['date_made'] = $row->date_made;
			$data['password'] = $row->password;
		}

		if(!isset($data))
		{
			$data = "";
		}

		return $data;
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
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			$this->form_validation->set_rules('company', 'Company', 'required');
			$this->form_validation->set_rules('address1', 'Address Line 1', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');
			$this->form_validation->set_rules('postal_code', 'Postal Code', 'required');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// get the variables
				$data = $this->fetch_data_from_post();

				if (is_numeric($update_id))
				{
					// update account details
					$this->_update($update_id, $data);
					$flash_msg = "The account details were successfully updated.";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_accounts/create/'.$update_id);
				} else {
					// create new account
					$data['date_made'] = time();
					// save date created in unixtimestamp
					$this->_insert($data);
					$update_id = $this->get_max(); // get ID of new item
					$flash_msg = "The account was successfully added";
					$value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_accounts/create/'.$update_id);
				}
			}
		} elseif ($submit == "Cancel") {
			redirect('store_accounts/manage');
		}

		if ((is_numeric($update_id)) && ($submit != "Submit"))
		{
			$data = $this->fetch_data_from_db($update_id);
		} else {
			$data = $this->fetch_data_from_post();
		}

		if (!is_numeric($update_id))
		{
			$data['headline'] = "Add New Account";
		} else {
			$data['headline'] = "Account Details";
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

		$data['flash'] = $this->session->flashdata('Account');

		$data['query'] = $this->get('last_name');		
		// $data['view_module'] = "store_Accounts";
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

	function autogen ()
	{
		$mysql_query = "show columns from store_accounts";
		$query = $this->_custom_query($mysql_query);
		/*
		foreach ($query->result() as $row)
		{
			$column_name = $row->Field;

			if ($column_name != "id" )
			{
				// echo $column_name."<br>";
				// generate $data['first_name'] = $this->input->post('first_name', true); .. etc
				echo '$data[\''.$column_name.'\'] = $this->input->post(\''.$column_name.'\', true);<br>';
			}
		}

		echo '<br>';

		foreach ($query->result() as $row)
		{
			$column_name = $row->Field;

			if ($column_name != "id" )
			{
				// echo $column_name."<br>";
				// generate $data['first_name'] = $this->input->post('first_name', true); .. etc
				echo '$data[\''.$column_name.'\'] = $row->'.$column_name.';<br>';
			}
		}
		*/
		foreach ($query->result() as $row)
		{
			$column_name = $row->Field;

			if ($column_name != "id" )
			{

				$var = '<div class="control-group">
					<label class="control-label" for="typeahead">'.ucfirst($column_name).' </label>
				    <div class="controls">
						<input type="text" class="span6" name="'.$column_name.'" value="<?= $'.$column_name.' ?>">
				  	</div>
				</div>';

				echo htmlentities($var);
				echo '<br>'; 

			}
		}

	}

}