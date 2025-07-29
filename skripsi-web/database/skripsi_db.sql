-- Buat database (jika belum)
CREATE DATABASE IF NOT EXISTS skripsi_db;
USE skripsi_db;

-- Tabel mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    prodi VARCHAR(100) NOT NULL,
    foto VARCHAR(100) DEFAULT 'default.png'
);

-- Tabel dosen
CREATE TABLE IF NOT EXISTS dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    kaprodi VARCHAR(100) NOT NULL,
    foto VARCHAR(100) DEFAULT 'default.png'
);

-- Tabel pengajuan  
CREATE TABLE IF NOT EXISTS pengajuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    judul TEXT NOT NULL,
    deskripsi TEXT,
    bidang VARCHAR(100) NOT NULL,
    pembimbing VARCHAR(100) NOT NULL,
    file VARCHAR(100) NOT NULL,
    status ENUM('Menunggu', 'Diterima', 'Ditolak') DEFAULT 'Menunggu',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data Mahasiswa
INSERT INTO mahasiswa (username, password, nama, nim, prodi)
VALUES 
('putri', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Putri Wandayani', '06024006', 'Sistem Informasi'),
('peris', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Peris Trisna', '06024011', 'Teknik Informatika');

-- Data Dosen
INSERT INTO dosen (username, password, nama, nidn, kaprodi)
VALUES 
('yohanes', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Yohanes Eka Wibawa', '20232023', 'Teknik Informatika'),
('sri', '$2y$12$z.2.f7CSjPd0hGxRbd8IvOA9BJlMyEIe1SZuyAgolHcVIpmbjX7z2', 'Sri Wahyu', '20232024', 'Sistem Informasi');

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL
);

-- Tambah akun admin (username: admin, password: admin123)
INSERT INTO admin (username, password, nama) VALUES (
    'admin',
    '$2y$10$T0qVKvR3g4MdMEybY9xqN.zWh1emMHmHuk20V1XLWNSZFosq.m4Ea', -- hash dari "admin123"
    'Admin Utama'
);
