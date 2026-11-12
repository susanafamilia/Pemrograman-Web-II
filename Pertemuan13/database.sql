
CREATE DATABASE IF NOT EXISTS db_tutor;
USE db_tutor;

-- Tabel "mahasiswa"
CREATE TABLE IF NOT EXISTS mahasiswa (
    id_mahasiswa VARCHAR(6)  NOT NULL,
    nama         VARCHAR(30) NOT NULL,
    jurusan      VARCHAR(20) NOT NULL,
    alamat       VARCHAR(30) NOT NULL,
    telepon      VARCHAR(12) NOT NULL,
    PRIMARY KEY (id_mahasiswa)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
