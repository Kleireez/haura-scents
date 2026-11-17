-- =====================================================================
-- Database Website Haura Scents - Toko Parfum Refill (IMK Kelompok 9)
-- DBMS : MySQL 8.0+ / MariaDB 10.5+
-- Isi  : 10 tabel (admin, kategori_aroma, aroma, botol, info_toko,
--        daftar_tunggu_stok, transaksi, detail_transaksi, pembayaran, struk)
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `haura-scents`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `haura-scents`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS struk, pembayaran, detail_transaksi, transaksi,
                     daftar_tunggu_stok, info_toko, botol, aroma,
                     kategori_aroma, admin;
SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- 1. admin : akun kasir / pemilik untuk halaman admin
-- ---------------------------------------------------------------------
CREATE TABLE admin (
  id_admin       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama           VARCHAR(100) NOT NULL,
  username       VARCHAR(50)  NOT NULL,
  password_hash  VARCHAR(255) NOT NULL COMMENT 'simpan hash (bcrypt/argon2), bukan teks asli',
  peran          ENUM('pemilik','kasir') NOT NULL DEFAULT 'kasir',
  aktif          TINYINT(1)   NOT NULL DEFAULT 1,
  dibuat_pada    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_admin),
  UNIQUE KEY uq_admin_username (username)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 2. kategori_aroma : kelompok aroma (fresh, floral, woody, dll.)
-- ---------------------------------------------------------------------
CREATE TABLE kategori_aroma (
  id_kategori    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_kategori  VARCHAR(50)  NOT NULL,
  PRIMARY KEY (id_kategori),
  UNIQUE KEY uq_kategori_nama (nama_kategori)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 3. aroma : produk parfum yang dijual (dihitung per mililiter)
-- ---------------------------------------------------------------------
CREATE TABLE aroma (
  id_aroma       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_kategori    INT UNSIGNED NOT NULL,
  nama_aroma     VARCHAR(100) NOT NULL,
  deskripsi      TEXT         NULL COMMENT 'notes dan kesan aroma',
  ketahanan      VARCHAR(100) NULL COMMENT 'mis. 4-6 jam; diisi sesuai keterangan toko',
  harga_per_ml   INT UNSIGNED NOT NULL COMMENT 'mis. 2500 / 3000 / 4000',
  asal_produk    VARCHAR(100) NULL COMMENT 'mis. Diimpor dari Bandung',
  status_stok    ENUM('tersedia','kosong') NOT NULL DEFAULT 'tersedia',
  populer        TINYINT(1)   NOT NULL DEFAULT 0 COMMENT 'tandai aroma populer/viral',
  foto           VARCHAR(255) NULL,
  aktif          TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (id_aroma),
  KEY idx_aroma_kategori (id_kategori),
  KEY idx_aroma_nama (nama_aroma),
  CONSTRAINT fk_aroma_kategori FOREIGN KEY (id_kategori)
    REFERENCES kategori_aroma (id_kategori)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT ck_aroma_harga CHECK (harga_per_ml > 0)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 4. botol : botol yang disediakan toko
-- ---------------------------------------------------------------------
CREATE TABLE botol (
  id_botol       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_botol     VARCHAR(100) NOT NULL,
  ukuran_ml      INT UNSIGNED NOT NULL,
  harga_botol    INT UNSIGNED NOT NULL DEFAULT 0,
  aktif          TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (id_botol),
  CONSTRAINT ck_botol_ukuran CHECK (ukuran_ml > 0)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 5. info_toko : data toko, hanya 1 baris (id_toko = 1)
-- ---------------------------------------------------------------------
CREATE TABLE info_toko (
  id_toko        TINYINT UNSIGNED NOT NULL DEFAULT 1,
  nama_toko      VARCHAR(100) NOT NULL,
  alamat         TEXT         NULL,
  jam_buka       VARCHAR(100) NULL,
  no_whatsapp    VARCHAR(20)  NULL COMMENT 'untuk tombol tanya penjual dan komplain',
  deskripsi      TEXT         NULL,
  nama_bank      VARCHAR(30)  NULL COMMENT 'bank tujuan transfer',
  no_rekening    VARCHAR(30)  NULL,
  atas_nama      VARCHAR(100) NULL,
  gambar_qris    VARCHAR(255) NULL COMMENT 'file QRIS toko',
  PRIMARY KEY (id_toko),
  CONSTRAINT ck_info_toko_satu_baris CHECK (id_toko = 1)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 6. daftar_tunggu_stok : pembeli yang menunggu aroma kosong
-- ---------------------------------------------------------------------
CREATE TABLE daftar_tunggu_stok (
  id_tunggu      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_aroma       INT UNSIGNED NOT NULL,
  nama_pembeli   VARCHAR(100) NOT NULL,
  no_whatsapp    VARCHAR(20)  NOT NULL,
  tanggal_daftar DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status         ENUM('menunggu','sudah_dikabari') NOT NULL DEFAULT 'menunggu',
  PRIMARY KEY (id_tunggu),
  KEY idx_tunggu_aroma (id_aroma, status),
  CONSTRAINT fk_tunggu_aroma FOREIGN KEY (id_aroma)
    REFERENCES aroma (id_aroma)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 7. transaksi : penjualan di toko dan pesanan dari website
-- ---------------------------------------------------------------------
CREATE TABLE transaksi (
  id_transaksi      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  kode_transaksi    VARCHAR(20)  NOT NULL COMMENT 'dipakai pembeli untuk cek status',
  sumber            ENUM('toko','web') NOT NULL DEFAULT 'web',
  nama_pembeli      VARCHAR(100) NULL COMMENT 'boleh kosong untuk penjualan di toko',
  no_whatsapp       VARCHAR(20)  NULL COMMENT 'wajib diisi untuk pesanan web (diatur di aplikasi)',
  tanggal_transaksi DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  tanggal_ambil     DATE         NULL COMMENT 'perkiraan ambil di toko',
  status            ENUM('menunggu_pembayaran','diproses','siap_diambil','selesai','dibatalkan')
                    NOT NULL DEFAULT 'menunggu_pembayaran',
  total_harga       INT UNSIGNED NOT NULL DEFAULT 0,
  catatan           TEXT         NULL COMMENT 'mis. permintaan campuran (mix)',
  id_admin          INT UNSIGNED NULL COMMENT 'admin yang mencatat/memproses',
  PRIMARY KEY (id_transaksi),
  UNIQUE KEY uq_transaksi_kode (kode_transaksi),
  KEY idx_transaksi_status (status),
  KEY idx_transaksi_tanggal (tanggal_transaksi),
  KEY idx_transaksi_admin (id_admin),
  CONSTRAINT fk_transaksi_admin FOREIGN KEY (id_admin)
    REFERENCES admin (id_admin)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 8. detail_transaksi : isi tiap transaksi (aroma, ml, botol)
-- ---------------------------------------------------------------------
CREATE TABLE detail_transaksi (
  id_detail      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_transaksi   INT UNSIGNED NOT NULL,
  id_aroma       INT UNSIGNED NOT NULL,
  jenis_botol    ENUM('bawa_sendiri','dari_toko') NOT NULL DEFAULT 'bawa_sendiri',
  id_botol       INT UNSIGNED NULL COMMENT 'kosong jika bawa sendiri',
  jumlah_ml      INT UNSIGNED NOT NULL,
  harga_per_ml   INT UNSIGNED NOT NULL COMMENT 'disalin saat transaksi',
  harga_botol    INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'disalin saat transaksi, 0 jika bawa sendiri',
  subtotal       INT UNSIGNED NOT NULL COMMENT 'jumlah_ml x harga_per_ml + harga_botol',
  PRIMARY KEY (id_detail),
  KEY idx_detail_transaksi (id_transaksi),
  KEY idx_detail_aroma (id_aroma),
  KEY idx_detail_botol (id_botol),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (id_transaksi)
    REFERENCES transaksi (id_transaksi)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_detail_aroma FOREIGN KEY (id_aroma)
    REFERENCES aroma (id_aroma)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_detail_botol FOREIGN KEY (id_botol)
    REFERENCES botol (id_botol)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT ck_detail_ml CHECK (jumlah_ml > 0)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 9. pembayaran : QRIS, transfer bank, atau tunai di toko
-- ---------------------------------------------------------------------
CREATE TABLE pembayaran (
  id_pembayaran       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_transaksi        INT UNSIGNED NOT NULL,
  metode              ENUM('qris','transfer_bank','tunai') NOT NULL,
  jumlah_bayar        INT UNSIGNED NOT NULL,
  status_bayar        ENUM('menunggu','berhasil','kedaluwarsa','gagal') NOT NULL DEFAULT 'menunggu',
  batas_waktu         DATETIME     NULL COMMENT 'batas bayar QRIS/transfer; kosong untuk tunai',
  bukti_bayar         VARCHAR(255) NULL COMMENT 'file bukti yang diunggah pembeli',
  waktu_bayar         DATETIME     NULL,
  id_admin_verifikasi INT UNSIGNED NULL COMMENT 'admin yang memeriksa pembayaran',
  PRIMARY KEY (id_pembayaran),
  KEY idx_pembayaran_transaksi (id_transaksi),
  KEY idx_pembayaran_status (status_bayar),
  KEY idx_pembayaran_admin (id_admin_verifikasi),
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (id_transaksi)
    REFERENCES transaksi (id_transaksi)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_pembayaran_admin FOREIGN KEY (id_admin_verifikasi)
    REFERENCES admin (id_admin)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 10. struk : terbit saat pesanan siap (1 transaksi = 1 struk)
-- ---------------------------------------------------------------------
CREATE TABLE struk (
  id_struk       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_transaksi   INT UNSIGNED NOT NULL,
  nomor_struk    VARCHAR(30)  NOT NULL,
  tanggal_terbit DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_admin       INT UNSIGNED NULL COMMENT 'admin yang menerbitkan',
  PRIMARY KEY (id_struk),
  UNIQUE KEY uq_struk_transaksi (id_transaksi),
  UNIQUE KEY uq_struk_nomor (nomor_struk),
  KEY idx_struk_admin (id_admin),
  CONSTRAINT fk_struk_transaksi FOREIGN KEY (id_transaksi)
    REFERENCES transaksi (id_transaksi)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_struk_admin FOREIGN KEY (id_admin)
    REFERENCES admin (id_admin)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- DATA AWAL (opsional) -- isi sesuai toko sebenarnya.
-- Harga per ml (2500/3000/4000) berasal dari wawancara kasir.
-- Nama aroma, botol, alamat, dan rekening di bawah hanya CONTOH.
-- =====================================================================
INSERT INTO kategori_aroma (nama_kategori) VALUES
  ('Fresh'), ('Floral'), ('Woody'), ('Manis');

INSERT INTO info_toko (id_toko, nama_toko, alamat, jam_buka, no_whatsapp)
VALUES (1, '[Nama Toko]', '[Alamat]', '[Jam buka]', '[Nomor WhatsApp]');

INSERT INTO botol (nama_botol, ukuran_ml, harga_botol) VALUES
  ('Botol contoh 30 ml', 30, 0);

INSERT INTO aroma (id_kategori, nama_aroma, deskripsi, harga_per_ml, asal_produk, populer)
VALUES
  (1, 'Aroma Contoh A', 'Isi deskripsi/notes aroma', 2500, 'Diimpor dari Bandung', 0),
  (2, 'Aroma Contoh B', 'Isi deskripsi/notes aroma', 3000, 'Diimpor dari Bandung', 1),
  (3, 'Aroma Contoh C', 'Isi deskripsi/notes aroma', 4000, 'Diimpor dari Bandung', 0);

-- Akun admin: buat lewat aplikasi agar password di-hash, atau isi
-- password_hash dengan hash yang sudah dibuat. Jangan simpan password asli.
-- INSERT INTO admin (nama, username, password_hash, peran)
-- VALUES ('Pemilik', 'pemilik', '<hash>', 'pemilik');
