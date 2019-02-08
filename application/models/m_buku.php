<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Buku extends CI_Model {
    public function tampil()
    {
        $tm_buku=$this->db
                      ->join('kategori','kategori.id_kategori=buku.id_kategori')
                      ->get('buku')
                      ->result();
        return $tm_buku;
    }
    public function data_kategori()
    {
        return $this->db->get('kategori')
                        ->result();
    }
    public function simpan_buku($file_cover)
    {
        if ($file_cover=="") {
             $object = array(
                'id_alat' => $this->input->post('id_alat'),
                'nama_alat' => $this->input->post('nama_alat'),
                'id_kategori' => $this->input->post('id_kategori'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok')
             );
        }else{
            $object = array(
                'id_alat' => $this->input->post('id_alat'),
                'nama_alat' => $this->input->post('nama_alat'),
                'id_kategori' => $this->input->post('id_kategori'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok'),
                'foto_cover' => $file_cover
             );
        }
        return $this->db->insert('buku', $object);
    }
    public function detail($a)
    {
        $tm_buku=$this->db
                      ->join('kategori', 'kategori.id_kategori=buku.id_kategori')
                      ->where('id_alat', $a)
                      ->get('buku')
                      ->row();
        return $tm_buku;
    }
    public function edit_buku()
    {
        $data = array(
                // 'id_alat' => $this->input->post('id_alat'),
                'nama_alat' => $this->input->post('nama_alat'),
                'id_kategori' => $this->input->post('id_kategori'),
                'stok' => $this->input->post('stok'),
                'harga' => $this->input->post('harga')

            );

        return $this->db->where('id_alat', $this->input->post('id_buku_lama'))
                        ->update('buku', $data);
    }
    public function edit_buku_dengan_foto($file_cover)
    {
        $data = array(
                // 'id_alat' => $this->input->post('id_alat'),
                'nama_alat' => $this->input->post('nama_alat'),
                'id_kategori' => $this->input->post('id_kategori'),
                'stok' => $this->input->post('stok'),
                'harga' => $this->input->post('harga'),
                'foto_cover' => $file_cover

            );

        return $this->db->where('id_alat', $this->input->post('id_buku_lama'))
                        ->update('buku', $data);
    }
    public function hapus_buku($id_alat='')
    {
        return $this->db->where('id_alat', $id_alat)
                    ->delete('buku');
    }


}

/* End of file M_buku.php */
/* Location: ./application/models/M_buku.php */
