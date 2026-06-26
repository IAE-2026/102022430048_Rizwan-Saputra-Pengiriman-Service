# IAE - Tugas 2: Pengiriman Service (Expedition)

Layanan ini dibangun menggunakan Laravel 11. Endpoint yang tersedia mendukung baik arsitektur REST (Swagger) maupun GraphQL.
Service ini menggunakan **SQLite** sebagai database lokal, sehingga sangat mudah untuk dijalankan untuk keperluan testing/penilaian tanpa perlu mengatur koneksi database terpisah.

## Cara Menjalankan Project (Local / Native)
Pastikan Anda memiliki PHP (>= 8.2) dan Composer.

1. Install dependencies:
   ```bash
   composer install
   ```
2. Copy konfigurasi environment (jika `.env` belum ada):
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Konfigurasi otomatis menggunakan SQLite. Pastikan file `database/database.sqlite` sudah ada. Jika belum:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```
4. Jalankan local server:
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://localhost:8000`.

## Cara Menjalankan Project (Docker)
Konfigurasi `docker-compose.yml` sudah disiapkan dengan otomatisasi instalasi.

1. Build dan jalankan container:
   ```bash
   docker-compose up -d --build
   ```
2. Aplikasi akan langsung ter-install (composer, migrate, env, dll) di belakang layar.
3. Aplikasi akan dapat diakses melalui port standar `8000`: `http://localhost:8000`.

*(Catatan: SQLite otomatis ter-generate di dalam file bind /var/www saat docker-compose dijalankan).*

## Testing API

### 1. REST API (Swagger UI)
Buka browser dan arahkan ke: `http://localhost:8000/api/documentation`

- Klik tombol **Authorize** di kanan atas.
- Masukkan NIM: `102022430048` (atau sesuai konfigurasi di `.env`) sebagai `X-IAE-KEY`.
- Anda dapat mencoba endpoint `GET` maupun `POST` untuk Inbound Shipments.

### 2. GraphQL (Playground)
Buka browser dan arahkan ke: `http://localhost:8000/graphql-playground`

- Di bagian bawah halaman (panel *HTTP HEADERS*), masukkan otorisasi berikut agar diizinkan oleh middleware:
  ```json
  {
    "X-IAE-KEY": "102022430048"
  }
  ```
- Contoh Query:
  ```graphql
  query {
    inboundShipments {
      id
      tracking_number
      supplier_name
      status
    }
  }
  ```
