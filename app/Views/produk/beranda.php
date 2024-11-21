<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>

    <!-- Menyertakan jQuery -->
    <script src="<?= base_url('asset/jquery-3.7.1.min.js') ?>"></script>

    <!-- Menyertakan CSS Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('asset/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">

    <!-- Menyertakan CSS Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('asset/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
</head>

<body>
    <div class="container mt-5">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Produk</h3>
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                    <i class="fa-solid fa-cart-plus"></i> Tambah Data
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="container mt-5">
                    <table class="table table-bordered" id="produkTabel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Produk -->
        <div class="modal fade" id="modalTambahProduk" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTambahProduk">
                            <div class="mb-3">
                                <label for="namaProduk" class="form-label">Nama Produk</label>
                                <input type="text" id="namaProduk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="hargaProduk" class="form-label">Harga</label>
                                <input type="number" id="hargaProduk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="stokProduk" class="form-label">Stok</label>
                                <input type="number" id="stokProduk" class="form-control" required>
                            </div>
                            <button type="button" id="btnSimpanProduk" class="btn btn-primary float-end">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Produk -->
        <div class="modal fade" id="modalEditProduk" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditProduk">
                            <input type="hidden" id="editProdukId">
                            <div class="mb-3">
                                <label for="editNamaProduk" class="form-label">Nama Produk</label>
                                <input type="text" id="editNamaProduk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editHargaProduk" class="form-label">Harga</label>
                                <input type="number" id="editHargaProduk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editStokProduk" class="form-label">Stok</label>
                                <input type="number" id="editStokProduk" class="form-control" required>
                            </div>
                            <button type="button" id="btnUpdateProduk" class="btn btn-primary float-end">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Menyertakan JavaScript -->
    <script src="<?= base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('asset/fontawesome-free-6.6.0-web/js/all.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            tampilProduk();

            // Fungsi untuk menampilkan produk
            function tampilProduk() {
                $.ajax({
                    url: '<?= base_url('produk/tampil') ?>?' + new Date().getTime(), // Menambahkan cache buster
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let rows = '';
                        $.each(data.produk, function(index, produk) {
                            rows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${produk.nama_produk}</td>
                                    <td>${produk.harga}</td>
                                    <td>${produk.stok}</td>
                                    <td>
                                        <button class="btn btn-warning btnEditProduk" data-id="${produk.produk_id}"><i class="fa fa-pencil-alt"></i> Edit</button>
                                        <button class="btn btn-danger btnHapusProduk" data-id="${produk.produk_id}"><i class="fa fa-trash-alt"></i> Hapus</button>
                                    </td>
                                </tr>`;
                        });
                        $('#produkTabel tbody').html(rows);
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memuat data produk.', 'error');
                    }
                });
            }

            // Simpan produk baru
            $('#btnSimpanProduk').on('click', function() {
                const data = {
                    nama_produk: $('#namaProduk').val(),
                    harga: $('#hargaProduk').val(),
                    stok: $('#stokProduk').val()
                };

                if (isValidForm(data)) {
                    $.ajax({
                        url: '<?= base_url('produk/simpan') ?>',
                        type: 'POST',
                        data: data,
                        success: function(response) {
                            handleResponse(response, 'Produk berhasil ditambahkan.');
                            $('#modalTambahProduk').modal('hide');
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal menambahkan produk.', 'error');
                        }
                    });
                }
            });

            // Buka modal edit produk
            $("#produkTabel").on('click', '.btnEditProduk', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('produk/detail') ?>/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.produk) {
                            $('#editProdukId').val(data.produk.produk_id);
                            $('#editNamaProduk').val(data.produk.nama_produk);
                            $('#editHargaProduk').val(data.produk.harga);
                            $('#editStokProduk').val(data.produk.stok);
                            $('#modalEditProduk').modal('show');
                            $('#btnUpdateProduk').on('click', function() {
                                const data = {
                                    id: $('#editProdukId').val(),
                                    nama_produk: $('#editNamaProduk').val(),
                                    harga: $('#editHargaProduk').val(),
                                    stok: $('#editStokProduk').val()
                                };


                                $.ajax({
                                    url: '<?= base_url('produk/update') ?>',
                                    type: 'POST',
                                    data: data,
                                    success: function(response) {
                                        handleResponse(response, 'Produk berhasil diperbarui.');
                                        $('#modalEditProduk').modal('hide');
                                    },
                                    error: function() {
                                        Swal.fire('Error', 'Gagal memperbarui produk.', 'error');
                                    }
                                });

                            });
                        } else {
                            Swal.fire('Error', 'Data produk tidak ditemukan.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memuat data produk.', 'error');
                    }
                });
            });

            // Update produk


            // Hapus produk
            $("#produkTabel").on('click', '.btnHapusProduk', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('produk/hapus') ?>',
                            type: 'POST',
                            data: {
                                id: id,
                                '<?= csrf_token() ?>': '<?= csrf_hash() ?>' // Pastikan token CSRF dikirim
                            },
                            success: function(response) {
                                console.log('Response: ', response); // Untuk melihat respons dari server
                                if (response.status === 'success') {
                                    Swal.fire('Berhasil', 'Produk berhasil dihapus.', 'success');
                                    tampilProduk(); // Refresh tabel produk
                                } else {
                                    Swal.fire('Error', response.message || 'Gagal menghapus produk.', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Error: ', error); // Melihat pesan error dari AJAX
                                Swal.fire('Error', 'Terjadi kesalahan saat menghapus produk. Coba lagi.', 'error');
                            }
                        });
                    }
                });
            });


            // Helper function to validate form data
            function isValidForm(data) {
                if (!data.nama_produk || !data.harga || !data.stok) {
                    Swal.fire('Peringatan', 'Mohon isi semua data.', 'warning');
                    return false;
                }
                return true;
            }

            // Helper function to handle response
            function handleResponse(response, successMessage) {
                if (response.status === 'success') {
                    Swal.fire('Berhasil', successMessage, 'success');
                    tampilProduk(); // Refresh tabel produk
                } else {
                    Swal.fire('Error', response.message || 'Tindakan gagal.', 'error');
                }
            }
        });
    </script>
</body>

</html>