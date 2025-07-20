<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - KPopStage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #fff8fc 0%, #f8f4ff 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    .hero-section {
      background: linear-gradient(135deg, #F6EADE 0%, #FFCFDB 50%, #E8D5FF 100%);
      padding: 80px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
      opacity: 0.3;
    }

    .hero-section h1 {
      font-size: 3rem;
      font-weight: 800;
      color: #D63384;
      margin-bottom: 20px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
      position: relative;
      z-index: 1;
    }

    .hero-section p {
      font-size: 1.2rem;
      color: #555;
      max-width: 700px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .stats-card {
      background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
      border: none;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(214, 51, 132, 0.1);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #D63384, #FF6B9D, #C44569);
    }

    .stats-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(214, 51, 132, 0.15);
    }

    .stats-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: white;
      margin-bottom: 20px;
    }

    .stats-number {
      font-size: 2.5rem;
      font-weight: 800;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .stats-label {
      color: #7f8c8d;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 0.9rem;
    }

    .section-title {
      font-size: 2.2rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 40px;
      text-align: center;
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, #D63384, #FF6B9D);
      border-radius: 2px;
    }

    .concert-card {
      background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
      border: none;
      border-radius: 20px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      position: relative;
    }

    .concert-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, transparent 0%, rgba(214, 51, 132, 0.05) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .concert-card:hover::before {
      opacity: 1;
    }

    .concert-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(214, 51, 132, 0.15);
    }

    .concert-card .card-img-top {
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .concert-card:hover .card-img-top {
      transform: scale(1.05);
    }

    .concert-card .card-body {
      padding: 25px;
      position: relative;
      z-index: 1;
    }

    .concert-title {
      font-weight: 700;
      color: #D63384;
      font-size: 1.1rem;
      margin-bottom: 15px;
    }

    .concert-meta {
      color: #7f8c8d;
      font-size: 0.9rem;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .quick-actions {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 20px;
      padding: 40px;
      color: white;
      text-align: center;
      margin-top: 40px;
    }

    .quick-actions h3 {
      font-weight: 700;
      margin-bottom: 30px;
      font-size: 1.8rem;
    }

    .action-btn {
      background: rgba(255,255,255,0.2);
      border: 2px solid rgba(255,255,255,0.3);
      color: white;
      padding: 15px 30px;
      border-radius: 50px;
      text-decoration: none;
      display: inline-block;
      margin: 10px;
      transition: all 0.3s ease;
      font-weight: 600;
      backdrop-filter: blur(10px);
    }

    .action-btn:hover {
      background: rgba(255,255,255,0.3);
      border-color: rgba(255,255,255,0.5);
      color: white;
      transform: translateY(-2px);
    }

    .recent-activity {
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .activity-item {
      padding: 15px 0;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .activity-item:last-child {
      border-bottom: none;
    }

    .activity-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: white;
    }

    .activity-text {
      flex: 1;
      color: #555;
      font-size: 0.9rem;
    }

    .activity-time {
      color: #999;
      font-size: 0.8rem;
    }

    footer {
      background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
      color: white;
      padding: 50px 0 30px;
      margin-top: 80px;
    }

    .footer-content {
      text-align: center;
    }

    .footer-logo {
      margin-bottom: 20px;
    }

    .footer-links {
      margin: 20px 0;
    }

    .footer-links a {
      color: #ecf0f1;
      text-decoration: none;
      margin: 0 15px;
      transition: color 0.3s ease;
    }

    .footer-links a:hover {
      color: #D63384;
    }

    @media (max-width: 768px) {
      .hero-section h1 {
        font-size: 2.2rem;
      }
      
      .stats-card {
        margin-bottom: 20px;
      }
      
      .action-btn {
        display: block;
        margin: 10px 0;
      }
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1><i class="fas fa-crown"></i> Dashboard Admin KPopStage</h1>
      <p>Selamat datang di pusat kendali KPopStage! Kelola seluruh ekosistem konser K-Pop dengan mudah dan efisien.</p>
    </div>
  </section>

  <!-- Statistics Section -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <div class="stats-card text-center">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea, #764ba2);">
              <i class="fas fa-music"></i>
            </div>
            <div class="stats-number"><?= count($concerts) ?></div>
            <div class="stats-label">Total Konser</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="stats-card text-center">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
              <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stats-number">1,247</div>
            <div class="stats-label">Tiket Terjual</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="stats-card text-center">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
              <i class="fas fa-users"></i>
            </div>
            <div class="stats-number">856</div>
            <div class="stats-label">Customer Aktif</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="stats-card text-center">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-number">Rp 2.4M</div>
            <div class="stats-label">Revenue Bulan Ini</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Recent Activity & Quick Actions -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="recent-activity">
            <h3 class="section-title" style="text-align: left; margin-bottom: 30px;">
              <i class="fas fa-clock"></i> Aktivitas Terbaru
            </h3>
            <div class="activity-item">
              <div class="activity-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-plus"></i>
              </div>
              <div class="activity-text">
                <strong>Konser baru ditambahkan:</strong> BLACKPINK World Tour 2024
              </div>
              <div class="activity-time">2 jam lalu</div>
            </div>
            <div class="activity-item">
              <div class="activity-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <div class="activity-text">
                <strong>Pesanan baru:</strong> 5 tiket VIP untuk BTS Permission to Dance
              </div>
              <div class="activity-time">4 jam lalu</div>
            </div>
            <div class="activity-item">
              <div class="activity-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <i class="fas fa-star"></i>
              </div>
              <div class="activity-text">
                <strong>Artis baru:</strong> NewJeans ditambahkan ke database
              </div>
              <div class="activity-time">6 jam lalu</div>
            </div>
            <div class="activity-item">
              <div class="activity-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="activity-text">
                <strong>Venue baru:</strong> Jakarta International Expo ditambahkan
              </div>
              <div class="activity-time">1 hari lalu</div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="quick-actions">
            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
            <a href="<?= base_url('manage') ?>" class="action-btn">
              <i class="fas fa-plus"></i> Tambah Konser
            </a>
            <a href="<?= base_url('manage-tickets') ?>" class="action-btn">
              <i class="fas fa-ticket-alt"></i> Kelola Tiket
            </a>
            <a href="<?= base_url('manage-artists') ?>" class="action-btn">
              <i class="fas fa-microphone"></i> Kelola Artis
            </a>
            <a href="<?= base_url('manage-orders') ?>" class="action-btn">
              <i class="fas fa-list"></i> Lihat Pesanan
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Upcoming Concerts Section -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title">
        <i class="fas fa-calendar-alt"></i> Konser Mendatang
      </h2>
      <div class="row g-4">
        <?php if (!empty($concerts)) : ?>
          <?php 
          $upcomingConcerts = array_slice($concerts, 0, 8); // Show only first 8 concerts
          foreach ($upcomingConcerts as $concert): 
          ?>
            <?php
              $imagePath = (filter_var($concert['image'], FILTER_VALIDATE_URL))
                ? $concert['image']
                : base_url('uploads/' . $concert['image']);
            ?>
            <div class="col-lg-3 col-md-6 mb-4">
              <div class="concert-card card h-100">
                <img 
                  src="<?= esc($imagePath) ?>" 
                  class="card-img-top" 
                  alt="<?= esc($concert['name']) ?>"
                  onerror="this.src='https://images.pexels.com/photos/1763075/pexels-photo-1763075.jpeg'">
                <div class="card-body">
                  <h5 class="concert-title">
                    🎤 <?= esc($concert['name']) ?>
                  </h5>
                  <div class="concert-meta">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= esc($concert['location']) ?>
                  </div>
                  <div class="concert-meta">
                    <i class="fas fa-calendar"></i>
                    <?= date('d F Y', strtotime($concert['date'])) ?>
                  </div>
                  <p class="text-muted mt-3" style="font-size: 0.9rem; line-height: 1.4;">
                    <?= esc(substr($concert['description'], 0, 80)) ?>...
                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #e3f2fd, #f3e5f5);">
              <i class="fas fa-info-circle fa-2x mb-3" style="color: #D63384;"></i>
              <h5>Belum ada konser yang tersedia</h5>
              <p class="mb-0">Mulai tambahkan konser K-Pop pertama Anda!</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <?php if (count($concerts) > 8): ?>
        <div class="text-center mt-4">
          <a href="<?= base_url('manage') ?>" class="btn btn-outline-primary btn-lg" style="border-radius: 50px; padding: 15px 40px;">
            <i class="fas fa-eye"></i> Lihat Semua Konser
          </a>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <img src="<?= base_url('assets/logo.png') ?>" height="50" alt="KPopStage Logo" class="mb-3">
          <h4 style="color: #ecf0f1; font-weight: 700;">KPopStage</h4>
        </div>
        <div class="footer-links">
          <a href="<?= base_url() ?>"><i class="fas fa-home"></i> Dashboard</a>
          <a href="<?= base_url('manage') ?>"><i class="fas fa-music"></i> Konser</a>
          <a href="<?= base_url('manage-artists') ?>"><i class="fas fa-microphone"></i> Artis</a>
          <a href="<?= base_url('manage-venues') ?>"><i class="fas fa-map-marker-alt"></i> Venue</a>
          <a href="<?= base_url('manage-orders') ?>"><i class="fas fa-shopping-cart"></i> Pesanan</a>
        </div>
        <div class="mt-4">
          <p style="color: #bdc3c7; margin-bottom: 10px;">
            © <?= date('Y') ?> <strong>KPopStage</strong>. All rights reserved.
          </p>
          <p style="color: #95a5a6; font-size: 0.9rem;">
            <i class="fas fa-map-marker-alt"></i> Jl. Senopati Raya No.12, Kebayoran Baru, Jakarta Selatan
          </p>
          <p style="color: #95a5a6; font-size: 0.9rem;">
            <i class="fas fa-envelope"></i> 
            <a href="mailto:kpopstages@gmail.com" style="color: #D63384;">kpopstages@gmail.com</a>
          </p>
          <div class="mt-3">
            <a href="https://instagram.com/kpopstageid" target="_blank" style="color: #e91e63; margin: 0 10px; font-size: 1.2rem;">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="https://tiktok.com/@kpopstageid" target="_blank" style="color: #ff6b9d; margin: 0 10px; font-size: 1.2rem;">
              <i class="fab fa-tiktok"></i>
            </a>
            <a href="#" target="_blank" style="color: #667eea; margin: 0 10px; font-size: 1.2rem;">
              <i class="fab fa-twitter"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Add some interactive animations
    document.addEventListener('DOMContentLoaded', function() {
      // Animate stats numbers on scroll
      const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
      };

      const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const statsNumber = entry.target.querySelector('.stats-number');
            if (statsNumber && !statsNumber.classList.contains('animated')) {
              statsNumber.classList.add('animated');
              animateNumber(statsNumber);
            }
          }
        });
      }, observerOptions);

      document.querySelectorAll('.stats-card').forEach(card => {
        observer.observe(card);
      });

      function animateNumber(element) {
        const finalNumber = element.textContent;
        const isRupiah = finalNumber.includes('Rp');
        const numericValue = parseInt(finalNumber.replace(/[^\d]/g, ''));
        
        if (isNaN(numericValue)) return;
        
        let currentNumber = 0;
        const increment = Math.ceil(numericValue / 50);
        
        const timer = setInterval(() => {
          currentNumber += increment;
          if (currentNumber >= numericValue) {
            currentNumber = numericValue;
            clearInterval(timer);
          }
          
          if (isRupiah) {
            element.textContent = 'Rp ' + (currentNumber / 1000000).toFixed(1) + 'M';
          } else {
            element.textContent = currentNumber.toLocaleString();
          }
        }, 30);
      }

      // Add hover effects to activity items
      document.querySelectorAll('.activity-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
          this.style.backgroundColor = '#f8f9fa';
          this.style.transform = 'translateX(10px)';
          this.style.transition = 'all 0.3s ease';
        });
        
        item.addEventListener('mouseleave', function() {
          this.style.backgroundColor = 'transparent';
          this.style.transform = 'translateX(0)';
        });
      });
    });
  </script>
</body>
</html>