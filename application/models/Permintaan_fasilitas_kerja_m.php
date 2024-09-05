<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_fasilitas_kerja_m extends CI_Model
{
  var $table = 'tbl_trans_permintaan';
  var $column_order = array(
    'A.id',
    'A.no_request',
    'A.jenis_request',
    'A.nama_request',
    'A.kebutuhan_request',
    'E.nama_dept',
    'A.status',
    'A.approve_spv_it',
    'B.nama_pegawai',
    'A.created_at'
  );
  var $column_search = array(
    'A.id',
    'A.no_request',
    'A.jenis_request',
    'A.nama_request',
    'A.kebutuhan_request',
    'E.nama_dept',
    'A.status',
    'A.approve_spv_it',
    'B.nama_pegawai',
    'A.created_at'
  );
  var $order = array('A.id' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }


  public function checkTable($id, $check, $word)
  {
    $this->db->select($check);
    $this->db->where('id', $id);
    $query = $this->db->get($this->table);

    if ($query->num_rows() > 0) {
      $row = $query->row();
      if ($row->$check != $word) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function generate_request_number()
  {
    $currentDate = date('Ymd');

    //cari no request terakhir di db
    $lastRequest = $this->db->select('no_request')
      ->from('tbl_trans_permintaan')
      ->order_by('no_request', 'DESC')
      ->limit(1)
      ->get()
      ->row();
    if ($lastRequest) {
      $lastTransactionDate = substr($lastRequest->no_request, 3, 8);

      if ($lastTransactionDate == $currentDate) {
        // Jika nomor transaksi sudah di-generate hari ini, tambahkan 1 ke nomor tersebut
        $lastNumber = (int) substr($lastRequest->no_request, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $requestNumber = 'PER' . $currentDate . $newNumber;
      } else {
        // Jika ini adalah nomor transaksi pertama hari ini, gunakan nomor '001'
        $requestNumber = 'PER' . $currentDate . '001';
      }
    } else {
      // Jika ini adalah nomor request pertama, gunakan nomor 001
      $requestNumber = 'PER' . $currentDate . '001';
    }
    return $requestNumber;
  }
  public function insert_data($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update_data($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function delete_data($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
  }
  function count_filtered_old()
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
  private function _get_datatables_query()
  {

    $this->db->select("A.id, A.no_request, A.jenis_request, A.nama_request, B.nama_pegawai, A.kebutuhan_request, A.status, A.approve_spv_it, E.nama_dept,  A.created_at, F.nama");
    $this->db->from('tbl_trans_permintaan A');
    $this->db->join('tbl_user B', 'B.id = A.id_user', 'left');
    $this->db->join('tbl_department E', 'E.id = B.dept_id', 'left');
    $this->db->join('tbl_perusahaan F', 'F.id = E.company_id', 'left');


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

  function get_data($deptname, $start_date, $end_date, $perusahaan)
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);

    // Filter berdasarkan dept
    if ($deptname != 'IT')
      $this->db->where('E.nama_dept', $deptname);

    // Filter berdasarkan tanggal
    $this->db->where("CAST(A.created_at AS DATE) BETWEEN '$start_date' AND '$end_date'");

    // Filter berdasarkan perusahaan
    if ($perusahaan != 'All') {
      $this->db->where('B.perusahaan', $perusahaan);
    }
    $query = $this->db->get();
    return $query->result();
  }


  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id', $id);
    $query = $this->db->get();

    return $query->row();
  }

  function count_filtered($deptname, $start_date, $end_date, $perusahaan)
  {
    $this->_get_datatables_query();
    // Filter berdasarkan dept
    if ($deptname != 'IT')
      $this->db->where('E.nama_dept', $deptname);

    // Filter berdasarkan tanggal
    if ($start_date != '' && $end_date != '') {
      $this->db->where("CAST(A.created_at AS DATE) BETWEEN '$start_date' AND '$end_date'");
    }

    // Filter berdasarkan perusahaan
    if ($perusahaan != 'All') {
      $this->db->where('B.perusahaan', $perusahaan);
    }
    $query = $this->db->get();
    return $query->num_rows();
  }
}