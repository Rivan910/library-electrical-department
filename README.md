# Library Electrical P611 — Workshop Technical Library

Sistem Informasi Perpustakaan Dokumen Teknis, Katalog Drawing, Manual Book, dan Direktori Lokasi Rak Penyimpanan untuk **Workshop Electrical Department P611 (PT Indocement Tunggal Prakarsa Tbk)** yang terintegrasi otomatis dengan **Google Sheets**.

---

## Fitur Utama

1. **Autentikasi Pengguna (`Login`)**:
   - Login menggunakan **Username** dan **Password** dengan tampilan khusus **Library Electrical P611** dan *background slideshow* (durasi 3 detik per gambar).
   - Mendukung pembagian hak akses `admin` dan `viewer`.

2. **Dashboard & Katalog Dokumen (`Library`)**:
   - **4 Kartu Statistik Real-Time**:
     - **Total Documents**: Total seluruh dokumen yang terdaftar di Google Spreadsheet.
     - **Available**: Jumlah dokumen yang kondisinya baik / tersedia di rak (otomatis berkurang jika kolom `Notes` ditandai `Rusak`, `Hilang`, atau `Dipinjam`).
     - **Racks**: Jumlah lokasi rak fisik aktif (`R-01`, `R-02`, dst.).
     - **Manuals & As-Built**: Jumlah dokumen kategori Manual & As-Built.
   - **Pencarian Multi-Kolom**: Mencari dokumen berdasarkan `Document No`, `Vendor`, `Title`, maupun `Rack` (termasuk format ketik `R-02` atau `Rak 2`), serta mendukung multi-kata kunci dengan `&`.
   - **Filter Dropdown Dinamis**: Filter berdasarkan **Vendor**, **Type / Content**, dan **Rack**.
   - **Modal Detail Dokumen**: Melihat detail lengkap dokumen dan lokasi penyimpanan raknya.

3. **Sinkronisasi Otomatis Google Sheets (`tab: library`)**:
   - Membaca data dari tab **`library`** (`A3:G`) pada Google Spreadsheet **Electrical Departemen**:
     - Kolom A: `No`
     - Kolom B: `Document No`
     - Kolom C: `Vendor`
     - Kolom D: `Tittle`
     - Kolom E: `Content`
     - Kolom F: `Rack`
     - Kolom G: `Notes`
   - Sinkronisasi berjalan otomatis setiap 60 detik atau dapat dijalankan melalui perintah Artisan:
     ```bash
     php artisan sheets:sync-library
     ```

---

## Struktur Database (`library_electrical_dept`)

- **`users`**: Menyimpan akun pengguna (`id`, `name` / username, `email`, `password`, `role`).
- **`documents`**: Menyimpan katalog dokumen perpustakaan yang disinkronkan dari Google Sheets (`id`, `sheet_row_number`, `no`, `document_no`, `vendor`, `title`, `content`, `rack`, `notes`).
- **`cache` & `sessions`**: Menyimpan cache sinkronisasi Google Sheets dan sesi login pengguna.

---

## Panduan Instalasi Lokal (Laragon)

1. **Install Dependency**:
   ```bash
   composer install
   npm install
   npm run build
   ```
2. **Konfigurasi `.env`**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. **Migrasi & Seed Database**:
   ```bash
   php artisan migrate --seed
   php artisan sheets:sync-library
   ```
4. **Jalankan Server**:
   ```bash
   php artisan serve
   ```
