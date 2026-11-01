CREATE DATABASE IF NOT EXISTS toko
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE toko;

CREATE TABLE IF NOT EXISTS supplier (
    id_supplier INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(200) NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(200) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS barang (
    id_barang INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(20) NOT NULL UNIQUE,
    nama_barang VARCHAR(200) NOT NULL,
    harga INT UNSIGNED NOT NULL,
    stok INT UNSIGNED NOT NULL,
    supplier_id INT NOT NULL,
    CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id_supplier)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pelanggan (
    id_pelanggan INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(200) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan VARCHAR(120),
    total INT UNSIGNED NOT NULL,
    id_pelanggan INT NOT NULL,
    CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transaksi_detail (
    id_transaksi INT NOT NULL,
    id_barang INT NOT NULL,
    harga INT UNSIGNED NOT NULL,
    qty INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_transaksi, id_barang),
    CONSTRAINT fk_detail_transaksi FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_detail_barang FOREIGN KEY (id_barang) REFERENCES barang(id_barang)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user` (
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    alamat VARCHAR(200) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    level ENUM('admin', 'kasir') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pembayaran (
    id_pembayaran INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    wkt_pembayaran DATE NOT NULL,
    total INT UNSIGNED NOT NULL,
    metode ENUM('Tunai', 'Transfer', 'EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Recreate foreign keys so this also upgrades existing tables.
ALTER TABLE barang DROP FOREIGN KEY IF EXISTS fk_barang_supplier;
ALTER TABLE barang
    ADD CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id_supplier)
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE transaksi DROP FOREIGN KEY IF EXISTS fk_pelanggan;
ALTER TABLE transaksi DROP FOREIGN KEY IF EXISTS fk_transaksi_pelanggan;
ALTER TABLE transaksi
    ADD CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE transaksi_detail DROP FOREIGN KEY IF EXISTS fk_detail_transaksi;
ALTER TABLE transaksi_detail
    ADD CONSTRAINT fk_detail_transaksi FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi)
    ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE transaksi_detail DROP FOREIGN KEY IF EXISTS fk_detail_barang;
ALTER TABLE transaksi_detail
    ADD CONSTRAINT fk_detail_barang FOREIGN KEY (id_barang) REFERENCES barang(id_barang)
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE pembayaran DROP FOREIGN KEY IF EXISTS fk_pembayaran_transaksi;
ALTER TABLE pembayaran
    ADD CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id_transaksi)
    ON DELETE CASCADE ON UPDATE CASCADE;

INSERT IGNORE INTO supplier (id_supplier, nama_supplier, no_telp, alamat) VALUES
(1, 'Sumber Makmur', '081200000001', 'Jl. Merdeka No. 1'),
(2, 'Berkah Jaya', '081200000002', 'Jl. Mawar No. 2'),
(3, 'Sentosa Abadi', '081200000003', 'Jl. Melati No. 3'),
(4, 'Mitra Niaga', '081200000004', 'Jl. Kenanga No. 4'),
(5, 'Cipta Usaha', '081200000005', 'Jl. Anggrek No. 5'),
(6, 'Dunia Grosir', '081200000006', 'Jl. Dahlia No. 6'),
(7, 'Prima Distribusi', '081200000007', 'Jl. Flamboyan No. 7'),
(8, 'Karya Bersama', '081200000008', 'Jl. Teratai No. 8'),
(9, 'Rezeki Lancar', '081200000009', 'Jl. Kamboja No. 9'),
(10, 'Andalan Sejahtera', '081200000010', 'Jl. Cempaka No. 10');

INSERT IGNORE INTO barang (id_barang, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras 5 kg', 72000, 40, 1),
(2, 'BRG002', 'Minyak goreng 1 L', 18000, 60, 2),
(3, 'BRG003', 'Gula pasir 1 kg', 16000, 50, 3),
(4, 'BRG004', 'Tepung terigu 1 kg', 13000, 45, 4),
(5, 'BRG005', 'Teh celup', 12000, 35, 5),
(6, 'BRG006', 'Kopi bubuk', 15000, 30, 6),
(7, 'BRG007', 'Susu UHT 1 L', 21000, 25, 7),
(8, 'BRG008', 'Mi instan', 3500, 100, 8),
(9, 'BRG009', 'Sabun mandi', 5000, 55, 9),
(10, 'BRG010', 'Air mineral 600 ml', 4000, 80, 10);

INSERT IGNORE INTO pelanggan (id_pelanggan, nama_pelanggan, jenis_kelamin, no_telp) VALUES
(1, 'Andi Wijaya', 'L', '081300000001'),
(2, 'Budi Santoso', 'L', '081300000002'),
(3, 'Citra Lestari', 'P', '081300000003'),
(4, 'Dewi Anggraini', 'P', '081300000004'),
(5, 'Eko Prasetyo', 'L', '081300000005'),
(6, 'Fitri Handayani', 'P', '081300000006'),
(7, 'Galih Saputra', 'L', '081300000007'),
(8, 'Hana Puspita', 'P', '081300000008'),
(9, 'Indra Gunawan', 'L', '081300000009'),
(10, 'Jihan Permata', 'P', '081300000010');

INSERT IGNORE INTO transaksi (id_transaksi, waktu_transaksi, keterangan, total, id_pelanggan) VALUES
(1, '2026-10-01', 'Pembelian beras', 72000, 1),
(2, '2026-10-02', 'Pembelian minyak goreng', 36000, 2),
(3, '2026-10-03', 'Pembelian gula pasir', 32000, 3),
(4, '2026-10-04', 'Pembelian tepung terigu', 26000, 4),
(5, '2026-10-05', 'Pembelian teh celup', 24000, 5),
(6, '2026-10-06', 'Pembelian kopi bubuk', 30000, 6),
(7, '2026-10-07', 'Pembelian susu UHT', 42000, 7),
(8, '2026-10-08', 'Pembelian mi instan', 14000, 8),
(9, '2026-10-09', 'Pembelian sabun mandi', 10000, 9),
(10, '2026-10-10', 'Pembelian air mineral', 12000, 10);

INSERT IGNORE INTO transaksi_detail (id_transaksi, id_barang, harga, qty) VALUES
(1, 1, 72000, 1),
(2, 2, 18000, 2),
(3, 3, 16000, 2),
(4, 4, 13000, 2),
(5, 5, 12000, 2),
(6, 6, 15000, 2),
(7, 7, 21000, 2),
(8, 8, 3500, 4),
(9, 9, 5000, 2),
(10, 10, 4000, 3);

INSERT IGNORE INTO `user` (id_user, username, password,alamat, hp, level) VALUES
(1, 'admin01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 1', '082100000001', 'admin'),
(2, 'kasir01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 2', '082100000002', 'kasir'),
(3, 'kasir02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi',  'Jl. Toko No. 3', '082100000003', 'kasir'),
(4, 'kasir03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi',  'Jl. Toko No. 4', '082100000004', 'kasir'),
(5, 'kasir04', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 5', '082100000005', 'kasir'),
(6, 'kasir₀5', '$2y$1₀$92IXUNpkj₀rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 6', '₀8₂₁₀₀₀₀₀₀₀₆', 'kasir'),
(7, 'kasir06', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 7', '082100000007', 'kasir'),
(8, 'kasir07', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi',  'Jl. Toko No. 8', '082100000008', 'kasir'),
(9, 'kasir08', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 9', '082100000009', 'kasir'),
(10, 'kasir09', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'Jl. Toko No. 10', '082100000010', 'kasir');

INSERT IGNORE INTO pembayaran (id_pembayaran, wkt_pembayaran, total, metode, transaksi_id) VALUES
(1, '2026-10-01', 72000, 'Tunai', 1),
(2, '2026-10-02', 36000, 'Transfer', 2),
(3, '2026-10-03', 32000, 'EDC', 3),
(4, '2026-10-04', 26000, 'Tunai', 4),
(5, '2026-10-05', 24000, 'Transfer', 5),
(6, '2026-10-06', 30000, 'EDC', 6),
(7, '2026-10-07', 42000, 'Tunai', 7),
(8, '2026-10-08', 14000, 'Transfer', 8),
(9, '2026-10-09', 10000, 'EDC', 9),
(10, '2026-10-10', 12000, 'Tunai', 10);
