CREATE DATABASE IF NOT EXISTS db_pendaftaran;
USE db_pendaftaran;

CREATE TABLE IF NOT EXISTS pendaftar (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    tgl_input      DATE         NOT NULL,
    kode           VARCHAR(10)  NOT NULL,
    nama           VARCHAR(100) NOT NULL,
    jk             VARCHAR(10)  NOT NULL,
    asal_sekolah   VARCHAR(100) NOT NULL,
    pekerjaan_ortu VARCHAR(100) NOT NULL,
    tempat_lahir   VARCHAR(100) NOT NULL,
    tgl_lahir      DATE         NOT NULL,
    mat            INT          NOT NULL,
    bing           INT          NOT NULL,
    umum           INT          NOT NULL
);