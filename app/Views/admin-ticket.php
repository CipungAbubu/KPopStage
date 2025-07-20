<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="py-5 text-center" style="background: linear-gradient(to right, #F6EADE, #F0D9FF);">
  <div class="container">
    <h1 class="fw-bold mb-3" style="color: #4a4a4a;">Kelola Tiket Konser!</h1>
    <p class="lead text-muted">Tambah, ubah, atau hapus tiket konser sesuai kebutuhan.</p>
  </div>
</section>

<div class="container mt-5 mb-5">

    <?php if (isset($mode) && $mode === 'form'): ?>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="mb-4"><?= isset($ticket) ? 'Edit' : 'Tambah' ?> Tiket untuk: <span class="text-primary"><?= $concert['name'] ?></span></h2>
                <form action="<?= isset($ticket) ? '/ticket/update/' . $ticket['id'] : '/ticket/store/' . $concert['id'] ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control" value="<?= $ticket['category'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" class="form-control" value="<?= $ticket['price'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" value="<?= $ticket['stock'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control"><?= $ticket['description'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Tiket (opsional)</label>
                        <input type="file" name="image" class="form-control">
                        <?php if (!empty($ticket['image'])): ?>
                            <img src="<?= $ticket['image'] ?>" alt="Tiket" class="img-thumbnail mt-2" style="max-width: 150px;">
                        <?php endif ?>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= isset($ticket) ? 'Update' : 'Simpan' ?></button>
                    <a href="/ticket/index/<?= $concert['id'] ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>

    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Kelola Tiket untuk: <span class="text-primary"><?= $concert['name'] ?></span></h2>
            <a href="/ticket/create/<?= $concert['id'] ?>" class="btn btn-success">+ Tambah Tiket</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle shadow-sm bg-white">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td class="text-center">
                                <?php if (!empty($ticket['image'])): ?>
                                    <img src="<?= $ticket['image'] ?>" class="img-fluid rounded" style="width: 80px;" alt="Tiket">
                                <?php else: ?>
                                    <small class="text-muted">Tidak ada</small>
                                <?php endif ?>
                            </td>
                            <td><?= esc($ticket['category']) ?></td>
                            <td>Rp<?= number_format($ticket['price'], 0, ',', '.') ?></td>
                            <td><?= esc($ticket['stock']) ?></td>
                            <td><?= esc($ticket['description']) ?></td>
                            <td class="text-center">
                                <a href="/ticket/edit/<?= $ticket['id'] ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                                <form action="/ticket/delete/<?= $ticket['id'] ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tiket ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<!-- Footer -->
<footer class="py-4 text-center" style="background: linear-gradient(to right, #F6EADE, #F0D9FF); color: #4a4a4a;">
    <div class="container">
        <img src="<?= base_url('assets/logo.png') ?>" height="40" class="mb-3" alt="Logo">
        <p class="mb-1">© <?= date('Y') ?> <strong>KPopStage</strong>. All rights reserved.</p>
        <p>📍 Jl. Senopati Raya No.12, Kebayoran Baru, Jakarta Selatan</p>
        <p>📧 Email: <a href="mailto:kpopstages@gmail.com" class="fw-bold" style="color: #4a4a4a;">kpopstages@gmail.com</a></p>
        <p>
            📷 Instagram: 
            <a href="https://instagram.com/kpopstageid" class="fw-bold" style="color: #8e44ad;" target="_blank">@kpopstageid</a> |
            🎵 TikTok: 
            <a href="https://tiktok.com/@kpopstageid" class="fw-bold" style="color: #8e44ad;" target="_blank">@kpopstageid</a>
        </p>
    </div>
</footer>

<?= $this->endSection() ?>
