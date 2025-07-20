<!-- File: Views/admin-home.php -->

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Home - KPopStage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #fff8fc;
      font-family: 'Poppins', sans-serif;
    }

    .hero-section {
      background: linear-gradient(to right, #F6EADE, #FFCFDB);
      padding: 60px 0;
      text-align: center;
    }

    .hero-section h2 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #D63384;
    }

    .hero-section p {
      font-size: 1.1rem;
      color: #333;
      max-width: 600px;
      margin: 0 auto;
    }

    .card {
      transition: transform 0.3s;
    }

    .card:hover {
      transform: scale(1.03);
    }

    .card-img-top {
      height: 180px;
      object-fit: cover;
    }

    footer {
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h2>Dashboard Admin KPopStage</h2>
      <p>Selamat datang di panel admin! Di sini kamu bisa mengelola daftar konser K-Pop yang akan datang.</p>
    </div>
  </section>

  <!-- Section: Daftar Konser -->
  <section class="py-5">
    <div class="container">
      <div class="row">
        <?php if (!empty($concerts)) : ?>
          <?php foreach ($concerts as $concert): ?>
            <?php
              // Deteksi apakah image sudah dalam bentuk URL atau hanya nama file
              $imagePath = (filter_var($concert['image'], FILTER_VALIDATE_URL))
                ? $concert['image']
                : base_url('uploads/' . $concert['image']);
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
              <div class="card shadow-sm h-100 border-0 rounded-4" style="background-color: #FFF6F9;">
                <img 
                  src="<?= esc($imagePath) ?>" 
                  class="card-img-top rounded-top-4" 
                  alt="<?= esc($concert['name']) ?>">
                <div class="card-body">
                  <h5 class="fw-bold text-truncate" title="<?= esc($concert['name']) ?>" style="color: #D63384;">
                    🎤 <?= esc($concert['name']) ?>
                  </h5>
                  <p class="mb-1 text-muted">📍 <?= esc($concert['location']) ?></p>
                  <p class="mb-2 text-muted">📅 <?= date('d F Y', strtotime($concert['date'])) ?></p>
                  <p class="text-truncate" style="max-height: 3.6em; overflow: hidden;">
                    <?= esc($concert['description']) ?>
                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center">
              Belum ada konser yang tersedia.
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

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
</body>
</html>
