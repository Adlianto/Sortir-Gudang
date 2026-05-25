<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php?pesan=terlarang');
    exit;
}

include '../config/koneksi.php';

$sql_total = mysqli_query($conn, 'SELECT SUM(stok) as total FROM perangkat');
$data_total = mysqli_fetch_assoc($sql_total);
$total_barang = $data_total['total'] ?? 0;
$barang_masuk = 14;
$barang_keluar = 3;

$query = 'SELECT p.*, j.nama_jenis FROM perangkat p LEFT JOIN jenis_perangkat j ON p.id_jenis = j.id_jenis';
$dummy_barang = mysqli_query($conn, $query);
$result_count = mysqli_num_rows($dummy_barang);

// Ambil detail nama & foto user dari database secara berkala
$id_user_aktif = $_SESSION['id'];
$user_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username, foto_pengguna FROM users WHERE id = $id_user_aktif"));
$username_aktif = $user_aktif['username'] ?? $_SESSION['username'];
$foto_aktif = $user_aktif['foto_pengguna'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../asset/css/dashboard.css">
    <link rel="stylesheet" href="../asset/css/asideUser.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="dashboard-windows-style">
    <div class="master-split-view">
        
        <div class="left-main-workspace">
            <div class="header-inline-row">
                <div class="profile-header-group-left">
                    <div class="profile-clickable-bar-left" id="profileDropdownBtn">
                        <div class="profile-mini-avatar-left">
                            <?php if (!empty($foto_aktif)): ?>
                                <img src="../upload/<?= htmlspecialchars($foto_aktif); ?>" alt="Profile">
                            <?php else: ?>
                                <div class="avatar-text-fallback-left"><?= strtoupper(substr($username_aktif, 0, 1)); ?></div>
                            <?php endif; ?>
                        </div>
                        <span class="user-display-name-left"><?= htmlspecialchars($username_aktif); ?> <small style="font-size:0.7rem; color:#666;">(User)</small></span>
                    </div>

                    <div class="profile-dropdown-menu-left" id="profileDropdownMenu">
                        <div class="dropdown-user-info-left"><strong><?= htmlspecialchars($username_aktif); ?></strong><span>Karyawan</span></div>
                        <hr class="dropdown-divider-left">
                        <a href="#" onclick="openSettingProfilPane(event, '<?= $username_aktif; ?>', '<?= $foto_aktif; ?>')">Setting</a>
                        <a href="../auth/logout.php" onclick="return confirm('Yakin ingin keluar?')" class="logout-link-left">LogOut</a>
                    </div>
                </div>

                <div class="stats-horizontal-inline">
                    <div class="sketsa-stat-card total-bg" title="Total Perangkat"><div class="sketsa-info"><h4>Total: <span><?= $total_barang; ?></span></h4></div></div>
                    <div class="sketsa-stat-card masuk-bg" title="Barang Masuk"><div class="sketsa-info"><h4>Masuk: <span><?= $barang_masuk; ?></span></h4></div></div>
                    <div class="sketsa-stat-card keluar-bg" title="Barang Keluar"><div class="sketsa-info"><h4>Keluar: <span><?= $barang_keluar; ?></span></h4></div></div>
                </div>
            </div>

            <div class="search-section-wrap">
                <input type="text" id="searchInput" placeholder="search..." autocomplete="off">
            </div>

            <main class="main-inventory-area">
                <div class="inventory-grid" id="inventoryGrid">
                    <?php if ($result_count > 0): ?>
                        <?php foreach ($dummy_barang as $row): ?>
                            <div class="item-card" onclick="openPreviewPane(this, 'user')"
                                data-nama="<?= htmlspecialchars($row['nama_perangkat']); ?>"
                                data-merek="<?= htmlspecialchars($row['merek']); ?>"
                                data-jenis="<?= htmlspecialchars($row['nama_jenis']); ?>"
                                data-harga="Rp <?= number_format($row['harga'], 0, ',', '.'); ?>"
                                data-stok="<?= htmlspecialchars($row['stok']); ?>">
                                <div class="item-tag"><?= htmlspecialchars($row['nama_jenis']); ?></div>
                                <h4 class="item-title"><?= htmlspecialchars($row['nama_perangkat']); ?></h4>
                                <div class="item-details"><p><strong>Merek:</strong> <?= htmlspecialchars($row['merek']); ?></p></div>
                                <div class="item-stock <?= ($row['stok'] <= 0) ? 'empty' : ''; ?>">Stok: <?= htmlspecialchars($row['stok']); ?> Unit</div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-data-card"><p class="no-data-icon">📭</p><h3>Gudang Kosong</h3></div>
                    <?php endif; ?>
                </div>
            </main>
        </div>

        <aside class="windows-preview-pane" id="previewPane" style="overflow-y: auto;">
            <div id="asideDynamicContent"></div>
        </aside>

    </div>
</div>

<script src="../asset/js/dashboard.js"></script>
</body>
</html>