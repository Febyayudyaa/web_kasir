<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Kelas migrasi untuk tabel produk
class TbProduk extends Migration
{
    // Metode untuk membuat tabel dan mendefinisikan kolom
    public function up()
    {
        // Menambahkan field (kolom) ke tabel
        $this->forge->addField([
            'produk_id' => [
                'type' => 'INT',              // Tipe data untuk kolom produk_id
                'constraint' => 11,           // Batasan ukuran (jumlah digit)
                'unsigned' => true,           // Kolom ini tidak boleh negatif
                'auto_increment' => true,     // Nilai kolom ini akan otomatis bertambah
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',          // Tipe data untuk kolom nama_produk
                'constraint' => 255,          // Batasan ukuran (maksimum 255 karakter)
            ],
            'harga_produk' => [ 
                'type' => 'DECIMAL',          // Tipe data untuk kolom harga_produk
                'constraint' => '10,2',       // Maksimal 10 digit, dengan 2 digit desimal
            ],
            'stok' => [ 
                'type' => 'INT',              // Tipe data untuk kolom stok
                'constraint' => 11,           // Batasan ukuran (jumlah digit)
            ]
        ]);
    
        // Menambahkan primary key pada kolom produk_id
        $this->forge->addKey('produk_id', true); 
        // Membuat tabel dengan nama tb_produk
        $this->forge->createTable('tb_produk'); 
    }
    
    // Metode untuk menghapus tabel saat migrasi diturunkan
    public function down()
    {
        // Menghapus tabel tb_produk
        $this->forge->dropTable('tb_produk'); 
    }
}
