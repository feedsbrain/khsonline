<div id="container">
    <h3 class="tit">Bantuan Menu Konfigurasi</h3>
    <dl>
        <?php if ($level === 'A') { ?>        
            <dt><a href="<?php echo base_url() . 'users/' ?>"><strong>Users</strong></a></dt>
            <dd>Menu ini hanya tampil jika user anda memiliki Level A (Administrator). Dengan menu ini anda dapat 
                mengatur akses siapa saja yang berhak masuk kedalam sistem ini. Akses kepada mahasiswa akan diberikan secara otomatis setelah 
                mahasiswa tersebut melakukan pembayaran SPP yang pertama. Untuk user yang sudah tidak aktif (baik Administrator, Dosen atau Mahasiswa)
                ubah status usernya menjadi Inactive. Jangan pernah menghapus user yang sudah digunakan dalam sistem.</dd>
            <dt><a href="<?php echo base_url() . 'pengaturan/' ?>"><strong>Pengaturan</strong></a></dt>
            <dd>Sama seperti halnya dengan menu Users, menu Pengaturan ini hanya tampil jika user anda memiliki Level A. Fungsi menu ini
                kebanyakan digunakan dalam laporan dalam menentukan variabel laporan yang dapat berubah secara dinamis. Kolom Key merupakan Enumerated
                yang nilainya diset dari database. Dan kolom Value merupakan isi dari variable Key.</dd>
        <?php } ?>
        <dt><a href="<?php echo base_url() . 'informasi/' ?>"><strong>Ubah Informasi</strong></a></dt>
        <dd>Gunakan menu ini untuk mengubah informasi user anda. Mohon pastikan Nama dan Alamat email anda tercantum dengan benar. 
            Informasi ini merupakan detil dari Username anda di aplikasi ini. Jika anda adalah Mahasiswa yang memerlukan perubahan data nama
            pada KHS, anda juga harus menghubungi Bagian Administrasi kampus karena data user anda tidak terkait langsung dengan data Mahasiswa.</dd>
        <dt><a href="<?php echo base_url() . 'password/' ?>"><strong>Ganti Password</strong></a></dt>
        <dd>Silahkan ubah password untuk user anda melalui menu ini. Pilihlah password terbaik anda sendiri, jangan pernah beritahukan password 
            anda kepada siapapun. Jangan menggunakan nomor NIM atau Tanggal Lahir anda untuk password.</dd>
    </dl>
</div>