<?php
require_once 'app/controllers/GuestEntryController.php';
include_once 'includes/header.php';

$guestController = new GuestEntryController();

$error = $success = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo $guestController->formatAlert('ID tamu tidak valid', 'danger');
    echo '<div class="mt-3">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
          </div>';
    include_once 'includes/footer.php';
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guestData = $guestController->processFormData($_POST);

    $result = $guestController->update($id, $guestData);

    if (is_array($result)) {
        $error = implode('<br>', $result);
        $nama = $guestData['nama'];
        $instansi = $guestData['instansi'];
        $tujuan = $guestData['tujuan'];
    } else if ($result === true) {
        $success = "Data tamu berhasil diperbarui";
    } else {
        $error = "Gagal memperbarui data tamu";
    }
}

$entry = $guestController->findById($id);
if ($entry) {
    $nama = $entry['nama'];
    $instansi = $entry['instansi'];
    $tujuan = $entry['tujuan'];
    $tanggal = $entry['tanggal'];
    $waktu = $entry['waktu'];
} else {
    echo $guestController->formatAlert('Data tamu tidak ditemukan', 'danger');
    echo '<div class="mt-3">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
          </div>';
    include_once 'includes/footer.php';
    exit();
}
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header"><i class="fas fa-edit"></i> Edit Data Tamu</h2>

        <?php if (!empty($error)) { ?>
            <?= $guestController->formatAlert($error, 'danger') ?>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <?= $guestController->formatAlert($success . '<br><a href="index.php" class="alert-link">Kembali ke daftar tamu</a> atau <a href="read.php?id=' . $id . '" class="alert-link">Lihat detail tamu</a>', 'success') ?>
        <?php } ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap*</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= htmlspecialchars($nama) ?>" required>
                        <div class="invalid-feedback">
                            Harap masukkan nama.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi*</label>
                        <input type="text" class="form-control" id="instansi" name="instansi"
                            value="<?= htmlspecialchars($instansi) ?>" required>
                        <div class="invalid-feedback">
                            Harap masukkan nama instansi.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan Kunjungan*</label>
                        <textarea class="form-control" id="tujuan" name="tujuan" rows="4" required><?= htmlspecialchars($tujuan) ?></textarea>
                        <div class="invalid-feedback">
                            Harap masukkan tujuan kunjungan.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="index.php" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                            <a href="read.php?id=<?= $id ?>" class="btn btn-info">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui Data
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