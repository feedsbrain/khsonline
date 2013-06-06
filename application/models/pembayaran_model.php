<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Pembayaran Model
 * 
 * File: pembayaran_model.php
 * 
 * @package application/models
 * @author Indra <indra@indragunawan.com>
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

        $row_count = $this->db->get_where('pembayaran', array('spp' => $spp->id, 'mahasiswa' => $mahasiswa->id))->num_rows();
        echo 'trace $row_count = ' . $row_count;

        // only create krs on first pembayaran
        if ($row_count == 1) {
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

        $row_count = $this->db->get_where('pembayaran', array('spp' => $spp->id, 'mahasiswa' => $mahasiswa->id))->num_rows();

        // delete krs if no pembayaran records left
        if ($row_count == 1) {
            $krs = $this->db->get_where('krs', array('mahasiswa' => $mahasiswa->id, 'tahun' => $spp->tahun, 'semester' => $spp->semester))->row();

            $this->db->delete('krsdetail', array('krs' => $krs->id));
            $this->db->delete('krs', array($this->_primary_key => $krs->id));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

}

/* End of file pembayaran_model.php */
/* Location: ./application/controllers/pembayaran_model.php */