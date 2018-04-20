<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class mpsb extends CI_Model
 {

 	function fetch_all()
	{
	  $query = $this->db->get("product");
	  return $query->result();
	}


 	public function barang_all()
 	{	
		$this->db->select('tb_jual_detil.*,tb_barang.*'); 	
		$this->db->from('tb_jual_detil'); 	
		$this->db->join('tb_barang','tb_jual_detil.kode_barang = tb_barang.kode_barang');
		$query = $this->db->get();
		return $query; 
 	}

 	public function kodePel_lookup($keyword)
 	{
 		$this->db->like('kode_pelanggan',$keyword);
 		return $this->db->get('tb_pelanggan');
 	}

 	public function kodeBar_lookup($keyword)
 	{
 		$this->db->like('kode_barang',$keyword);
 		return $this->db->get('tb_barang');
 	}

 	public function pel_by_id($kd)
 	{	
 		$this->db->where('kode_pelanggan',$kd); 
 		$this->db->select('*'); 	
		$this->db->from('tb_pelanggan');
		return $this->db->get();
 	}

 	public function bar_by_id($kd)
 	{	
 		$this->db->where('kode_barang',$kd); 
 		$this->db->select('*'); 	
		$this->db->from('tb_barang');
		return $this->db->get();
 	}

 	public function barang_add($data)
 	{
 		$this->db->insert('tb_jual_detil',$data);
 	}

 	public function login($username,$password)
 	{
 		$this->db->where('username',$username);
 		$this->db->where('password',$password);
 		return $this->db->get('tb_operator');
 	}

 	public function logout()
 	{
 		$this->session->session_destroy();
 		redirect('login');
 	}

 	public function barang_delete($id)
 	{
 		$this->db->where('id',$id);
 		$this->db->delete('tb_jual_detil');
 	}
 }
 ?>