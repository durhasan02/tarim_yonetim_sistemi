<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Tarım Sistemi</a>
    <ul class="navbar-nav ms-auto">
      <?php if(isset($_SESSION['username'])): ?>
      <li class="nav-item">
        <span class="nav-link text-white">Hoş geldin, <b><?= htmlspecialchars($_SESSION['username']) ?></b></span>
      </li>
      <li class="nav-item">
        <a href="logout.php" class="nav-link text-white">Çıkış</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
