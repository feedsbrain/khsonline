<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pembayaran_model
 *
 * @author Indra
 */
class Pembayaran_model extends MY_Model {

    protected $_table_name = "pembayaran";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('security');
    }

    function generate_krs_from_pembayaran($id_pembayaran) {
        $this->db->trans_begin();

        $pembayaran = $this->db->get_where('pembayaran', array($this->_primary_key => $id_pembayaran))->row();
        $mahasiswa = $this->db->get_where('mahasiswa', array($this->_primary_key => $pembayaran->mahasiswa))->row();
        $kelas = $this->db->get_where('kelas', array($this->_primary_key => $mahasiswa->kelas))->row();
        $spp = $this->db->get_where('spp', array($this->_primary_key => $pembayaran->spp))->row();

        $user = $this->db->get_where('users', array('username' => $mahasiswa->nim))->row();

        $krs = array(
            'mahasiswa' => $mahasiswa->id,
            'tahun' => $spp->tahun,
            'semester' => $spp->semester,
            'dibuat_oleh' => $pembayaran->dibuat_oleh,
            'tanggal_dibuat' => date("Y-m-d H:i:s")
        );

        $this->db->insert('krs', $krs);
        $krs_id = $this->db->insert_id();

        $matakuliah = $this->db->get_where('matakuliah', array('semester' => $spp->semester, 'jurusan' => $kelas->jurusan))->result();

        foreach ($matakuliah as $value) {
            $krsdetail = array(
                'krs' => $krs_id,
                'matakuliah' => $value->id
            );
            $this->db->insert('krsdetail', $krsdetail);
        }

        if ($user) {
            $this->db->update('users', array('active' => true), array($this->_primary_key => $user->id));
        } else {
            $new_user = array(
                'username' => $mahasiswa->nim,
                'password' => do_hash($mahasiswa->nim, 'md5'),
                'level' => 'M',
                'name' => $mahasiswa->nama,
                'email' => 'mahasiswa@changeme.com',
                'active' => true,
                'system' => false
            );
            $this->db->insert('users', $new_user);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    function remove_krs_by_pembayaran($id_pembayaran) {
        $this->db->trans_begin();

        $pembayaran = $this->db->get_where('pembayaran', array($this->_primary_key => $id_pembayaran))->row();
        $mahasiswa = $this->db->get_where('mahasiswa', array($this->_primary_key => $pembayaran->mahasiswa))->row();
        $spp = $this->db->get_where('spp', array($this->_primary_key => $pembayaran->spp))->row();

        $krs = $this->db->get_where('krs', array('mahasiswa' => $mahasiswa->id, 'tahun' => $spp->tahun, 'semester' => $spp->semester))->row();

        $this->db->delete('krsdetail', array('krs' => $krs->id));
        $this->db->delete('krs', array($this->_primary_key => $krs->id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

}

/* End of file pembayaran_model.php */
/* Location: ./application/controllers/pembayaran_model.php */