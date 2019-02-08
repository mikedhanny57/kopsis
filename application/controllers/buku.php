<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('login')!=TRUE) {
			redirect('admin/login','refresh');
		}
		$this->load->model('m_buku','buku');
	}

	public function index()
	{
		$data['tampil_buku']=$this->buku->tampil();
		$data['kategori']=$this->buku->data_kategori();
		$data['konten']="v_buku";
		$data['judul']="Daftar Barang";
		$this->load->view('template', $data);
	}
	public function toko()
	{
		$data['tampil_buku']=$this->buku->tampil();
		$data['kategori']=$this->buku->data_kategori();
		$data['konten']="toko";
		$data['judul']="Barang";
		$this->load->view('template', $data);
	}
	public function tambah()
	{
		$this->form_validation->set_rules('nama_alat', 'nama_alat', 'trim|required');
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('harga', 'harga', 'trim|required');
		$this->form_validation->set_rules('stok', 'stok', 'trim|required');
		if ($this->form_validation->run()==TRUE) {
			$config['upload_path'] = './assets/img/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '1000';
			$config['max_width']  = '5000';
			$config['max_height']  = '5000';
			if ($_FILES['foto_cover']['name']!="") {
				$this->load->library('upload', $config);

				if (! $this->upload->do_upload('foto_cover')) {
					$this->session->set_flashdata('pesan', $this->upload->display_errors());
				}else {
					if ($this->buku->simpan_buku($this->upload->data('file_name'))) {
						$this->session->set_flashdata('pesan', 'Sukses menambah ');
					}else{
						$this->session->set_flashdata('pesan', 'Gagal menambah');
					}
					redirect('buku','refresh');
				}
			}else{
				if ($this->buku->simpan_buku('')) {
					$this->session->set_flashdata('pesan', 'Sukses menambah');
				}else{
					$this->session->set_flashdata('pesan', 'Gagal menambah');
				}
				redirect('buku','refresh');
			}

		}else{
			$this->session->set_flashdata('pesan', validation_errors());
			redirect('buku','refresh');
		}
	}
	public function edit_buku($id)
	{
		$data=$this->buku->detail($id);
		echo json_encode($data);
	}
	public function buku_update()
	{
		if($this->input->post('edit')){
			if($_FILES['foto_cover']['name']==""){
				if($this->buku->edit_buku()){
					$this->session->set_flashdata('pesan', 'Sukses update');
					redirect('buku');
				} else {
					$this->session->set_flashdata('pesan', 'Gagal update');
					redirect('buku');
				}
			} else {
				$config['upload_path'] = './assets/img/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']  = '20000';
				$config['max_width']  = '5024';
				$config['max_height']  = '5768';

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('foto_cover')){
					$this->session->set_flashdata('pesan', 'Gagal Upload');
					redirect('buku');
				}
				else{
					if($this->buku->edit_buku_dengan_foto($this->upload->data('file_name'))){
						$this->session->set_flashdata('pesan', 'Sukses update');
						redirect('buku');
					} else {
						$this->session->set_flashdata('pesan', 'Gagal update');
						redirect('buku');
					}
				}
			}

		}

	}
	public function hapus($id_alat='')
	{
		if ($this->buku->hapus_buku($id_alat)) {
			$this->session->set_flashdata('pesan', 'Sukses Hapus buku');
			redirect('buku','refresh');
		}else{
			$this->session->set_flashdata('pesan', 'Gagal Hapus buku');
			redirect('buku','refresh');
		}
	}

}

/* End of file Buku.php */
/* Location: ./application/controllers/Buku.php */
