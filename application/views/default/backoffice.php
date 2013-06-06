<div id="container">
    <h2>Selamat datang di KHS Online</h2>
    <p>Halo <strong><?php echo $nama; ?></strong>, saat ini ada berada pada menu utama KHS Online. 
        Silahkan jelajahi menu <a href="<?php echo base_url() . 'backoffice/manajemen/' ?>"><strong>Manajemen</strong></a> 
        atau <a href="<?php echo base_url() . 'backoffice/konfigurasi/' ?>"><strong>Konfigurasi</strong></a> 
        untuk memulai menggunakan aplikasi ini. Tombol menu diatas merupakan <strong>Menu</strong> utama yang dapat anda akses. 
        Sedangkan daftar disamping (dibawah logo) merupakan <strong>Sub Menu</strong> yang dapat anda akses sesuai dengan hak akses 
        yang anda miliki. Hak akses ini ditentukan oleh Bagian Administrasi kampus.</p>
    <p>Mengingat informasi yang ada dalam aplikasi ini sangat penting, jika anda belum melakukan konfigurasi apapun disini, berikut
        adalah beberapa hal yang penting yang harus anda lakukan sebelum menggunakan aplikasi ini lebih lanjut.</p>
    <h3 class="tit">Konfigurasi Personal (Penting)</h3>
    <dl>
        <dt><a href="<?php echo base_url() . 'informasi/' ?>"><strong>Ubah Informasi</strong></a></dt>
        <dd>Mohon pastikan Nama dan Alamat email anda tercantum dengan benar pada menu ini. Informasi ini tidak ada kaitannya dengan
        data Mahasiswa. Informasi ini merupakan detil dari Username anda di aplikasi ini.</dd>
        <dt><a href="<?php echo base_url() . 'password/' ?>"><strong>Ganti Password</strong></a></dt>
        <dd>Pilihlah password anda sendiri untuk mengakses kedalam aplikasi. Jangan pernah beritahukan password anda kepada siapapun 
            dan pilihlah password terbaik. Jangan menggunakan nomor NIM atau Tanggal Lahir anda untuk password.</dd>
    </dl>
</div>