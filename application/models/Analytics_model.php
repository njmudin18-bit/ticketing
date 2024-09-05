<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analytics_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  public function get_perangkat_berdasarkan_jenis()
  {
    $this->db->select('COUNT(*) AS JLH_PERANGKAT, b.jenis AS JENIS_PERANGKAT');
    $this->db->from('tbl_perangkat a');
    $this->db->join('tbl_jenis_perangkat b', 'b.id = a.id_jenis_perangkat', 'left');
    $this->db->group_by('b.jenis');
    $result = $this->db->get()->result();

    return $result;
  }

  public function get_perangkat_by_perusahaan()
  {
    $this->db->select('COUNT(*) AS JLH_PERANGKAT, b.nama AS NAMA_PERUSAHAAN');
    $this->db->from('tbl_perangkat a');
    $this->db->join('tbl_perusahaan b', 'b.id = a.company_id', 'left');
    $this->db->group_by('b.nama');
    $result = $this->db->get()->result();

    return $result;
  }
}
