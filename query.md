CREATE TABLE IF NOT EXISTS `jenis_perangkat` (
  `id_jenis` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_jenis` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `perangkat` (
  `id_perangkat` INT AUTO_INCREMENT PRIMARY KEY,
  `id_jenis` INT NOT NULL,
  `nama_perangkat` VARCHAR(100) NOT NULL,
  `merek` VARCHAR(50) NOT NULL,
  `harga` INT NOT NULL,
  `stok` INT NOT NULL,
  FOREIGN KEY (`id_jenis`) REFERENCES `jenis_perangkat` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `perangkat`;
TRUNCATE TABLE `jenis_perangkat`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `jenis_perangkat` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Laptop'),
(2, 'Proyektor'),
(3, 'Networking'),
(4, 'Aksesoris PC'),
(5, 'Server Hardware');

INSERT INTO `perangkat` (`id_jenis`, `nama_perangkat`, `merek`, `harga`, `stok`) VALUES
(1, 'ThinkPad X395 Ryzen 5 PRO', 'Lenovo', 4500000, 8),
(1, 'ThinkPad X280 Core i5', 'Lenovo', 3200000, 5),
(1, 'ThinkPad T430 Klasik', 'Lenovo', 1800000, 0),
(1, 'Infinix INBOOK X2 Core i3', 'Infinix', 4200000, 3),
(1, 'MacBook Air M1 8GB/256GB', 'Apple', 11500000, 2),
(1, 'ASUS ExpertBook B1400', 'ASUS', 6800000, 4),

(2, 'Proyektor EB-E500 XGA 3300 Lumens', 'Epson', 5500000, 4),
(2, 'Proyektor Mini LED Portable M1', 'Anker', 2900000, 2),
(2, 'Proyektor Laser FHD Cinema', 'Xiaomi', 9800000, 1),
(2, 'ViewSonic PA503X XGA', 'ViewSonic', 4900000, 0), -- Stok Kosong

(3, 'Router Switch 24-Port Gigabit', 'Cisco', 3700000, 3),
(3, 'Wireless Router Archer C6 AC1200', 'TP-Link', 450000, 12),
(3, 'UniFi AP AC Long Range', 'Ubiquiti', 1650000, 6),
(3, 'MikroTik RB3011UiAS-RM', 'MikroTik', 2850000, 2),
(3, 'SFP Module 10G Multi-Mode', 'Cisco', 850000, 10),

(4, 'Magnetic Screwdriver Set 24-in-1', 'Xiaomi Wiha', 150000, 15),
(4, 'Thermal Paste MX-4 4gram', 'Arctic', 95000, 20),
(4, 'Mouse Gaming Harpoon RGB', 'Corsair', 320000, 7),
(4, 'Mechanical Keyboard K2 Wireless', 'Keychron', 1100000, 4),
(4, 'SSD M.2 NVMe 512GB NW-980', 'Samsung', 950000, 11),
(4, 'Flashdisk Ultra Eco USB 3.0 64GB', 'SanDisk', 120000, 30),

(5, 'PowerEdge R740 Rack Server', 'Dell', 45000000, 1),
(5, 'ProLiant DL360 Gen10 Server', 'HP', 38500000, 2),
(5, 'NAS Storage 4-Bay DiskStation', 'Synology', 7200000, 2),
(5, 'RAM Server ECC DDR4 32GB', 'Kingston', 2400000, 6);