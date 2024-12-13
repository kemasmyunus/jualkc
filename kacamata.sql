-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Sep 2024 pada 11.24
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
-- Database: `kacamata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar`
--

CREATE TABLE `bayar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `no_e_wallet` varchar(50) DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL,
  `no_kartu_kredit` varchar(50) DEFAULT NULL,
  `nama_pemegang_kartu` varchar(100) DEFAULT NULL,
  `tanggal_kadaluarsa` varchar(10) DEFAULT NULL,
  `kode_cvc` varchar(10) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'SEDANG PROSES',
  `id_cart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bayar`
--

INSERT INTO `bayar` (`id`, `user_id`, `nama_lengkap`, `alamat`, `telepon`, `metode_pembayaran`, `no_e_wallet`, `no_rekening`, `no_kartu_kredit`, `nama_pemegang_kartu`, `tanggal_kadaluarsa`, `kode_cvc`, `bukti_transfer`, `tracking_number`, `status`, `id_cart`) VALUES
(34, 1, 'Akira', 'JL BUMI ', '12345', 'bank_transfer', '', '12345678', '', '', '', '', '', 'SEN-66c7241cd5c40', 'DIKIRIM', 19),
(38, 9, 'rizki', 'jl Yani ', '1234567', 'kartu_kredit', '', '12345678', '', '', '', '', '', 'SEN-66d26822099de', 'DIKIRIM', 22),
(39, 9, 'rizki', 'jl Yani ', '1234567', 'kartu_kredit', '', '12345678', '', '', '', '', '', 'SEN-66d26992df729', 'DIKIRIM', 22),
(40, 9, 'rizki', 'jl Yani ', '1234567', 'kartu_kredit', '', '12345678', '', '', '', '', '', 'SEN-66d26992df729', 'SEDANG PROSES', 23),
(41, 9, 'rizki', 'jl Yani ', '1234567', 'kartu_kredit', '', '12345678', '', '', '', '', '', 'SEN-66d26992df729', 'SEDANG PROSES', 24),
(42, 9, 'rizki', 'jl Yani ', '1234567', 'kartu_kredit', '', '12345678', '', '', '', '', '', 'SEN-66d26992df729', 'SEDANG PROSES', 25),
(43, 9, 'rizki', 'jl Yani ', '1234567', 'e_wallet', '', '12345678', '', '', '', '', '', 'SEN-66d26a7116934', 'SEDANG PROSES', 22),
(44, 9, 'rizki', 'jl Yani ', '1234567', 'e_wallet', '', '12345678', '', '', '', '', '', 'SEN-66d26a7116934', 'SEDANG PROSES', 23),
(45, 9, 'rizki', 'jl Yani ', '1234567', 'e_wallet', '', '12345678', '', '', '', '', '', 'SEN-66d26a7116934', 'SEDANG PROSES', 24),
(46, 9, 'rizki', 'jl Yani ', '1234567', 'e_wallet', '', '12345678', '', '', '', '', '', 'SEN-66d26a7116934', 'SEDANG PROSES', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `ukuran` varchar(100) NOT NULL,
  `warna` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`, `ukuran`, `warna`) VALUES
(13, 4, 'PGX Rose', 70000, 5, 'PGX LENSA.jpeg', '0.0', 'Polos'),
(19, 1, 'Kacamata Sport', 50000, 1, '18.png', '0.0', 'Merah'),
(20, 2, 'Kacamata Ray Ban', 40000, 5, '11.png', '0.0', 'Hitam'),
(21, 2, 'PGX Rose', 70000, 5, 'PGX LENSA.jpeg', '2.0', 'Polos'),
(22, 9, 'Lensa X Ray', 70000, 1, 'X Ray.jpeg', '2.0', 'Polos'),
(23, 9, 'Lensa PGX', 80000, 1, 'Pasted image.png', '3.0', 'Polos'),
(24, 9, 'Kacamata Sport', 50000, 3, '18.png', '0.0', 'Merah'),
(25, 9, 'Kacamata Ray Ban', 40000, 1, '11.png', '0.0', 'Hitam');

--
-- Trigger `cart`
--
DELIMITER $$
CREATE TRIGGER `delete_cart_dependencies` BEFORE DELETE ON `cart` FOR EACH ROW BEGIN
    -- Hapus data terkait di tabel retur berdasarkan id_cart
    DELETE FROM retur WHERE id_cart = OLD.id;

    -- Hapus data terkait di tabel bayar berdasarkan id_cart
    DELETE FROM bayar WHERE id_cart = OLD.id;

    -- Hapus data terkait di tabel rekomendasi berdasarkan pelanggan_id
    DELETE FROM rekomendasi WHERE pelanggan_id = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_barang`
--

CREATE TABLE `daftar_barang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga_beli` varchar(50) NOT NULL,
  `harga_jual` varchar(50) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `warna` varchar(255) NOT NULL DEFAULT 'merah, biru, kuning, hitam, polos',
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_barang`
--

INSERT INTO `daftar_barang` (`id`, `nama`, `harga_beli`, `harga_jual`, `satuan`, `foto`, `merek`, `warna`, `deskripsi`) VALUES
(5, 'Lensa X Ray', '50000', '70000', '50', 'X Ray.jpeg', 'DIOR', 'merah, biru, kuning, hitam, polos', ''),
(6, 'Kacamata Polarized', '80000', '120000', '50', '1.jpeg', 'Police', 'merah, biru, kuning, hitam, polos', 'Kacamata Polarized adalah kacamata untuk berbagai kegunaan seperti saat berkendara di siang hari maka kacamata ini akan mendinginkan mata dari pemakai kacamata ini'),
(8, 'Lensa PGX', '60000', '80000', '20', 'Pasted image.png', 'X', 'merah, biru, kuning, hitam, polos', 'Lensa PGX adalah lensa yang dapat berubah warna nya saat terkena panas sinar matahari'),
(9, 'Kacamata Sport', '40000', '50000', '40', '18.png', 'Okley', 'merah, biru, kuning, hitam, polos', 'Kacamata Sport cocok untuk bersepeda '),
(10, 'Kacamata Baca', '30000', '40000', '70', '13.png', 'Simpson', 'merah, biru, kuning, hitam, polos', 'Kacamata ini berfungsi untuk melihat tulisan yang buram'),
(11, 'Kacamata Ray Ban', '20000', '40000', '20', '11.png', 'Ray Ban', 'merah, biru, kuning, hitam, polos', 'Ray Ban kaca yang terbuat dari batu ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `komentar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `feedback`
--

INSERT INTO `feedback` (`id`, `nama`, `rating`, `komentar`) VALUES
(1, 'PGX Rose', '5', 'Bagus'),
(2, 'PGX Rose', '5', 'Anjay'),
(3, 'Lensa X Ray', '5', 'bagus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(50) DEFAULT NULL,
  `kelamin` varchar(100) NOT NULL,
  `no_hp` int(11) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `agama` varchar(100) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status_aktif` varchar(20) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `pendidikan` enum('SD','SMP','SMA','D3','S1','S2','S3') DEFAULT NULL,
  `gaji` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama_karyawan`, `kelamin`, `no_hp`, `tanggal`, `agama`, `jabatan`, `alamat`, `status_aktif`, `username`, `password`, `nip`, `pendidikan`, `gaji`) VALUES
(1, 'Yuni', 'P', 812345671, '2024-01-01', 'islam', 'karyawan', 'Jl. Nihonggo Jozu', 'aktif', 'Yuni23', '123', 'NIP001', 'S1', 10000000),
(6, 'Admin', 'L', 89999999, '1996-03-02', 'islam', 'Pimpinan', 'Jalan Banjarmasin', 'aktif', 'admin', 'admin', 'NIP1', 'S3', 20000000),
(9, 'Bagas', 'L', 1237777, '2000-02-15', 'islam', 'karyawan', 'Banjarmasin', 'aktif', 'bagas12', '12345', 'NIP002', 'S1', 2500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsul`
--

CREATE TABLE `konsul` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `surat_keterangan` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konsul`
--

INSERT INTO `konsul` (`id`, `nama`, `foto`, `tanggal`, `surat_keterangan`, `keterangan`) VALUES
(7, 'Akira', 'mata-berair-terus-ketahui-6-penyebab-dan-cara-menanganinya.jpg', '2024-08-14', 'Surat Dokter.txt', NULL),
(9, 'Limas', 'sakit mta2.jpeg', '2024-08-30', '', 'Sakit Mata Merah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `umur` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(18) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verifikasi` enum('sudah_verifikasi','waiting','data_tidak_valid') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `kelamin` enum('Pria','Wanita') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `kode`, `nama`, `umur`, `alamat`, `hp`, `username`, `password`, `verifikasi`, `email`, `tgl_daftar`, `kelamin`) VALUES
(1, 'SH001', 'Akira', '21', 'JL BUMI', '12345', 'akira21', '12345', 'sudah_verifikasi', 'akira@gmail.com', '2024-08-10', 'Wanita'),
(9, 'SH0002', 'rizki', '21', 'jl Yani', '1234567', 'rizki21', '12345', 'sudah_verifikasi', 'rizki@gmail.com', '2024-08-31', 'Pria');

--
-- Trigger `pelanggan`
--
DELIMITER $$
CREATE TRIGGER `delete_pelanggan_dependencies` BEFORE DELETE ON `pelanggan` FOR EACH ROW BEGIN
    -- Hapus data terkait di tabel retur
    DELETE FROM retur WHERE user_id = OLD.id;

    -- Hapus data terkait di tabel bayar
    DELETE FROM bayar WHERE user_id = OLD.id;

    -- Hapus data terkait di tabel rekomendasi
    DELETE FROM rekomendasi WHERE pelanggan_id = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `ttd` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `ttd`) VALUES
(1, 'Rizki Saputra');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekomendasi`
--

CREATE TABLE `rekomendasi` (
  `id` int(11) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekomendasi`
--

INSERT INTO `rekomendasi` (`id`, `pelanggan_id`, `product_id`, `quantity`, `color`, `size`) VALUES
(3, 1, 5, 1, 'Polos', '2.0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur`
--

CREATE TABLE `retur` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bayar_id` int(11) NOT NULL,
  `id_cart` int(11) NOT NULL,
  `alasan_retur` text NOT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'RETUR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bayar_user_id` (`user_id`),
  ADD KEY `fk_bayar_id_cart` (`id_cart`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_barang`
--
ALTER TABLE `daftar_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `konsul`
--
ALTER TABLE `konsul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `retur`
--
ALTER TABLE `retur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_retur_user_id` (`user_id`),
  ADD KEY `fk_retur_id_cart` (`id_cart`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bayar`
--
ALTER TABLE `bayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `daftar_barang`
--
ALTER TABLE `daftar_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `konsul`
--
ALTER TABLE `konsul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `retur`
--
ALTER TABLE `retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bayar`
--
ALTER TABLE `bayar`
  ADD CONSTRAINT `fk_bayar_id_cart` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `fk_bayar_user_id` FOREIGN KEY (`user_id`) REFERENCES `pelanggan` (`id`);

--
-- Ketidakleluasaan untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD CONSTRAINT `rekomendasi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rekomendasi_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `daftar_barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `retur`
--
ALTER TABLE `retur`
  ADD CONSTRAINT `fk_retur_id_cart` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `fk_retur_user_id` FOREIGN KEY (`user_id`) REFERENCES `pelanggan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
