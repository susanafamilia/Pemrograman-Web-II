-- Opsional: alternatif jika tidak mau menjalankan file PHP pembuat database.
CREATE DATABASE IF NOT EXISTS lat_dbase;
USE lat_dbase;
CREATE TABLE IF NOT EXISTS tbl_mhs (
  mhsID int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(mhsID),
  FirstName varchar(15),
  LastName varchar(15),
  Age int
);

CREATE DATABASE IF NOT EXISTS bukutamu_db CHARACTER SET utf8mb4;
USE bukutamu_db;
CREATE TABLE IF NOT EXISTS tbl_bukutamu (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  komentar TEXT NOT NULL,
  tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
