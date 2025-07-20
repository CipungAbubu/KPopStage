<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Artis - KPopStage</title>
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
      width: 60px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body>

  <section class="hero-section">
    <div class="container">
      <h2>🎤 Kelola Artis K-Pop</h2>
      <p>Tambah dan kelola informasi artis atau grup K-Pop favorit</p>
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
        <h4 class="fw-bold text-dark">Daftar Artis</h4>
        <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Artis</button>
      </div>

      <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>#</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Genre</th>
              <th>Negara</th>
              <th>Debut</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($artists)) : ?>
              <?php foreach ($artists as $i => $artist): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td>
                    <?php
                      $imagePath = (filter_var($artist['image'], FILTER_VALIDATE_URL))
                        ? $artist['image']
                        : base_url('uploads/artists/' . $artist['image']);
                    ?>
                    <img src="<?= esc($imagePath) ?>" alt="<?= esc($artist['name']) ?>" class="thumb">
                  </td>
                  <td><?= esc($artist['name']) ?></td>
                  <td><span class="badge bg-info"><?= esc($artist['genre']) ?></span></td>
                  <td><?= esc($artist['country']) ?></td>
                  <td><?= $artist['debut_year'] ?></td>
                  <td><?= esc(substr($artist['description'], 0, 50)) ?>...</td>
                  <td>
                    <button class="btn btn-sm btn-warning" onclick="editArtist(<?= htmlspecialchars(json_encode($artist), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                    <form method="POST" action="<?= base_url('artist/' . $artist['id']) ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artis ini?');">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center">Belum ada data artis.</td>
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
      <form method="POST" action="<?= base_url('artist') ?>" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Artis</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Artis/Grup</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Genre</label>
                <select name="genre" class="form-select" required>
                  <option value="">Pilih Genre</option>
                  <option value="K-Pop">K-Pop</option>
                  <option value="K-Rock">K-Rock</option>
                  <option value="K-Hip Hop">K-Hip Hop</option>
                  <option value="K-R&B">K-R&B</option>
                  <option value="K-Indie">K-Indie</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Negara</label>
                <input type="text" name="country" class="form-control" value="South Korea" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Tahun Debut</label>
                <input type="number" name="debut_year" class="form-control" min="1990" max="2025" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Social Media</label>
                <input type="text" name="social_media" class="form-control" placeholder="@username atau link">
              </div>
              <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Ceritakan tentang artis/grup ini..."></textarea>
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
          <h5 class="modal-title">Edit Artis</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_method" value="PUT">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Artis/Grup</label>
                <input type="text" name="name" id="editName" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Genre</label>
                <select name="genre" id="editGenre" class="form-select" required>
                  <option value="K-Pop">K-Pop</option>
                  <option value="K-Rock">K-Rock</option>
                  <option value="K-Hip Hop">K-Hip Hop</option>
                  <option value="K-R&B">K-R&B</option>
                  <option value="K-Indie">K-Indie</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Negara</label>
                <input type="text" name="country" id="editCountry" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Tahun Debut</label>
                <input type="number" name="debut_year" id="editDebutYear" class="form-control" min="1990" max="2025" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Social Media</label>
                <input type="text" name="social_media" id="editSocialMedia" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" id="editDescription" class="form-control" rows="4"></textarea>
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
    function editArtist(data) {
      document.getElementById('editName').value = data.name;
      document.getElementById('editGenre').value = data.genre;
      document.getElementById('editCountry').value = data.country;
      document.getElementById('editDebutYear').value = data.debut_year;
      document.getElementById('editSocialMedia').value = data.social_media;
      document.getElementById('editDescription').value = data.description;
      document.getElementById('editForm').action = '<?= base_url('artist') ?>/' + data.id;

      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }
  </script>
</body>
</html>