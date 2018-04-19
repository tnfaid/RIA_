<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class service extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mpsb');
	}

	public function propinsi_lookup()
	{
		$keyword = (isset($_GET['term'])?$_GET['term'] : '');
		$query = $this->mpsb->propinsi_lookup($keyword);
		$propinsi = $query->result_array();
		$data_propinsi = array();
		foreach ($propinsi as $row) {
			$data_propinsi[] = array('id' => $row['id_prov'], 'value' => $row['nama_prov']);
		}
		echo json_encode($data_propinsi);
	}

	public function kabkot_lookup()
	{
		$id_prov = (isset($_POST['id_prov'])?$_POST['id_prov'] : '');
		$keyword = (isset($_POST['term'])?$_POST['term'] : '');
		$query = $this->mpsb->kabkot_lookup($id_prov, $keyword);
		$kabkot = $query->result_array();
		$data_kabkot = array();
		foreach ($kabkot as $row) {
			$data_kabkot[] = array('id' => $row['id_kabkot'], 'value' => $row['nama_kabkot']);
		}
		echo json_encode($data_kabkot);
	}

	public function kec_lookup()
	{
		$id_kabkot = (isset($_POST['id_kabkot'])?$_POST['id_kabkot'] : '');
		$keyword = (isset($_POST['term'])?$_POST['term'] : '');
		$query = $this->mpsb->kec_lookup($id_kabkot, $keyword);
		$kec = $query->result_array();
		$data_kec = array();
		foreach ($kec as $row) {
			$data_kec[] = array('id' => $row['id_kec'], 'value' => $row['nama_kec']);
		}
		echo json_encode($data_kec);
	}

	public function barang_delete()
	{
		$id = $this->input->post('id');
		$del = $this->mpsb->barang_delete($id);
		if($del){
			echo json_encode(array('status'=>'sukses'));	
		}else{
			echo json_encode(array('status'=>'gagal'));
		}
	}

	public function	barang_add()
	{
		$data_barang = array(
		'kode_barang' => $this->input->post('kode_barang'),
		'harga_jual' => $this->input->post('harga_jual'),
		'jumlah' => $this->input->post('jumlah'));

		$insert = $this->mpsb->barang_add($data_barang);
		if($insert){
			echo json_encode(array('status'=>'sukses'));	
		}else{
			echo json_encode(array('status'=>'gagal'));
		}
	}

	public function	siswa_by_id()
	{
		$nis = $this->input->post('nis');
		$query = $this->mpsb->siswa_by_id($nis);
		$siswa = $query->row();
		echo json_encode($siswa);
	}

	public function	siswa_edit()
	{
		$nis = $this->input->post('nis');
		$data_siswa	= array('nis' =>$this->input->post('nis'),
		'nama_siswa' =>$this->input->post('nama'),
		'email' =>$this->input->post('email'),
		'tanggal_lahir' =>date('Y-m-d',strtotime($this->input->post('tanggal_lahir'))),
		'alamat' =>$this->input->post('alamat'),
		'propinsi' =>$this->input->post('id_prov'),
		'kabkot' =>$this->input->post('id_kabkot'),
		'kecamatan' =>$this->input->post('id_kec'));

		$update = $this->mpsb->siswa_edit($nis, $data_siswa);
		if($update){
			echo json_encode(array('status'=>'sukses'));	
		}else{
			echo json_encode(array('status'=>'gagal'));
		}
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
		redirect('transaksi_controller/home');
		}
		else{
			$data['submit'] = FALSE;
		}
		$this->load->view('transaksi',$data);
		
	}
}
?>