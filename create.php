<?php
require_once 'app/controllers/GuestEntryController.php';
include_once 'includes/header.php';

$guestController = new GuestEntryController();

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guestData = $guestController->processFormData($_POST);

    $result = $guestController->create($guestData);

    if (is_array($result)) {
        $error = implode('<br>', $result);
        $nama = $guestData['nama'];
        $instansi = $guestData['instansi'];
        $tujuan = $guestData['tujuan'];
        $tanggal = $guestData['tanggal'];
        $waktu = $guestData['waktu'];
    } else if ($result === true) {
        $success = "Entri tamu berhasil ditambahkan";
        $nama = $instansi = $tujuan = "";
        $tanggal = $waktu = "";
    } else {
        $error = "Gagal menambahkan entri tamu";
    }
} else {
    $nama = $instansi = $tujuan = "";
    $tanggal = $waktu = "";
}
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header"><i class="fas fa-plus-circle"></i> Tambah Buku Tamu</h2>

        <?php if (!empty($error)) { ?>
            <?= $guestController->formatAlert($error, 'danger') ?>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <?= $guestController->formatAlert($success . '<br><a href="index.php" class="alert-link">Kembali ke daftar tamu</a>', 'success') ?>
        <?php } ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap*</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= isset($nama) ? htmlspecialchars($nama) : '' ?>" required>
                        <div class="invalid-feedback">
                            Harap masukkan nama Anda.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi*</label>
                        <input type="text" class="form-control" id="instansi" name="instansi"
                            value="<?= isset($instansi) ? htmlspecialchars($instansi) : '' ?>" required>
                        <div class="invalid-feedback">
                            Harap masukkan nama instansi.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan Kunjungan*</label>
                        <textarea class="form-control" id="tujuan" name="tujuan" rows="4" required><?= isset($tujuan) ? htmlspecialchars($tujuan) : '' ?></textarea>
                        <div class="invalid-feedback">
                            Harap masukkan tujuan kunjungan Anda.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php include_once 'includes/footer.php'; ?>