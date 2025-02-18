-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Feb 2025 pada 02.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeletePenjualan` (IN `p_PenjualanID` INT)   BEGIN
    -- Hapus semua detail penjualan terkait terlebih dahulu
    DELETE FROM detailpenjualan WHERE PenjualanID = p_PenjualanID;

    -- Hapus penjualan utama
    DELETE FROM penjualan WHERE PenjualanID = p_PenjualanID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPenjualan` (IN `p_TanggalPenjualan` DATE, IN `p_PelangganID` INT)   BEGIN
    INSERT INTO penjualan (TanggalPenjualan, PelangganID, TotalHarga, created_at, updated_at)
    VALUES (p_TanggalPenjualan, p_PelangganID, 0, NOW(), NOW());
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailpenjualan`
--

CREATE TABLE `detailpenjualan` (
  `DetailID` bigint(20) UNSIGNED NOT NULL,
  `PenjualanID` bigint(20) UNSIGNED NOT NULL,
  `ProdukID` bigint(20) UNSIGNED NOT NULL,
  `JumlahProduk` int(11) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detailpenjualan`
--

INSERT INTO `detailpenjualan` (`DetailID`, `PenjualanID`, `ProdukID`, `JumlahProduk`, `Subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 85000.00, '2025-02-17 00:03:54', '2025-02-17 00:03:54'),
(2, 3, 2, 2, 45000.00, '2025-02-17 00:56:19', '2025-02-17 00:56:19'),
(3, 4, 3, 3, 30000.00, '2025-02-17 00:56:28', '2025-02-17 00:56:28'),
(4, 5, 4, 1, 450000.00, '2025-02-17 00:56:37', '2025-02-17 00:56:37'),
(5, 5, 5, 2, 30000.00, '2025-02-17 00:56:48', '2025-02-17 00:56:48'),
(6, 6, 6, 3, 54000.00, '2025-02-17 00:57:29', '2025-02-17 00:57:29'),
(7, 8, 11, 2, 38000.00, '2025-02-17 00:57:40', '2025-02-17 00:57:40');

--
-- Trigger `detailpenjualan`
--
DELIMITER $$
CREATE TRIGGER `adjust_stock_after_update` AFTER UPDATE ON `detailpenjualan` FOR EACH ROW BEGIN
    UPDATE produk
    SET Stok = Stok + OLD.JumlahProduk - NEW.JumlahProduk
    WHERE ProdukID = NEW.ProdukID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `restore_stock_after_delete` AFTER DELETE ON `detailpenjualan` FOR EACH ROW BEGIN
    UPDATE produk
    SET Stok = Stok + OLD.JumlahProduk
    WHERE ProdukID = OLD.ProdukID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_after_insert` AFTER INSERT ON `detailpenjualan` FOR EACH ROW BEGIN
    UPDATE produk
    SET Stok = Stok - NEW.JumlahProduk
    WHERE ProdukID = NEW.ProdukID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_harga_after_update` AFTER UPDATE ON `detailpenjualan` FOR EACH ROW BEGIN
    UPDATE penjualan
    SET TotalHarga = (
        SELECT COALESCE(SUM(Subtotal), 0)
        FROM detailpenjualan
        WHERE PenjualanID = NEW.PenjualanID
    )
    WHERE PenjualanID = NEW.PenjualanID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_17_025650_create_pelanggans_table', 1),
(6, '2025_02_17_045151_create_penjualans_table', 1),
(7, '2025_02_17_061611_create_produks_table', 1),
(8, '2025_02_17_062352_create_detail_penjualans_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `PelangganID` bigint(20) UNSIGNED NOT NULL,
  `NamaPelanggan` varchar(255) NOT NULL,
  `Alamat` text NOT NULL,
  `NomorTelepon` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`PelangganID`, `NamaPelanggan`, `Alamat`, `NomorTelepon`, `created_at`, `updated_at`) VALUES
(1, 'Aleser Omar Tarikh', 'Jl. Trikora gg. Mawar 2 Kijang Kota', '+62 82111111111', NULL, NULL),
(2, 'Zahrima', 'Perum. Telaga Bintan korindo', '+62 85611111111', NULL, NULL),
(3, 'Ariana Cole', '315 Crescent St, New York, USA', '+1 917-456-7890', NULL, NULL),
(4, 'Felix Schneider', '14 Hauptstraße, Berlin, Germany', '+49 176 1234567', NULL, NULL),
(5, 'Isabella Rossi', 'Via Dante 9, Florence, Italy', '+39 333 456 789', NULL, NULL),
(6, 'Jin Woo', '123 Namsan Road, Seoul, South Korea', '+82 10-9876-54', NULL, NULL),
(7, 'Maya Desai', '76 Pearl Avenue, Mumbai, India', '+91 9823-123456', NULL, NULL),
(8, 'Astrid Holm', '56 Västerlånggatan, Gothenburg, Sweden', '+46 31 123 456', NULL, NULL),
(9, 'Emilio Carrillo', 'Calle Gran Vía 101, Barcelona, Spain', '+34 622 345 67', NULL, NULL),
(10, 'Nikolai Ivanov', '12 Pushkin Street, Saint Petersburg, Russia', '+7 812 345-67', NULL, NULL),
(11, 'Charlotte Dubois', '32 Boulevard Saint-Germain, Paris, France', '+33 1 45 679', NULL, NULL),
(15, 'esrdtfyguhjk', 'asdfghjkl', '123456780', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `PenjualanID` bigint(20) UNSIGNED NOT NULL,
  `TanggalPenjualan` date NOT NULL,
  `PelangganID` bigint(20) UNSIGNED NOT NULL,
  `TotalHarga` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Automatically calculated from detailpenjualan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`PenjualanID`, `TanggalPenjualan`, `PelangganID`, `TotalHarga`, `created_at`, `updated_at`) VALUES
(1, '2025-02-18', 1, 0.00, '2025-02-17 07:03:29', '2025-02-17 18:18:22'),
(3, '2025-02-17', 2, 0.00, '2025-02-17 07:48:25', '2025-02-17 07:48:25'),
(4, '2025-02-17', 4, 0.00, '2025-02-17 07:49:24', '2025-02-17 00:49:29'),
(5, '2025-02-17', 3, 0.00, '2025-02-17 07:49:37', '2025-02-17 07:49:37'),
(6, '2025-02-17', 5, 0.00, '2025-02-17 07:49:46', '2025-02-17 07:49:46'),
(7, '2025-02-17', 6, 0.00, '2025-02-17 07:49:55', '2025-02-17 07:49:55'),
(8, '2025-02-17', 7, 0.00, '2025-02-17 07:50:04', '2025-02-17 07:50:04'),
(9, '2025-02-17', 8, 0.00, '2025-02-17 07:50:14', '2025-02-17 07:50:14'),
(10, '2025-02-17', 9, 0.00, '2025-02-17 07:50:27', '2025-02-17 07:50:27'),
(11, '2025-02-17', 10, 0.00, '2025-02-17 07:50:42', '2025-02-17 07:50:42'),
(12, '2025-02-17', 11, 0.00, '2025-02-17 07:51:01', '2025-02-17 07:51:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `ProdukID` bigint(20) UNSIGNED NOT NULL,
  `NamaProduk` varchar(255) NOT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `Stok` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`ProdukID`, `NamaProduk`, `Harga`, `Stok`, `created_at`, `updated_at`) VALUES
(1, 'FrostyMoo Chocolate Ice Cream', 17000.00, 45, '2025-02-17 00:03:44', '2025-02-17 00:03:44'),
(2, 'Susu UHT Frisian Flag 1L', 22500.00, 148, '2025-02-17 00:53:11', '2025-02-17 00:53:11'),
(3, 'Sabun Mandi Lifebuoy 120g', 10000.00, 247, '2025-02-17 00:53:34', '2025-02-17 00:53:34'),
(4, 'Rice Cooker Panasonic 1.8L', 450000.00, 19, '2025-02-17 00:53:51', '2025-02-17 00:53:51'),
(5, 'Kecap Manis ABC 250ml', 15000.00, 178, '2025-02-17 00:54:09', '2025-02-17 00:54:09'),
(6, 'Teh Celup Sariwangi 25 Kantong', 18000.00, 37, '2025-02-17 00:54:24', '2025-02-17 00:54:24'),
(7, 'Pasta Spaghetti Barilla 500g', 35000.00, 75, '2025-02-17 00:54:43', '2025-02-17 00:54:43'),
(8, 'Air Mineral Aqua 600ml', 5000.00, 500, '2025-02-17 00:54:57', '2025-02-17 00:54:57'),
(9, 'Blender Philips 1.5L', 350000.00, 40, '2025-02-17 00:55:12', '2025-02-17 00:55:12'),
(10, 'Cemilan Kacang Garuda 150g', 12000.00, 120, '2025-02-17 00:55:25', '2025-02-17 00:55:25'),
(11, 'Minyak Goreng Bimoli 1L', 19000.00, 188, '2025-02-17 00:55:43', '2025-02-17 00:55:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'aleser tarikh omar', 'kasir1@gmail.com', NULL, '$2y$10$zAh0qzjBZgj2PEJWoxupKesbvTmA.1IOQifd0DMD901.T02pDFRUC', NULL, '2025-02-17 00:00:04', '2025-02-17 00:00:04'),
(2, 'Zahrima', 'kasir2@gmail.com', NULL, '$2y$10$v4bGNL3mU.oLeBdoI0NspehqoLAOCEplYv2a6NKsO5ZFNb9q/ktM6', NULL, '2025-02-17 00:02:02', '2025-02-17 00:02:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD PRIMARY KEY (`DetailID`),
  ADD KEY `detailpenjualan_penjualanid_foreign` (`PenjualanID`),
  ADD KEY `detailpenjualan_produkid_foreign` (`ProdukID`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`PelangganID`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`PenjualanID`),
  ADD KEY `penjualan_pelangganid_foreign` (`PelangganID`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ProdukID`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  MODIFY `DetailID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `PelangganID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `PenjualanID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `ProdukID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD CONSTRAINT `detailpenjualan_penjualanid_foreign` FOREIGN KEY (`PenjualanID`) REFERENCES `penjualan` (`PenjualanID`) ON DELETE CASCADE,
  ADD CONSTRAINT `detailpenjualan_produkid_foreign` FOREIGN KEY (`ProdukID`) REFERENCES `produk` (`ProdukID`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_pelangganid_foreign` FOREIGN KEY (`PelangganID`) REFERENCES `pelanggan` (`PelangganID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
