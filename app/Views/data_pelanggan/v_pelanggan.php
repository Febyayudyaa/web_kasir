<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>

    <!--link bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url('asset/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">
    <!--link fontawesome-->
    <link rel="stylesheet" href="<?= base_url('asset/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
    <script src="<?= base_url("asset/jquery-3.7.1.min.js") ?>"></script>
</head>

<body>
<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <h3 class="text-center">Data Pelanggan</h3>
            <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan"><i class="fa-solid fa-cart-plus"></i>Tambah Data</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
                <table class="table table-bordered" id="pelangganTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--Data akan dimasukkan melalui ajax-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="modalTambahPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahPelanggan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="modalTambahPelangganLabel">Tambah Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPelanggan">
                        <div class="row mb-3">
                            <label for="namaPelanggan" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="alamat">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nomorTelepon" class="col-sm-4 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="nomorTelepon">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="simpanPelanggan" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

            <!-- Form Modal Edit Pelanggan -->
        <div class="modal fade" id="modalEditPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h1 class="modal-title fs-5" id="modalEditPelangganLabel">Edit Pelanggan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditPelanggan">
                            <input type="hidden" id="editIdPelanggan"> <!-- Hidden ID input untuk update -->
                            <div class="row mb-3">
                                <label for="editNamaPelanggan" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="editNamaPelanggan">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="editAlamat" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="editAlamat">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="editNomorTelepon" class="col-sm-4 col-form-label">Nomor Telepon</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="editNomorTelepon">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updatePelanggan" class="btn btn-warning">Update</button>
                    </div>
                </div>
            </div>
        </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script untuk menampilkan data pelanggan dan melakukan CRUD -->
<script>
   $(document).ready(function () {
    function tampilPelanggan() {
        $.ajax({
            url: '<?= base_url('pelanggan/tampil') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (hasil) {
                if (hasil.status === 'success') {
                    var pelangganTable = $('#pelangganTable tbody');
                    pelangganTable.empty();
                    var pelanggan = hasil.pelanggan;
                    var no = 1;

                    pelanggan.forEach(function (item) {
                        var row = '<tr>' +
                            '<td>' + no + '</td>' +
                            '<td>' + item.nama_pelanggan + '</td>' +
                            '<td>' + item.alamat + '</td>' +
                            '<td>' + item.nomor_telepon + '</td>' +
                            '<td>' +
                                '<button class="btn btn-warning btn-sm editPelanggan" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan" data-id="' + item.id_pelanggan + '"><i class="fa-solid fa-pencil"></i> Edit</button>' +
                                '<button class="btn btn-danger btn-sm hapusPelanggan" data-id="' + item.id_pelanggan + '"><i class="fa-solid fa-trash-can"></i> Hapus</button>' +
                            '</td>' +
                            '</tr>';
                        pelangganTable.append(row);
                        no++;
                    });
                } else {
                    Swal.fire('Error', 'Gagal mengambil data pelanggan.', 'error');
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'Terjadi kesalahan: ' + error, 'error');
            }
        });
    }

    tampilPelanggan();

    // Simpan data pelanggan
    $("#simpanPelanggan").on("click", function () {
        var formData = {
            nama_pelanggan: $('#namaPelanggan').val(),
            alamat: $('#alamat').val(),
            nomor_telepon: $('#nomorTelepon').val()
        };

        if (!formData.nama_pelanggan || !formData.alamat || !formData.nomor_telepon) {
            Swal.fire('Peringatan', 'Mohon isi semua data pelanggan.', 'warning');
            return;
        }

        $.ajax({
            url: '<?= base_url('pelanggan/simpan') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (hasil) {
                if (hasil.status === 'success') {
                    $('#modalTambahPelanggan').modal('hide');
                    $('#formPelanggan')[0].reset();
                    tampilPelanggan();
                    Swal.fire('Berhasil', 'Data pelanggan berhasil ditambahkan!', 'success');
                } else {
                    Swal.fire('Error', 'Gagal menyimpan data pelanggan.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Gagal menyimpan data pelanggan.', 'error');
            }
        });
    });

    // Hapus data pelanggan
    $('#pelangganTable').on('click', '.hapusPelanggan', function () {
        var idPelanggan = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pelanggan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('pelanggan/hapus') ?>/' + idPelanggan,
                    type: 'GET',
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status === 'success') {
                            tampilPelanggan();
                            Swal.fire('Berhasil', 'Data pelanggan berhasil dihapus!', 'success');
                        } else {
                            Swal.fire('Error', 'Gagal menghapus data pelanggan.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus data pelanggan.', 'error');
                    }
                });
            }
        });
    });

    // Edit data pelanggan
    $('#pelangganTable').on('click', '.editPelanggan', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('pelanggan/tampil/') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function (hasil) {
                if (hasil.status === 'success') {
                    var pelanggan = hasil.pelanggan;
                    $('#editIdPelanggan').val(pelanggan.id_pelanggan);
                    $('#editNamaPelanggan').val(pelanggan.nama_pelanggan);
                    $('#editAlamat').val(pelanggan.alamat);
                    $('#editNomorTelepon').val(pelanggan.nomor_telepon);
                    $('#modalEditPelanggan').modal('show');
                } else {
                    Swal.fire('Error', 'Gagal mengambil data untuk diedit.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Gagal mengambil data untuk diedit.', 'error');
            }
        });
    });

    // Update data pelanggan
    $('#updatePelanggan').on('click', function () {
        var formData = {
            id: $('#editIdPelanggan').val(),
            nama_pelanggan: $('#editNamaPelanggan').val(),
            alamat: $('#editAlamat').val(),
            nomor_telepon: $('#editNomorTelepon').val()
        };

        if (!formData.nama_pelanggan || !formData.alamat || !formData.nomor_telepon) {
            Swal.fire('Peringatan', 'Mohon isi semua data pelanggan.', 'warning');
            return;
        }

        $.ajax({
            url: '<?= base_url('pelanggan/update') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (hasil) {
                if (hasil.status === 'success') {
                    $('#modalEditPelanggan').modal('hide');
                    tampilPelanggan();
                    Swal.fire('Berhasil', 'Data pelanggan berhasil diperbarui!', 'success');
                } else {
                    Swal.fire('Error', 'Gagal memperbarui data pelanggan.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Gagal memperbarui data pelanggan.', 'error');
            }
        });
    });
});

</script>

<!-- Bootstrap JS -->
<script src="<?= base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
