<?php
require_once 'app/controllers/GuestEntryController.php';
include_once 'includes/header.php';

$guestController = new GuestEntryController();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo showAlert('ID tamu tidak valid', 'danger');
    echo '<div class="mt-3">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
          </div>';
    include_once 'includes/footer.php';
    exit();
}

$id = intval($_GET['id']);

$entry = $guestController->findById($id);

if (!$entry) {
    echo showAlert('Data tamu tidak ditemukan', 'danger');
    echo '<div class="mt-3">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
          </div>';
    include_once 'includes/footer.php';
    exit();
}

if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
    if ($guestController->delete($id)) {
        echo "<script>
                alert('Data tamu berhasil dihapus');
                window.location.href='index.php';
              </script>";
    } else {
        echo showAlert('Gagal menghapus data tamu', 'danger');
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header"><i class="fas fa-trash"></i> Hapus Data Tamu</h2>

        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">Konfirmasi Penghapusan</h5>
            </div>
            <div class="card-body">
                <p>Apakah Anda yakin ingin menghapus data tamu ini?</p>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan!
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">ID</th>
                                <td><?= $entry['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td><?= htmlspecialchars($entry['nama']) ?></td>
                            </tr>
                            <tr>
                                <th>Instansi</th>
                                <td><?= htmlspecialchars($entry['instansi']) ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Kunjungan</th>
                                <td><?= $guestController->formatDate($entry['tanggal']) ?></td>
                            </tr>
                            <tr>
                                <th>Waktu Kunjungan</th>
                                <td><?= $entry['waktu'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post" class="mt-4">
                    <input type="hidden" name="confirm_delete" value="yes">
                    <div class="d-flex">
                        <a href="index.php" class="btn btn-secondary me-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Data Tamu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>