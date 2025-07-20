<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Pesanan - KPopStage</title>
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
    .badge-pending { background-color: #ffc107; color: #000; }
    .badge-confirmed { background-color: #28a745; color: #fff; }
    .badge-cancelled { background-color: #dc3545; color: #fff; }
    .badge-completed { background-color: #6f42c1; color: #fff; }
  </style>
</head>
<body>

  <section class="hero-section">
    <div class="container">
        <h2>📋 Kelola Pesanan Tiket</h2>
        <p>Monitor, ubah status, dan kelola semua pesanan tiket konser K-Pop</p>
    </div>
</section>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark">Daftar Pesanan</h4>
        <p class="text-muted mb-0">Kelola status pesanan dari customer</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select" id="statusFilter" onchange="filterByStatus()">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Tanggal Pesanan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= date('d M Y', strtotime($order['order_date'])) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editOrder(<?= htmlspecialchars(json_encode($order), ENT_QUOTES, 'UTF-8') ?>)" title="Ubah Status">
                        <i class="fas fa-edit"></i> Status
                    </button>
                    <button class="btn btn-sm btn-info" onclick="viewOrder(<?= htmlspecialchars(json_encode($order), ENT_QUOTES, 'UTF-8') ?>)" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    <form method="POST" action="<?= base_url('order/' . $order['id']) ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-danger" title="Hapus Pesanan">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal View Detail -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Nama Customer:</strong>
                    <p id="viewCustomerName" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <p id="viewCustomerEmail" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>No. Telepon:</strong>
                    <p id="viewCustomerPhone" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Konser:</strong>
                    <p id="viewConcertName" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Jenis Tiket:</strong>
                    <p id="viewTicketType" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Jumlah:</strong>
                    <p id="viewQuantity" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Total Harga:</strong>
                    <p id="viewTotalPrice" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    <p id="viewStatus" class="mb-2"></p>
                </div>
                <div class="mb-3">
                    <strong>Tanggal Pesanan:</strong>
                    <p id="viewOrderDate" class="mb-2"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <strong>Nama Customer:</strong>
                    <p id="editDisplayCustomerName" class="mb-2 text-muted"></p>
                </div>
                <div class="mb-3">
                    <strong>Konser:</strong>
                    <p id="editDisplayConcertName" class="mb-2 text-muted"></p>
                </div>
                <div class="mb-3">
                    <strong>No. Telepon:</strong>
                    <p id="editDisplayCustomerPhone" class="mb-2 text-muted"></p>
                </div>
                <!-- Tambahkan elemen lain sesuai kebutuhan -->
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
    // Calculate total price
    document.querySelector('select[name="ticket_id"]').addEventListener('change', function() {
      const price = this.selectedOptions[0].dataset.price;
      const quantity = document.querySelector('input[name="quantity"]').value || 1;
      const total = price * quantity;
      document.getElementById('totalPrice').value = 'Rp ' + total.toLocaleString('id-ID');
    });

    document.querySelector('input[name="quantity"]').addEventListener('input', function() {
      const ticketSelect = document.querySelector('select[name="ticket_id"]');
      if (ticketSelect.value) {
        const price = ticketSelect.selectedOptions[0].dataset.price;
        const total = price * this.value;
        document.getElementById('totalPrice').value = 'Rp ' + total.toLocaleString('id-ID');
      }
    });

    function editOrder(data) {
      document.getElementById('editCustomerName').value = data.customer_name;
      document.getElementById('editCustomerEmail').value = data.customer_email;
      document.getElementById('editCustomerPhone').value = data.customer_phone;
      document.getElementById('editStatus').value = data.status;
      document.getElementById('editForm').action = '<?= base_url('order') ?>/' + data.id;

      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }
  </script>
</body>
</html>