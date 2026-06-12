**ANALISIS TUGAS 3 INTEGRASI APLIKASI ENTERPRISE**
Nama: Rizwan Saputra
NIM: 102022430048
Kelas: SI-48-09
Kelompok: 03
Service: Pengiriman/Expedition

Saya memilih transaksi inbound shipment sebagai transaksi kritis dan harus diintegrasiin ke infrastruktur pusat, berikut alasannya:

1. Mengubah Status Ketersediaan Stok: Penerimaan manifest/resi pengiriman adalah terjadinya proses supply chain. Transaksi ini mengubah status pergerakan barang menjadi on_the_way dan menentukan estimasi kedatangan bahan baku

2. Kewajiban Audit (SOAP Legacy): Karena melibatkan logistik perusahaan, aktivitas ini harus diaudit. Pengiriman data ke sistem Legacy SOAP memastikan tiap resi yang dibuat disimpan ke pusat secara permanen dan tidak bisa dimanipulasi. 

3. Trigger Service Lain (RabbitMQ Broker): Setelah manifest/resi diterima, informasi itu harus segera diteruskan ke layanan lain menggunakan RabbitMQ. Supaya service lain dapat langsung bersiap, tanpa harus menunggu request manual.