CREATE TABLE karyawan (
    id INT PRIMARY KEY,
    nama VARCHAR(255),
    upah_per_jam INT,
    jam_kerja INT,
    jam_lembur INT);

INSERT INTO karyawan (id, nama, upah_per_jam, jam_kerja, jam_lembur) VALUES
(01, 'Vykall', 50000, 48, 0),
(02, 'Illya', 45000, 48, 0),
(03, 'Nael', 40000, 48, 0),
(04, 'Gwi', 60000, 48, 0),
(05, 'Leon', 55000, 48, 0);
