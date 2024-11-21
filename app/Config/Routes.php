<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Home::index');
 $routes->get('/produk', 'ProdukCopy::index');
 $routes->post('/produk/simpan', 'ProdukCopy::simpan_produk');
 $routes->get('/produk/tampil', 'ProdukCopy::tampil_produk');
 $routes->post('/produk/hapus', 'ProdukCopy::hapus');
 $routes->post('produk/update', 'ProdukCopy::update_produk');
 $routes->get('/produk/detail/(:num)', 'ProdukCopy::detail/$1');
 

// routes pelanggan
$routes->get('/pelanggan', 'Pelanggan::index'); 
$routes->get('/pelanggan/tampil', 'Pelanggan::tampil_pelanggan');
$routes->post('/pelanggan/simpan', 'Pelanggan::simpan_pelanggan');
$routes->get('/pelanggan/hapus/(:num)', 'Pelanggan::hapus_pelanggan/$1');
$routes->post('/pelanggan/update', 'Pelanggan::update');
$routes->get('/pelanggan/tampil/(:num)', 'Pelanggan::tampil_by_id/$1');
