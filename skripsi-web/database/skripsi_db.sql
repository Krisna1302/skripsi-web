-- Buat Database
DROP DATABASE IF EXISTS skripsi_db;
CREATE DATABASE skripsi_db;
USE skripsi_db;

-- Tabel Admin
DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabel Mahasiswa
DROP TABLE IF EXISTS mahasiswa;
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    prodi VARCHAR(100) NOT NULL,
    foto VARCHAR(255)
);

-- Tabel Dosen
DROP TABLE IF EXISTS dosen;
CREATE TABLE dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabel Pengajuan
DROP TABLE IF EXISTS pengajuan;
CREATE TABLE pengajuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    judul TEXT NOT NULL,
    deskripsi TEXT NOT NULL,
    bidang VARCHAR(100) NOT NULL,
    pembimbing VARCHAR(100) NOT NULL,
    file VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'Menunggu',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Isi Data Admin
INSERT INTO admin (username, password) VALUES
('admin', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue'); 
-- Password: admin123

-- Isi Data Dosen
INSERT INTO dosen (username, password) VALUES
('dsn1', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue'); 
-- Password: admin123

-- Isi Data Mahasiswa (2 akun)
INSERT INTO mahasiswa (username, password, nama, nim, prodi, foto) VALUES
('mhs1', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue', 'Andi Pratama', '12345678', 'Teknik Informatika', NULL),
('mhs2', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue', 'Rina Kartika', '87654321', 'Sistem Informasi', NULL);
-- Password kedua akun mahasiswa: admin123
