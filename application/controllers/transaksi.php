<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transaksi extends CI_Controller {

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
				redirect('transaksi/home');
			}else{
				$this->session->set_flashdata('salah_login', 'Username atau Password yang dimasukkan salah.');
			}
		}
		$this->load->view('v_login');
		
	}

	public function home(){
		$data['tb_jual_detil'] = $this->mpsb->barang_all();
		$this->load->view('v_transaksi',$data);
	}

	public function kodePel_lookup()
	{
		$keyword = (isset($_GET['term'])?$_GET['term'] : '');
		$query = $this->mpsb->kodePel_lookup($keyword);
		$kodePel = $query->result_array();
		$data_kodePel = array();
		foreach ($kodePel as $row) {
			$data_kodePel[] = array('id' => $row['kode_pelanggan'], 'value' => $row['kode_pelanggan']);
		}
		echo json_encode($data_kodePel);
	}
	public function kodeBar_lookup()
	{
		$keyword = (isset($_GET['term'])?$_GET['term'] : '');
		$query = $this->mpsb->kodeBar_lookup($keyword);
		$kodeBar = $query->result_array();
		$data_kodeBar = array();
		foreach ($kodeBar as $row) {
			$data_kodeBar[] = array('id' => $row['kode_barang'], 'value' => $row['kode_barang']);
		}
		echo json_encode($data_kodeBar);
	}
	public function	pel_by_id()
	{
		$kd = $this->input->post('term');
		$query = $this->mpsb->pel_by_id($kd);
		$pel = $query->row();
		echo json_encode($pel);
	}
	public function	bar_by_id()
	{
		$kd = $this->input->post('term');
		$query = $this->mpsb->bar_by_id($kd);
		$bar = $query->row();
		echo json_encode($bar);
	}
	public function tambah_barang()
	{
		$data['kode_barang'] = $this->input->post('kode_barang');
		$data['harga_jual'] = $this->input->post('harga_jual');
		$data['jumlah'] = $this->input->post('jumlah');
		
		$this->form_validation->set_rules('kode_barang','Kode Barang','required');
		$this->form_validation->set_rules('harga_jual','Jenis Barang','required|numeric');
		$this->form_validation->set_rules('jumlah','Jumlah','required|numeric');
		
		
		if($this->form_validation->run() == TRUE){
		
			$data_barang = array('kode_barang'=>$data['kode_barang'],
				'harga_jual'=>$data['harga_jual'],
				'jumlah'=>$data['jumlah'],
				);
			$this->mpsb->barang_add($data_barang);
		redirect('transaksi/home');
		}
		else{
			$data['submit'] = FALSE;
		}
		$this->load->view('transaksi',$data);
		
	}
}
?>
