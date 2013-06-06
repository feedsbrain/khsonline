<div id="container">
    <h3 class="tit">Bantuan Menu Manajemen</h3>
    <dl>
        <?php if ($level === 'A') { ?>        
            <dt><a href="<?php echo base_url() . 'fakultas/' ?>"><strong>Fakultas</strong></a></dt>
            <dd>Menu ini digunakan untuk manajemen data Fakultas di kampus. Data Fakultas ini nantinya akan dikaitkan ke data Jurusan. Lakukan pengisian 
                data Fakultas terlebih dahulu sebelum melakukan pengisian data Jurusan. Agar lebih mudah, anda dapat menambah Jurusan langsung dari menu 
                Fakultas ini dengan memilih icon <strong>Tambah Jurusan</strong> pada kolom Pilihan.</dd>
            <dt><a href="<?php echo base_url() . 'jurusan/' ?>"><strong>Jurusan</strong></a></dt>
            <dd>Menu ini digunakan untuk manajemen data Jurusan di Fakultas. Data Jurusan ini nantinya akan dikaitkan ke data Kelas dan Mata Kuliah. 
                Lakukan pengisian data Jurusan terlebih dahulu sebelum melakukan pengisian data Kelas atau Mata Kuliah. Agar lebih mudah, anda dapat menambah 
                Kelas atau Mata Kuliah langsung dari menu Jurusan ini dengan memilih icon <strong>Tambah Kelas</strong> untuk menambah Kelas dan 
                <strong>Tambah Mata Kuliah</strong> untuk menambah Mata Kuliah pada kolom Pilihan.</dd>
            <dt><a href="<?php echo base_url() . 'matakuliah/' ?>"><strong>Mata Kuliah</strong></a></dt>
            <dd>Menu ini digunakan untuk manajemen data Mata Kuliah di kampus. Data Mata Kuliah ini nantinya akan dikaitkan ke data Kartu Studi (KRS/KHS) 
                dan SPP (proses generate KRS untuk Mahasiswa yang sudah membayar biaya SPP). Lakukan pengisian data Mata Kuliah terlebih dahulu sebelum 
                melakukan pengisian data Kartu Studi atau SPP.</dd>
            <dt><a href="<?php echo base_url() . 'kelas/' ?>"><strong>Kelas</strong></a></dt>
            <dd>Menu ini digunakan untuk manajemen data Kelas di Jurusan. Data Kelas ini nantinya akan dikaitkan ke data Mahasiswa. Lakukan pengisian data 
                Kelas terlebih dahulu sebelum melakukan pengisian data Mahasiswa. Agar lebih mudah, anda dapat menambah Mahasiswa langsung dari menu 
                Kelas ini dengan memilih icon <strong>Tambah Mahasiswa</strong> pada kolom Pilihan.</dd>
        <?php } ?>
        <?php if ($level === 'A' || $level === 'D') { ?>   
            <dt><a href="<?php echo base_url() . 'mahasiswa/' ?>"><strong>Mahasiswa</strong></a></dt>
            <dd>Menu ini digunakan untuk manajemen data Mahasiswa di Kampus. Untuk mempermudah proses entry, buatlah satu data Mahasiswa dengan memilih Kelas 
                dan Angkatan yang sesuai, kemudian pada daftar Mahasiswa, pilih icon <strong>Tambah Teman</strong> pada kolom Pilihan untuk menambah Mahasiswa lain
                dengan informasi Kelas dan Angkatan yang sama.</dd>
        <?php } ?>
        <?php if ($level === 'A') { ?>
            <dt><a href="<?php echo base_url() . 'spp/' ?>"><strong>SPP</strong></a></dt>
            <dd>Menu ini digunakan untuk melakukan manajemen data SPP. Pembuatan SPP dilakukan di setiap awal Semester dan setiap Tahun Ajaran. Pilih nama SPP yang
                informatif untuk memudahkan anda dalam melakukan pencarian data. Untuk memasukan rincian SPP, pilih icon <strong>Rincian</strong> pada kolom Pilihan. Sedangkan
                untuk memasukan data Pembayaran SPP, silahkan pilih icon <strong>Pembayaran</strong> pada kolom Pilihan. Anda tidak dapat mengubah Rincian SPP setelah SPP
                ditetapkan dan anda juga tidak dapat melakukan input Pembayaran SPP jika SPP belum ditetapkan.<br/><br/>Mahasiswa yang sudah melakukan pembayaran SPP akan 
                diberikan akses ke Kartu Studi untuk Semester dan Tahun Ajaran yang sesuai dengan SPP yang dibayarkan. Sebaliknya jika pembayaran SPP dihapus, maka data
                Kartu Studi yang terkait dengan SPP tersebut juga akan otomatis dihapus. Harap berhati-hati dengan menu ini.</dd>
        <?php } ?>        
        <dt><a href="<?php echo base_url() . 'krs/' ?>"><strong>Kartu Studi</strong></a></dt>
        <dd>Bagi Mahasiswa, menu ini merupakan sarana untuk menyusun Kartu Rencana Studi (KRS) sebelum ditetapkan. Kemudian jika
            Mahasiswa sudah melakukan Penetapan terhadap Kartu Studi tersebut, maka status Kartu Studi akan berubah menjadi Kartu Hasil Studi (KHS). Bagi Dosen, menu ini merupakan 
            sarana untuk memasukan Nilai jika KRS sudah ditetapkan. Dosen memiliki akses terhadap seluruh Mahasiswa.</dd>
        <?php if ($level === 'A' || $level === 'D') { ?>   
            <dt><a href="<?php echo base_url() . 'penilaian/' ?>"><strong>Penilaian</strong></a></dt>
            <dd>Menu ini merupakan jalan pintas bagi Dosen atau Administrator untuk memberikan Penilaian (pengisian KHS) Mahasiswa. Dengan memasukan parameter Tahun Ajaran, Semester
                dan Mata Kuliah yang dimaksud, maka akan ditampilkan seluruh Mahasiswa yang mengambil mata kuliah tersebut untuk tahun dan semester yang dipilih. Lakukan "Double Klik" pada 
                kolom yang nilainya akan diubah. Jika indikator berwarna merah, artinya isian yang anda masukan tidak tepat dan perubahan tidak akan disimpan ke database. Sebaliknya jika 
                indikator berwarna hijau setelah nilai anda simpan, artinya perubahan telah berhasil disimpan ke database.</dd>
        <?php } ?>
        <?php if ($level === 'A') { ?>   
            <dt><a href="<?php echo base_url() . 'transkrip/' ?>"><strong>Transkrip</strong></a></dt>
            <dd>Menu ini digunakan untuk membuat header Transkrip Mahasiswa seperti No. Seri, No. Registrasi Ijazah dan sebagainya. Satu Mahasiswa hanya memiliki satu data transkrip, 
                dimana proses populasi data nilai akan otomatis dilakukan oleh sistem. Administrator dapat melihat seluruh daftar mahasiswa dan transkripnya. Sedangkan Mahasiswa hanya
                melihat data transkrip miliknya sendiri. Untuk melihat transkrip, pilih icon <strong>Lihat Transkrip</strong>.</dd>
        <?php } ?>
        <?php if ($level === 'M') { ?>   
            <dt><a href="<?php echo base_url() . 'transkrip/' ?>"><strong>Transkrip</strong></a></dt>
            <dd>Menu ini digunakan untuk melihat Transkrip Nilai Mahasiswa. Nilai yang tampil disini merupakan nilai seluruh mata kuliah yang sudah diambil oleh mahasiswa yang bersangkutan. 
                Jika mahasiswa yang bersangkutan mengulang satu atau beberapa mata kuliah, maka nilai yang diambil adalah nilai yang tertinggi dari mata kuliah yang diulang tersebut. 
                Untuk melihat transkrip, pilih icon <strong>Lihat Transkrip</strong>.</dd>
        <?php } ?>
        <?php if ($level === 'A' || $level === 'M') { ?>   
            <dt><a href="<?php echo base_url() . 'pembayaran/history' ?>"><strong>History</strong></a></dt>
            <dd>Menu ini digunakan untuk melihat daftar Pembayaran SPP Mahasiswa yang sudah diinput. Mahasiswa hanya dapat melihat history pembayaran miliknya sendiri, sedangkan 
                Bagian Administrasi kampus dapat melihat seluruh daftar pembayaran yang sudah masuk.</dd>
        <?php } ?>
    </dl>
</div>