<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Main_query extends CI_Model {

	//common query
	public function get_all($table){
		return $this->db->get($table);
	}
	public function insert($table,$data){
		$this->db->insert($table, $data);
	}
	public function delete($table,$where){
		$this->db->where($where);
		$this->db->delete($table);
	}
	public function update($table,$where,$data){
		$this->db->where($where);
		$this->db->update($table,$data);
	}
	public function find($table,$where){
		$this->db->where($where);
		return $this->db->get($table);
	}
}
?>