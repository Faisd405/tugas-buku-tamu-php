<?php
require_once 'app/controllers/GuestEntryController.php';

$guestController = new GuestEntryController();

if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    if ($guestController->delete($id)) {
        echo "<script>alert('Entry deleted successfully.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to delete entry.'); window.location.href='index.php';</script>";
    }
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $keyword = $_GET['search'];
    $result = $guestController->getAll(['search' => $keyword]);
} else {
    $result = $guestController->getAll();
}
?>

<?php include_once 'includes/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="page-header"><i class="fas fa-book"></i> Buku Tamu</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="create.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Tamu
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="index.php" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau instansi..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                        <a href="index.php" class="btn btn-secondary ms-2">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (count($result) > 0) { ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover guest-table">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Nama</th>
                            <th width="15%">Instansi</th>
                            <th width="30%">Tujuan</th>
                            <th width="10%">Tanggal</th>
                            <th width="5%">Waktu</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['instansi'] ?></td>
                                <td><?= substr($row['tujuan'], 0, 50) . (strlen($row['tujuan']) > 50 ? '...' : '') ?></td>
                                <td><?= $guestController->formatDate($row['tanggal']) ?></td>
                                <td><?= $row['waktu'] ?></td>
                                <td>
                                    <a href="read.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info btn-action">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning btn-action">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger btn-action" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $row['id'] ?>">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus data tamu: <strong><?= htmlspecialchars($row['nama']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <a href="index.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> Tidak ada entri tamu yang ditemukan.
    </div>
<?php } ?>

<?php include_once 'includes/footer.php'; ?>