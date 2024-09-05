<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perangkat_new_model extends CI_Model
{

  var $table = 'tbl_perangkat_new';
  var $column_order   = array('A.id', 'A.kode_asset', 'A.kode_perangkat', 'A.dept_id', 'A.nama_perangkat', 'A.spesifikasi', 'A.status', 'A.ip_address', 'A.pass_pc', 'B.nama', 'C.nama_dept',  'E.nama_pegawai', 'D.jenis', null);
  var $column_search  = array('A.id', 'A.kode_asset', 'A.kode_perangkat', 'A.dept_id', 'A.nama_perangkat', 'A.spesifikasi', 'A.status', 'A.ip_address', 'A.pass_pc', 'B.nama', 'C.nama_dept',  'E.nama_pegawai', 'D.jenis');
  var $order = array('A.id' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_current_user($dept)
  {
    $getCurrentUser = $this->db->select('id, nama_pegawai')
      ->from('tbl_user')
      ->where('dept_id', $dept)
      ->get()
      ->result();

    return $getCurrentUser;
    // var_dump($getCurrentUser);
    // exit;
  }

  public function generate_perangkat_number($pt)
  {
    $currentDate = date('Ymd');
    if ($pt == "MAS") {
      //cari no request terakhir di db
      $lastRequest = $this->db->select('kode_perangkat')
        ->from('tbl_perangkat_new')
        ->like('kode_perangkat', 'MAS', 'after')
        ->order_by('kode_perangkat', 'DESC')
        ->limit(1)
        ->get()
        ->row();
      if ($lastRequest) {
        // Jika ada nomor request sebelumnya, tambahkan 1 ke nomor tersebut
        $lastNumber = substr($lastRequest->kode_perangkat, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $requestNumber = 'MAS' . $currentDate . $newNumber;
      } else {
        // Jika ini adalah nomor request pertama, gunakan nomor 001
        $requestNumber = 'MAS' . $currentDate . '001';
      }
      return $requestNumber;
    } else {
      //cari no request terakhir di db
      $lastRequest = $this->db->select('kode_perangkat')
        ->from('tbl_perangkat_new')
        ->like('kode_perangkat', 'MAIN', 'after')
        ->order_by('kode_perangkat', 'DESC')
        ->limit(1)
        ->get()
        ->row();
      if ($lastRequest) {
        // Jika ada nomor request sebelumnya, tambahkan 1 ke nomor tersebut
        $lastNumber = substr($lastRequest->kode_perangkat, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $requestNumber = 'MAIN' . $currentDate . $newNumber;
      } else {
        // Jika ini adalah nomor request pertama, gunakan nomor 001
        $requestNumber = 'MAIN' . $currentDate . '001';
      }
      return $requestNumber;
    }
  }

  private function _get_datatables_query()
  {
    //$this->db->from($this->table);

    $this->db->select("A.id, A.kode_perangkat, A.kode_asset, A.dept_id, A.spesifikasi, A.status, A.nama_perangkat, A.ip_address, A.pass_pc, B.nama, C.nama_dept, A.id_current_user,E.nama_pegawai,D.jenis");
    $this->db->from('tbl_perangkat_new A');
    $this->db->join('tbl_perusahaan B', 'B.id = A.company_id', 'left');
    $this->db->join('tbl_department C', 'C.id = A.dept_id', 'left');
    $this->db->join('tbl_jenis_perangkat D', 'D.id = A.id_jenis_perangkat', 'left');
    $this->db->join('tbl_user E', 'E.id = A.id_current_user', 'left');
    $this->db->order_by('D.jenis ASC');
    $i = 0;

    foreach ($this->column_search as $item) // loop column 
    {
      if ($_POST['search']['value']) // if datatable send POST for search
      {

        if ($i === 0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if (count($this->column_search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }

    if (isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id', $id);
    $query = $this->db->get();

    return $query->row();
  }

  public function get_by_id_2($id)
  {
    $this->db->select("A.id, A.kode_perangkat,A.nama_perangkat, A.dept_id, A.spesifikasi, A.status, B.nama, C.nama_dept, D.jenis");
    $this->db->from('tbl_perangkat_new A');
    $this->db->join('tbl_perusahaan B', 'B.id = A.company_id', 'left');
    $this->db->join('tbl_department C', 'C.id = A.dept_id', 'left');
    $this->db->join('tbl_jenis_perangkat D', 'D.id = A.id_jenis_perangkat', 'left');

    $this->db->where('A.id', $id);

    $query = $this->db->get();

    return $query->row();
  }
  public function get_by_id_perangkat($id)

  {

    $this->db->from($this->table);

    $this->db->where('kode_perangkat', $id);

    $query = $this->db->get();



    return $query->row();
  }

  public function get_by_kode_perangkat($kode_perangkat)
  {
    $this->db->from($this->table);
    $this->db->where('kode_perangkat', $kode_perangkat);
    $query = $this->db->get();

    return $query->row();
  }

  public function save($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function delete_by_id($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
  }

  public function get_all_data_perangkat($company_id)
  {
    $sql    = "SELECT a.*, b.nama_dept FROM tbl_perangkat_new a
              LEFT JOIN tbl_department b ON b.id = a.dept_id
              WHERE a.company_id = '$company_id' AND a.status = 'AKTIF' 
              ORDER BY a.id DESC";
    $query  = $this->db->query($sql);

    return $query->result();
  }

  public function get_alls()
  {
    $this->db->from($this->table);
    $this->db->where('status', 'AKTIF');
    $query = $this->db->get();

    return $query->result();
  }
}
