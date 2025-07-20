<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KPopStage</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/logo.png') ?>">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #F6EADE;
    }

    .navbar-custom {
      background-color: #F6EADE;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 10px;
    }

    .nav-link {
      color: black !important;
      font-weight: 500;
      border-bottom: 2px solid transparent;
      transition: all 0.3s ease;
    }

    .nav-link:hover {
      color: #FFCFDB !important;
      border-bottom: 2px solid #FFCFDB;
    }

    .nav-link.active {
      font-weight: bold;
      color: #41BDE1 !important;
      border-bottom: 2px solid #FFCFDB;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
      <img src="<?= base_url('assets/logo.png') ?>" alt="Logo">
      <span class="fw-bold text-dark">KPopStage</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == '' ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'manage' ? 'active' : '' ?>" href="<?= base_url('manage') ?>">Manage Konser</a>
        </li>
<a class="nav-link <?= service('uri')->getSegment(1) == 'manage-tickets' ? 'active' : '' ?>" href="<?= base_url('manage-tickets') ?>">Manage Tiket</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'manage-artists' ? 'active' : '' ?>" href="<?= base_url('manage-artists') ?>">Manage Artis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'manage-venues' ? 'active' : '' ?>" href="<?= base_url('manage-venues') ?>">Manage Venue</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'manage-orders' ? 'active' : '' ?>" href="<?= base_url('manage-orders') ?>">Manage Pesanan</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
