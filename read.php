<?php
require_once 'app/controllers/GuestEntryController.php';
include_once 'includes/header.php';

$guestController = new GuestEntryController();

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

$entry = $guestController->findById($id);

if (!$entry) {
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-header"><i class="fas fa-eye"></i> Detail Buku Tamu</h2>
            <div>
                <a href="index.php" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <a href="update.php?id=<?= $entry['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0"><?= htmlspecialchars($entry['nama']) ?></h5>
            </div>
            <div class="card-body">
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
                                <th>Tujuan</th>
                                <td><?= nl2br(htmlspecialchars($entry['tujuan'])) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Tanggal Kunjungan</th>
                                <td><?= $guestController->formatDate($entry['tanggal']) ?></td>
                            </tr>
                            <tr>
                                <th width="30%">Waktu Kunjungan</th>
                                <td><?= $entry['waktu'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>