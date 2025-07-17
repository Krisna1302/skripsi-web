CREATE DATABASE IF NOT EXISTS skripsi_db;
USE skripsi_db;

DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS dosen;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Password untuk semua: admin123
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue');

INSERT INTO mahasiswa (username, password) VALUES 
('mhs1', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue');

INSERT INTO dosen (username, password) VALUES 
('dsn1', '$2y$12$tvXO9kK/uEedV5oo05COGO8yfsrOWoSrREmYZqohwR3rFaJQM/rue');

CREATE TABLE pengajuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    nim VARCHAR(20),
    judul TEXT,
    bidang VARCHAR(100),
    pembimbing VARCHAR(100),
    file VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Menunggu',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

