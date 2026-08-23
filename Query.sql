CREATE TABLE Mahasiswa (
NIM VARCHAR(10) PRIMARY KEY,
nama VARCHAR (200) NOT NULL,
kode_jurusan VARCHAR(10),
gender ENUM('L','P') NOT NULL,
tempat VARCHAR(50) NOT NULL,
tanggal_lahir DATE NOT NULL,
alamat TEXT NOT NULL,
email VARCHAR(100) NOT NULL,
no_hp VARCHAR(15) NOT NULL,
FOREIGN KEY (kode_jurusan) REFERENCES jurusan(kode_jurusan)
);
