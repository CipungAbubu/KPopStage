<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Venue - KPopStage</title>
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
    img.thumb {
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <section class="hero-section">
    <div class="container">
      <h2>🏟️ Kelola Venue Konser</h2>
      <p>Tambah dan kelola informasi tempat-tempat konser K-Pop</p>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('error') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">Daftar Venue</h4>
        <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Venue</button>
      </div>

      <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>#</th>
              <th>Foto</th>
              <th>Nama Venue</th>
              <th>Kota</th>
              <th>Kapasitas</th>
              <th>Alamat</th>
              <th>Fasilitas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($venues)) : ?>
              <?php foreach ($venues as $i => $venue): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td>
                    <?php
                      $imagePath = (filter_var($venue['image'], FILTER_VALIDATE_URL))
                        ? $venue['image']
                        : base_url('uploads/venues/' . $venue['image']);
                    ?>
                    <img src="<?= esc($imagePath) ?>" alt="<?= esc($venue['name']) ?>" class="thumb">
                  </td>
                  <td><?= esc($venue['name']) ?></td>
                  <td><?= esc($venue['city']) ?></td>
                  <td><span class="badge bg-primary"><?= number_format($venue['capacity']) ?> orang</span></td>
                  <td><?= esc(substr($venue['address'], 0, 30)) ?>...</td>
                  <td><?= esc(substr($venue['facilities'], 0, 30)) ?>...</td>
                  <td>
                    <button class="btn btn-sm btn-warning" onclick="editVenue(<?= htmlspecialchars(json_encode($venue), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                    <form method="POST" action="<?= base_url('venue/' . $venue['id']) ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus venue ini?');">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center">Belum ada data venue.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modal Tambah -->
  <div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form method="POST" action="<?= base_url('venue') ?>" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Venue</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Venue</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Kota</label>
                <input type="text" name="city" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="capacity" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Kontak Info</label>
                <input type="text" name="contact_info" class="form-control" placeholder="Nomor telepon atau email">
              </div>
              <div class="mb-3">
                <label class="form-label">Foto Venue</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="address" class="form-control" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Fasilitas</label>
            <textarea name="facilities" class="form-control" rows="3" placeholder="Contoh: Parkir luas, AC, Sound system premium, dll"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-pink">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Venue</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_method" value="PUT">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Venue</label>
                <input type="text" name="name" id="editName" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Kota</label>
                <input type="text" name="city" id="editCity" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="capacity" id="editCapacity" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Kontak Info</label>
                <input type="text" name="contact_info" id="editContactInfo" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="address" id="editAddress" class="form-control" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Fasilitas</label>
            <textarea name="facilities" id="editFacilities" class="form-control" rows="3"></textarea>
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
    function editVenue(data) {
      document.getElementById('editName').value = data.name;
      document.getElementById('editCity').value = data.city;
      document.getElementById('editCapacity').value = data.capacity;
      document.getElementById('editContactInfo').value = data.contact_info;
      document.getElementById('editAddress').value = data.address;
      document.getElementById('editFacilities').value = data.facilities;
      document.getElementById('editForm').action = '<?= base_url('venue') ?>/' + data.id;

      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }
  </script>
</body>
</html>