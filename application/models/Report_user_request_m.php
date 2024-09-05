<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_user_request_m extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  public function get_software_selesai($start_date, $end_date)
  {
    $this->db->select('COUNT(*) AS jumlah_req');
    $this->db->from('tbl_trans_user_requests');
    $this->db->where('jenis_request', 'SOFTWARE');
    $this->db->where_in('status_trans', ['Selesai', 'Proses-Selesai']);
    $this->db->where('created_at BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date));

    $result = $this->db->get()->row(); // Menggunakan row() karena kita hanya ingin satu baris hasil
    return $result->jumlah_req; // Mengambil nilai dari kolom jumlah_req
  }

  public function get_software_total($start_date, $end_date)
  {
    $this->db->select('COUNT(*) AS jumlah_req');
    $this->db->from('tbl_trans_user_requests');
    $this->db->where('jenis_request', 'SOFTWARE');
    $this->db->where('created_at BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date));

    $result = $this->db->get()->row(); // Menggunakan row() karena kita hanya ingin satu baris hasil
    return $result->jumlah_req; // Mengambil nilai dari kolom jumlah_req
  }


  public function get_hardware_selesai($start_date, $end_date)
  {
    $this->db->select('COUNT(*) AS jumlah_req');
    $this->db->from('tbl_trans_user_requests');
    $this->db->where('jenis_request', 'HARDWARE'); // Perbaikan pembanding string
    $this->db->where_in('status_trans', ['Selesai', 'Proses-Selesai']); // Perbaikan pembanding string
    $this->db->where('created_at BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date));
    $result = $this->db->get()->row(); // Menggunakan row() karena kita hanya ingin satu baris hasil
    return $result->jumlah_req; // Mengambil nilai dari kolom jumlah_req
  }

  public function get_hardware_total($start_date, $end_date)
  {
    $this->db->select('COUNT(*) AS jumlah_req');
    $this->db->from('tbl_trans_user_requests');
    $this->db->where('jenis_request', 'HARDWARE'); // Perbaikan pembanding string
    // $this->db->where('status_trans', 'Selesai'); // Perbaikan pembanding string
    $this->db->where('created_at BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date));
    $result = $this->db->get()->row(); // Menggunakan row() karena kita hanya ingin satu baris hasil
    return $result->jumlah_req; // Mengambil nilai dari kolom jumlah_req
  }

  public function get_jumlah_request_status($start_date, $end_date)
  {
    $this->db->select('COUNT(*) AS jumlah, status_trans');
    $this->db->from('tbl_trans_user_requests');
    $status_values = array('Pending', 'Proses-Pengerjaan', 'Menunggu-Sparepart', 'Proses-Selesai', 'Selesai');
    $this->db->where_in('status_trans', $status_values);
    $this->db->where('created_at BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date));
    $this->db->group_by('status_trans');
    $result = $this->db->get()->result();
    return $result;
  }
}