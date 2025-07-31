-- 1. Buat database
CREATE DATABASE IF NOT EXISTS skripsi_db;
USE skripsi_db;

-- 2. Tabel mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    prodi VARCHAR(100) NOT NULL,
    foto VARCHAR(100) DEFAULT 'default.png'
);

-- 3. Tabel dosen
CREATE TABLE IF NOT EXISTS dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    kaprodi VARCHAR(100) NOT NULL,
    foto VARCHAR(100) DEFAULT 'default.png'
);

-- 4. Tabel pengajuan (dengan FK ke mahasiswa.nim dan dosen.nidn)
CREATE TABLE IF NOT EXISTS pengajuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    judul TEXT NOT NULL,
    deskripsi TEXT,
    bidang VARCHAR(100) NOT NULL,
    pembimbing VARCHAR(100) NOT NULL,
    nidn VARCHAR(20), -- FK ke dosen.nidn, bisa NULL saat belum dipilih
    komentar TEXT,
    file VARCHAR(100) NOT NULL,
    status ENUM('Menunggu', 'Diterima', 'Ditolak') DEFAULT 'Menunggu',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pengajuan_mhs FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_pengajuan_dosen FOREIGN KEY (nidn) REFERENCES dosen(nidn)
        ON DELETE SET NULL ON UPDATE CASCADE
);

-- 5. Tabel admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL
);

-- 6. Isi data mahasiswa
INSERT INTO mahasiswa (username, password, nama, nim, prodi) VALUES
('putri', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Putri Wandayani', '06024006', 'Sistem Informasi'),
('peris', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Peris Trisna', '06024011', 'Teknik Informatika');

-- 7. Isi data dosen
INSERT INTO dosen (username, password, nama, nidn, kaprodi) VALUES
('yohanes', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Yohanes Eka Wibawa', '20232023', 'Teknik Informatika'),
('sri', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Sri Wahyu', '20232024', 'Sistem Informasi');

-- 8. Isi akun admin (admin / admin123)
INSERT INTO admin (username, password, nama) VALUES
('admin', '$2y$10$T0qVKvR3g4MdMEybY9xqN.zWh1emMHmHuk20V1XLWNSZFosq.m4Ea', 'Admin Utama');
