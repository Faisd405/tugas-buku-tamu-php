# Dokumentasi Aplikasi Buku Tamu

Aplikasi Buku Tamu adalah sistem pengelolaan data pengunjung sederhana yang dikembangkan menggunakan PHP dan MySQL. Aplikasi ini memungkinkan pencatatan dan pelacakan kunjungan tamu dengan data lengkap seperti nama pengunjung, instansi, tujuan kunjungan, serta tanggal dan waktu kunjungan.

## Fitur Utama

1. **Pencatatan Data Pengunjung**:
   - Nama pengunjung
   - Asal instansi
   - Tujuan kunjungan
   - Tanggal dan waktu kunjungan

2. **Pengelolaan Data**:
   - Melihat daftar semua pengunjung
   - Mencari data berdasarkan nama atau instansi
   - Melihat detail data pengunjung
   - Mengedit data pengunjung
   - Menghapus data pengunjung

3. **Antarmuka yang User-Friendly**:
   - Interface responsif menggunakan Bootstrap 5
   - Navigasi yang mudah dan intuitif
   - Konfirmasi sebelum penghapusan data
   - Validasi form untuk mencegah kesalahan input

## Style MySQLi yang Digunakan

Aplikasi ini menggunakan **style Object-Oriented Programming (OOP)** dari MySQLi untuk berinteraksi dengan database. Style OOP dipilih karena beberapa keuntungan:

1. **Enkapsulasi**: Koneksi database dan operasi terkait dikelola dalam kelas `Database` dan `GuestEntry`, memudahkan pengelolaan dan pemeliharaan kode.

2. **Modularitas**: Setiap kelas memiliki tanggung jawab spesifik yang menjadikan kode lebih terstruktur:
   - `koneksi.php`: Menangani koneksi database
   - `GuestEntry.php`: Menangani operasi CRUD pada tabel buku tamu

3. **Keamanan**: Prepared statements diimplementasikan secara konsisten untuk mencegah SQL injection.

Contoh penggunaan style OOP:

```php
// Koneksi database dengan style OOP
$database = new Database();
$conn = $database->getConnection();

// Prepared statements untuk keamanan
$stmt = $conn->prepare("SELECT * FROM buku_tamu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
```

## Struktur Database

Aplikasi menggunakan database MySQL dengan nama `db_bukutamu` yang terdiri dari 1 tabel utama:

### Tabel `buku_tamu`

| Kolom        | Tipe Data     | Keterangan                       |
|--------------|---------------|----------------------------------|
| id           | INT           | Primary key, Auto Increment      |
| nama         | VARCHAR(100)  | Nama tamu                        |
| instansi     | VARCHAR(100)  | Instansi tamu                    |
| tujuan       | TEXT          | Tujuan kunjungan                 |
| tanggal      | DATE          | Tanggal kunjungan                |
| waktu        | TIME          | Waktu kunjungan                  |

Script SQL untuk membuat tabel:

```sql
CREATE TABLE buku_tamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    instansi VARCHAR(100) NOT NULL,
    tujuan TEXT NOT NULL,
    tanggal DATE NOT NULL,
    waktu TIME NOT NULL
);
```

## Alur Kerja Aplikasi

### 1. Struktur Aplikasi

Aplikasi mengikuti pola arsitektur Model-View-Controller (MVC) sederhana:

- **Models**: `GuestEntry.php` - Menangani operasi database dan logika bisnis
- **Views**: File-file tampilan (index.php, create.php, update.php, dll.)
- **Controllers**: `GuestEntryController.php` - Menangani logika aplikasi dan alur kerja

### 2. Alur Kerja CRUD

#### Create (Tambah Data)
1. User mengakses halaman form tambah tamu (create.php)
2. User mengisi form dengan data tamu baru (nama, instansi, tujuan, tanggal dan waktu kunjungan)
3. Sistem memvalidasi input dari user
4. Jika valid, `GuestEntryController` meneruskan data ke model `GuestEntry` untuk disimpan di database
5. Sistem menampilkan pesan sukses/gagal dan mengarahkan kembali ke halaman utama

#### Read (Tampil Data)
1. Saat mengakses halaman utama (index.php), `GuestEntryController` meminta data dari model `GuestEntry`
2. Model mengambil semua data tamu dari database
3. Data ditampilkan dalam bentuk tabel di halaman utama
4. User dapat menggunakan form pencarian untuk mencari tamu berdasarkan nama atau instansi
5. User dapat mengklik tombol "Detail" untuk melihat informasi lengkap tamu di read.php

#### Update (Edit Data)
1. User mengklik tombol "Edit" pada entri tamu yang ingin diubah
2. Sistem menampilkan form edit (update.php) yang sudah terisi dengan data tamu yang ada
3. User mengubah data yang diinginkan
4. Sistem memvalidasi input user
5. Jika valid, `GuestEntryController` meneruskan data ke model `GuestEntry` untuk memperbarui database
6. Sistem menampilkan pesan sukses/gagal dan mengarahkan kembali ke halaman utama

#### Delete (Hapus Data)
1. User mengklik tombol "Hapus" pada entri tamu yang ingin dihapus
2. Sistem menampilkan konfirmasi penghapusan melalui modal
3. Jika user mengkonfirmasi, `GuestEntryController` meneruskan ID tamu ke model `GuestEntry` untuk dihapus
4. Sistem menampilkan pesan sukses/gagal dan memperbarui halaman utama

### 3. Keamanan

- Semua operasi database menggunakan prepared statements untuk mencegah SQL injection
- Validasi input dilakukan baik di sisi klien maupun server
- Data output di-sanitasi menggunakan `htmlspecialchars()` untuk mencegah XSS attack
- Error handling yang tepat untuk menampilkan pesan yang informatif

Aplikasi ini dirancang dengan fokus pada kesederhanaan namun tetap memenuhi standar keamanan dan fungsionalitas yang diperlukan untuk operasi CRUD dasar buku tamu.
- Error handling yang tepat untuk menampilkan pesan yang informatif

Aplikasi ini dirancang dengan fokus pada kesederhanaan namun tetap memenuhi standar keamanan dan fungsionalitas yang diperlukan untuk operasi CRUD dasar buku tamu.