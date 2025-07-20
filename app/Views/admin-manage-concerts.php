<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Konser - KPopStage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #fff8fc;
      font-family: 'Poppins', sans-serif;
    }

    .hero-section {
      background: linear-gradient(to right, #FFD6E8, #FFE9F2);
      padding: 60px 0;
      text-align: center;
    }

    .hero-section h2 {
      font-weight: bold;
      font-size: 2.5rem;
      color: #D63384;
    }

    .hero-section p {
      color: #555;
      font-size: 1.1rem;
    }

    .table thead {
      background-color: #FDE2EF;
      color: #D63384;
    }

    .btn-pink {
      background-color: #D63384;
      color: white;
    }

    .btn-pink:hover {
      background-color: #b82c6f;
    }

    footer {
      font-size: 14px;
    }

    img.thumb {
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h2>Kelola Konser K-Pop</h2>
      <p>Tambah, ubah, atau hapus konser sesuai jadwal. Pastikan informasi selalu update ya, Admin!</p>
    </div>
  </section>

  <!-- CRUD Table Section -->
  <section class="py-5">
    <div class="container">

        <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php elseif (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">Daftar Konser</h4>
        <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Konser</button>
      </div>

      <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>#</th>
              <th>Gambar</th>
              <th>Nama</th>
              <th>Lokasi</th>
              <th>Tanggal</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($concerts)) : ?>
              <?php foreach ($concerts as $i => $concert): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td><img src="<?= esc($concert['image']) ?>" alt="<?= esc($concert['name']) ?>" class="thumb"></td>
                  <td><?= esc($concert['name']) ?></td>
                  <td><?= esc($concert['location']) ?></td>
                  <td><?= date('d M Y', strtotime($concert['date'])) ?></td>
                  <td><?= esc($concert['description']) ?></td>
                  <td>
                    <button class="btn btn-sm btn-warning" onclick="editConcert(<?= htmlspecialchars(json_encode($concert), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                    <form method="POST" action="<?= base_url('concert/' . $concert['id']) ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus konser ini?');">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada data konser.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modal Tambah -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="<?= base_url('concert') ?>" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Konser</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Konser</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" name="date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-pink">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit (dinamis) -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Konser</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="id" id="editId">

          <div class="mb-3">
            <label for="editName" class="form-label">Nama</label>
            <input type="text" name="name" id="editName" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editLocation" class="form-label">Lokasi</label>
            <input type="text" name="location" id="editLocation" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editDate" class="form-label">Tanggal</label>
            <input type="date" name="date" id="editDate" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editDescription" class="form-label">Deskripsi</label>
            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="editImage" class="form-label">Ganti Gambar (Opsional)</label>
            <input type="file" name="image" id="editImage" class="form-control" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-pink">Update</button>
        </div>
      </form>
    </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function editConcert(data) {
      document.getElementById('editId').value = data.id;
      document.getElementById('editName').value = data.name;
      document.getElementById('editLocation').value = data.location;
      document.getElementById('editDate').value = data.date;
      document.getElementById('editDescription').value = data.description;
      document.getElementById('editForm').action = '<?= base_url('concert') ?>/' + data.id;

      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }
  </script>
</body>
</html>
