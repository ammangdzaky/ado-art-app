# 🌹 AdoArt - Digital Art Showcase & Challenge Platform

![AdoArt Banner](public/images/ado-logo.png)
*(Ganti gambar ini dengan screenshot aplikasi Anda setelah deployment)*

## 📖 Tentang Aplikasi
**AdoArt** adalah platform komunitas seni digital modern yang mempertemukan **Kreator (Member)** dan **Penyelenggara Acara (Curator)**. Aplikasi ini dibangun menggunakan **Laravel 11** dengan gaya desain *Dark Mode Cinematic* yang terinspirasi dari estetika visual penyanyi Ado (Dominasi warna Hitam & Indigo) serta struktur profesional ala ArtStation.

Aplikasi ini memfasilitasi pameran karya (Showcase), interaksi sosial, dan sistem kompetisi (Challenge) yang komprehensif mulai dari pendaftaran hingga pemilihan pemenang secara visual.

---

## 🚀 Fitur Unggulan

### 🎨 1. UI/UX & General Features
* **Cinematic Dark Mode:** Antarmuka gelap yang elegan, nyaman di mata, dan menonjolkan warna karya seni.
* **Responsive Design:** Tampilan optimal di Desktop (Grid Luas) dan Mobile (Stack Rapi & Drawer Menu).
* **Global Search:** Pencarian pintar di Navbar yang bisa mencari Karya Seni, Artis, dan Challenge sekaligus.
* **Marquee Banner:** Banner animasi bergerak di Homepage untuk mempromosikan Challenge yang sedang aktif.

### 👤 2. Role: Member (Artist)
* **Portfolio Management:** Upload, Edit, dan Hapus karya seni dengan fitur *Drag & Drop* preview.
* **Moodboards (Advanced Collections):** Menyimpan karya favorit ke dalam folder koleksi pribadi (menggantikan sistem Favorites biasa).
* **Interaksi Sosial:** Memberi Like, Komentar, dan Follow artis lain.
* **Challenge Participation:** Mengikuti lomba dengan memilih karya langsung dari portofolio (tanpa perlu upload ulang).
* **Profile Customization:** Mengganti Avatar, Bio, dan menyematkan link Media Sosial (Instagram, Twitter, Website) yang tampil di profil publik.

### 🏆 3. Role: Curator (Organizer)
* **Verification System:** Akun Curator baru berstatus **Pending** dan harus disetujui Admin sebelum bisa mengakses dashboard.
* **Challenge Management:** Membuat dan mengedit kompetisi seni (Judul, Hadiah dalam USD, Deadline, Banner).
* **Visual Winner Selection:** Memilih Juara 1, 2, dan 3 menggunakan antarmuka **Visual Grid** yang interaktif (klik gambar untuk memilih juara).
* **Curator Dashboard:** Statistik event, jumlah submisi yang masuk, dan status event aktif.

### 🛡️ 4. Role: Admin (Moderator)
* **User Management:** Memantau user, menghapus akun bermasalah, dan melakukan **Approval** terhadap Curator baru.
* **Content Moderation:** Menerima laporan pelanggaran (Report) dari member dan menghapus (Take Down) karya yang melanggar dari **Moderation Queue**.
* **Category Management:** Menambah dan mengelola kategori seni (misal: 3D Art, Pixel Art, Illustration).

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework:** Laravel 11 (PHP 8.2+)
* **Frontend Styling:** Tailwind CSS (Utility-first CSS framework)
* **Interactivity:** Alpine.js (Lightweight JavaScript framework untuk Modal, Dropdown, Tab System, dan AJAX Like/Save)
* **Database:** MySQL
* **Authentication:** Laravel Breeze (Blade Stack)
* **Icons:** Heroicons & SVG Custom

---

## ⚙️ Panduan Instalasi (Installation Guide)

Ikuti langkah-langkah ini untuk menjalankan proyek di komputer lokal Anda:

### 1. Clone Repository
```bash
git clone [https://github.com/username/adoart.git](https://github.com/username/adoart.git)
cd adoart
```

### 2. Install Dependencies
Install library PHP dan aset Frontend.
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Duplikat file .env.example menjadi .env dan atur database.
```bash
cp .env.example .env
```
Buka file .env dan sesuaikan konfigurasi database Anda:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_adoart
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key & Migrate Database
```bash
php artisan key:generate
php artisan migrate
```

### 5. Setup Storage
Langkah ini wajib agar gambar yang diupload (Avatar, Banner, Artwork) bisa muncul di browser.
```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi
Buka 2 terminal terpisah untuk menjalankan server backend dan build frontend secara bersamaan:
Terminal 1 (Backend Server):
```bash
php artisan serve
```
Terminal 2 (Frontend Build - Vite):
```bash
npm run dev
```
Akses aplikasi di browser melalui: http://127.0.0.1:8000