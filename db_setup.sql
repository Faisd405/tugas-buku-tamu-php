DROP TABLE IF EXISTS buku_tamu;

CREATE TABLE buku_tamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    instansi VARCHAR(100) NOT NULL,
    tujuan TEXT NOT NULL,
    tanggal DATE NOT NULL,
    waktu TIME NOT NULL
);

INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES
('Budi Santoso', 'PT Maju Bersama', 'Pertemuan dengan manajer', '2023-10-01', '09:00:00'),
('Dewi Sukarno', 'CV Abadi Jaya', 'Diskusi proyek', '2023-10-02', '10:30:00'),
('Ahmad Hidayat', 'Yayasan Pendidikan Indonesia', 'Demo produk', '2023-10-03', '14:00:00'),
('Ratna Sari', 'PT Global Nusantara', 'Pertemuan dengan klien', '2023-10-04', '11:15:00'),
('Dimas Prayoga', 'Koperasi Sejahtera', 'Sesi strategi', '2023-10-05', '13:45:00');