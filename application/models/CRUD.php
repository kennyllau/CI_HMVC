<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function add_data($info){
		$query = "INSERT INTO products (name, description, price, created_at)
		VALUES (?,?,?,?)";
		$values = array(
			$info['name'], $info['description'], $info['price'], date("Y-m-d H:i:s"));
		return $this->db->query($query, $values);
	}


	public function get_all_products(){
		return $this->db->query('SELECT * FROM products')->result_array();
	}

	public function get_product($id){
		$query = "SELECT * FROM products where id = ?";
		$values = array($id);
		return $this->db->query($query, $values)->row_array();
	}
	

	public function delete_id($id){
		$query = "DELETE FROM products where id =?";
		$values = array( $id
			);
		return $this->db->query($query, $values);
	}

	public function update($info, $id){
		$query = "UPDATE products SET name=?, description=?, price=?, updated_at=? where id =?";
		$values = array(
				$info['name'], $info['description'], $info['price'], date("Y-m-d H:i:s"), $id
			);
		return $this->db->query($query, $values);
	}