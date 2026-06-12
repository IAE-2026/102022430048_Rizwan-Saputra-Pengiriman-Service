**Tugas 2**

1. pastikan kamu baca semuanya kemudian kamu pahamin tiap teks tersebut.

pada file "Proses Bisnis" itu adalah rancangan bagaimana proses bisnis tersebut dijalankan disertai detail api

untuk tema aku mendapatkan tema Supply Chain bagian service "Pengiriman/Expedition"
bantu aku mengerjakan step per step

2. lanjut eksekusi step pertama inisialisasi proyek Laravel

3. lanjut step 2 bikin Logic Controller sama Middleware keamanannya!

4. Tahap 3 pasang Swagger buat dokumentasinya

5. lanjut step 4 GraphQL Implementation

6. btw, set docker aku menggunakan sqlite
-----------------------------------------------------------------------------------------
**Tugas 3**

1. bro gua mau lanjutin tugas Integrasi Aplikasi Enterprise (IAE) khusus mengurus Service C (Pengiriman/Expedition).

2. fokus ke tugas 3, coba kamu pahamin apa yg dikerjain pada tugas 3

3. oke aku dapat maksud dari tugas ini yaitu untuk menghubungkan service C (Pengiriman) punyaku ke infrastruktur pak ekky, boleh kita langsung eksekusi buat melakukan integrasi

4. step perstep mengerjakannya sambil kamu jelaskan apa maksud code yg kamu buat

5. buatin class baru iaecentralservice

6. programnya sudah kamu buat, selanjutnya coba kita tes fungsi ke controller inbound shipments biar bisa ngeliat receipt number dari server

7. ini outputnya, apakah sudah benar sesuai dengan yg diminta pada penjelas tugas 3?

8. buatin sebaris kode tambahan di controller buat ngekstrak nomor resinya biar langsung kesimpen di database, baru setelah itu kita lanjut ke RabbitMQ

9. bantu aku ngecek Pastikan di database migration tabel inbound_shipments lu udah ada kolom legacy_receipt_number (tipe string/varchar, boleh nullable). Kalau belum ada, lu tambahin dulu di filemigration-nya terus jalanin php artisan migrate:fresh di dalam Docker.