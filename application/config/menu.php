<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['main_menu_main'] = array(
    'beranda' => array('main/', array('M')),
    'manajemen' => array('backoffice/manajemen/', array('A', 'D', 'M')),
    'konfigurasi' => array('backoffice/konfigurasi/', array('A', 'D', 'M'))
);

$config['side_menu_main'] = array(
    'manajemen' => array('backoffice/manajemen/', array('A', 'D', 'M')),
    'konfigurasi' => array('backoffice/konfigurasi/', array('A', 'D', 'M'))
);

$config['main_menu_backoffice'] = array(
    'beranda' => array('main/', array('M')),
    'back_office' => array('backoffice/', array('A', 'D')),
    'manajemen' => array('backoffice/manajemen/', array('A', 'D', 'M')),
    'konfigurasi' => array('backoffice/konfigurasi/', array('A', 'D', 'M'))
);

$config['side_menu_backoffice'] = array(
    'manajemen' => array('backoffice/manajemen/', array('A', 'D')),
    'konfigurasi' => array('backoffice/konfigurasi/', array('A', 'D', 'M'))
);

$config['side_menu_manajemen'] = array(
    'fakultas' => array('fakultas/', array('A')),
    'jurusan' => array('jurusan/', array('A')),
    'mata_kuliah' => array('matakuliah/', array('A')),
    'kelas' => array('kelas/', array('A')),
    'mahasiswa' => array('mahasiswa/', array('A', 'D')),
    'spp' => array('spp/', array('A')),
    'kartu_studi' => array('krs/', array('A', 'D', 'M')),
    'penilaian' => array('penilaian/', array('A', 'D')),
    'transkrip' => array('transkrip/', array('A', 'M')),
    'history' => array('pembayaran/history/', array('A', 'M')),
);

$config['side_menu_konfigurasi'] = array(
    'users' => array('users/', array('A')),
    'pengaturan' => array('pengaturan/', array('A')),
    'ubah_informasi' => array('informasi/', array('A', 'D', 'M')),
    'ganti_password' => array('password/', array('A', 'D', 'M'))
);

$config['main_menu_login'] = array();

$config['side_menu_login'] = array();

/* End of file menu.php */
/* Location: ./application/config/menu.php */