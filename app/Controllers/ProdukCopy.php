<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukCopy extends BaseController
{
    protected $produkmodel;

    public function __construct()
    {
        $this->produkmodel = new ProdukModel();
    }

    // Menampilkan halaman utama produk
    public function index()
    {
        return view('produk/beranda');
    }

    // Menampilkan semua produk
    public function tampil_produk()
    {
        $produk = $this->produkmodel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'produk' => $produk
        ]);
    }

    // Menyimpan produk baru
    public function simpan_produk()
    {
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga'       => $this->request->getVar('harga'),
            'stok'        => $this->request->getVar('stok'),
        ];

        if ($this->produkmodel->insert($data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Produk berhasil ditambahkan',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal menyimpan data produk',
        ]);
    }

    // Menghapus produk
    public function hapus()
    {
        // Memastikan metode yang digunakan adalah POST
            $id = $this->request->getVar('id');  // Ambil ID produk dari client
            if ($id && $this->produkmodel->delete($id)) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Produk berhasil dihapus',
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Produk tidak ditemukan atau gagal dihapus',
                ]);
            }
       
    }




    // Menampilkan detail produk (untuk edit)
    public function detail($id)
    {
        $produk = $this->produkmodel->find($id);
        if ($produk) {
            return $this->response->setJSON([
                'status' => 'success',
                'produk' => $produk,
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Produk tidak ditemukan',
            ]);
        }
    }

    // Mengupdate data produk
public function update_produk()
{
    $id = $this->request->getVar('id'); // Ambil ID dari request
    $data = [
        'nama_produk' => $this->request->getVar('nama_produk'),
        'harga'       => $this->request->getVar('harga'),
        'stok'        => $this->request->getVar('stok'),
    ];

    $this->produkmodel->update($id, $data);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Produk berhasil diperbarui',
        ]);
}

}
