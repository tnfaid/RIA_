<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transaksi_controller extends CI_Controller {
	
	public function __construct()
	{
	parent::__construct();
	$this->load->model('mpsb');
	}
	
	public function index()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run() == TRUE)
		{
			$password = md5($password);
			$operator = $this->mpsb->login($username, $password);
			if($operator->num_rows() > 0) //login sukses
			{
				$row = $operator->row();
				$this->session->set_userdata('username', $row->username);
				$this->session->set_userdata('realname', $row->nama_lengkap);
				$this->session->set_userdata('sudah_login', TRUE);
				redirect('transaksi_controller/home');
			}else{
				$this->session->set_flashdata('salah_login', 'Username atau Password yang dimasukkan salah.');
			}
		}
		$this->load->view('login');
		
	}

	public function home(){
		$data['tb_jual_detil'] = $this->mpsb->barang_all();
		$this->load->view('transaksi',$data);
	}

	
}
?>