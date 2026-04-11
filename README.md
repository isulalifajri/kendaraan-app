
## About This Projects

Project ini saya buat menggunakan laravel versi 12, PHP 8.2.12 dan database nya menggunakan database MySQL

* untuk env nya tinggal ngambil dari env.example

untuk table user, kendaraan, dan driver ini menggunakan seeder.

jadi tinggal jalankan perintah ini: `php artisan migrate:fresh --seed` untuk mengisi otomatis tabel tsb.

utk menjalankan project : `php artisan serve`

email dan password untuk login:

```
*role admin
email : admin@mail.com
pwd : 123456

*role penyetuju level 1
email : manager@mail.com
pwd : 123456

*role penyetuju level 2
email : direktur@mail.com
pwd : 123456

* untuk user yang ditambahkan manual melalu cms passwordnya otomatis keisi: password


```

* menu yang ditampilkan pada role admin

``
- Dashboard
- Data Master
- Pemesanan
- Konsumsi BBM
- Jadwal Service
- Riwayat Pemakaian
- Log Activity
``

* menu yang di tampilkan dengan role penyetuju


``
- Dashboard
- Persetujuan
``