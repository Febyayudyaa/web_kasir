<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'tb_produk';
    protected $primaryKey = 'produk_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;  // Sesuaikan dengan kebutuhan (false jika tidak menggunakan soft deletes)
    protected $protectFields = true;
    protected $allowedFields = ['nama_produk', 'harga', 'stok'];

    protected $dateFormat = 'datetime'; 
    protected $updatedField = 'updated_at';

    // Fungsi untuk menghapus produk berdasarkan id
    public function deleteProduct($id)
    {
        // Pastikan id valid dan data ada sebelum menghapus
        return $this->where('produk_id', $id)->delete();
    }
}
