<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Tiket - KPopStage</title>
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
    .badge-vip { background-color: #FFD700; color: #000; }
    .badge-regular { background-color: #28a745; color: #fff; }
    .badge-premium { background-color: #6f42c1; color: #fff; }
  </style>
</head>
<body>

  <section class="hero-section">
    <div class="container">
      <h2>🎫 Kelola Tiket Konser</h2>
      <p>Atur jenis tiket, harga, dan ketersediaan untuk setiap konser K-Pop</p>
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
        <h4 class="fw-bold text-dark">Daftar Tiket</h4>
        <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Tiket</button>
      </div>

      <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>#</th>
              <th>Konser</th>
              <th>Jenis Tiket</th>
              <th>Harga</th>
              <th>Total</th>
              <th>Tersedia</th>
              <th>Status</th>
              <th>Deskripsi</th> <!-- Kolom Deskripsi Ditambahkan -->
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($tickets)) : ?>
              <?php foreach ($tickets as $i => $ticket): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td><?= esc($ticket['concert_name']) ?></td>
                  <td>
                    <span class="badge <?= strtolower($ticket['ticket_type']) == 'vip' ? 'badge-vip' : (strtolower($ticket['ticket_type']) == 'premium' ? 'badge-premium' : 'badge-regular') ?>">
                      <?= esc($ticket['ticket_type']) ?>
                    </span>
                  </td>
                  <td>Rp <?= number_format($ticket['price'], 0, ',', '.') ?></td>
                  <td><?= $ticket['quantity'] ?></td>
                  <td><?= $ticket['available_quantity'] ?></td>
                  <td>
                    <?php if ($ticket['available_quantity'] > 0): ?>
                      <span class="badge bg-success">Tersedia</span>
                    <?php else: ?>
                      <span class="badge bg-danger">Habis</span>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($ticket['description']) ?></td> <!-- Menampilkan Deskripsi -->
                  <td>
                    <button class="btn btn-sm btn-warning" onclick="editTicket(<?= htmlspecialchars(json_encode($ticket), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                    <form method="POST" action="<?= base_url('ticket/' . $ticket['id']) ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">Belum ada data tiket.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modal Tambah -->
  <div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="POST" action="<?= base_url('ticket') ?>" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Tiket</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Konser</label>
            <select name="concert_id" class="form-select" required>
              <option value="">Pilih Konser</option>
              <?php foreach ($concerts as $concert): ?>
                <option value="<?= $concert['id'] ?>"><?= esc($concert['name']) ?> - <?= date('d M Y', strtotime($concert['date'])) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Tiket</label>
            <input type="text" name="ticket_type" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah Tiket</label>
            <input type="number" name="quantity" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
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
    <div class="modal-dialog">
      <form id="editForm" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tiket</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_method" value="PUT">
          <div class="mb-3">
            <label class="form-label">Konser</label>
            <select name="concert_id" id="editConcertId" class="form-select" required>
              <?php foreach ($concerts as $concert): ?>
                <option value="<?= $concert['id'] ?>"><?= esc($concert['name']) ?> - <?= date('d M Y', strtotime($concert['date'])) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Tiket</label>
            <input type="text" name="ticket_type" id="editTicketType" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" id="editPrice" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah Total</label>
            <input type="number" name="quantity" id="editQuantity" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah Tersedia</label>
            <input type="number" name="available_quantity" id="editAvailableQuantity" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
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
    function editTicket(data) {
      document.getElementById('editConcertId').value = data.concert_id;
      document.getElementById('editTicketType').value = data.ticket_type;
      document.getElementById('editPrice').value = data.price;
      document.getElementById('editQuantity').value = data.quantity;
      document.getElementById('editAvailableQuantity').value = data.available_quantity;
      document.getElementById('editDescription').value = data.description;
      document.getElementById('editForm').action = '<?= base_url('ticket') ?>/' + data.id;

      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }
  </script>
</body>
</html>
