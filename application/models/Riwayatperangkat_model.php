<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayatperangkat_model extends CI_Model
{
  var $table = 'tbl_history_perangkats';
  var $column_order = array(
    'id',
    'id_perangkat',
    'nama_perangkat',
    'keterangan',
    'createby',
    'updateby',
    'created_at',
    'updated_at'
  );
  var $column_search = array(
    'id',
    'id_perangkat',
    'nama_perangkat',
    'keterangan',
    'createby',
    'updateby',
    'created_at',
    'updated_at'
  );
  var $order = array('A.id' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function generate_request_number()
  {
    $currentDate = date('Ymd');

    //cari no request terakhir di db
    $lastRequest = $this->db->select('no_history')
      ->from('tbl_history_perangkats')
      ->order_by('no_history', 'DESC')
      ->limit(1)
      ->get()
      ->row();
    if ($lastRequest) {
      // Jika ada nomor request sebelumnya, tambahkan 1 ke nomor tersebut
      $lastNumber = substr($lastRequest->no_history, -3);
      $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
      $requestNumber = 'HIS' . $currentDate . $newNumber;
    } else {
      // Jika ini adalah nomor request pertama, gunakan nomor 001
      $requestNumber = 'HIS' . $currentDate . '001';
    }
    return $requestNumber;
  }

  private function _get_datatables_query()
  {
    $this->db->select("A.id,
    A.no_history,
    A.id_perangkat,
    B.kode_perangkat as nama_perangkat,
    A.keterangan,
    A.createby,
    A.updateby,
    A.created_at,
    A.updated_at");
    $this->db->from('tbl_history_perangkats A');
    $this->db->join('tbl_perangkat_new B', 'B.id = A.id_perangkat', 'left');

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

  //Berdasarkan id riwayat
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id', $id);
    $query = $this->db->get();

    return $query->row();
  }

  //Berdasarkan id riwayat query custom
  public function get_by_id_2($id)
  {
    $this->db->select("A.id,
    A.no_history,
    A.id_perangkat,
    B.kode_perangkat as nama_perangkat,
    A.keterangan,
    A.createby,
    A.updateby,
    A.created_at,
    A.updated_at");
    $this->db->from('tbl_history_perangkats A');
    $this->db->join('tbl_perangkat_new B', 'B.id = A.id_perangkat', 'left');
    $this->db->where('A.id', $id);

    $query = $this->db->get();

    return $query->row();
  }

  //Berdasarkan id perangkat
  public function get_by_id_3($id_perangkat)
  {
    $this->db->select("A.id,
    A.no_history,
    A.id_perangkat,
    B.id_perangkat as nama_perangkat,
    A.keterangan,
    A.createby,
    A.updateby,
    A.created_at,
    A.updated_at");
    $this->db->from('tbl_history_perangkats A');
    $this->db->join('tbl_perangkat B', 'B.id = A.id_perangkat', 'left');
    $this->db->where('A.id_perangkat', $id_perangkat);

    $query = $this->db->get();

    return $query->result();
  }

  function get_data()
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
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
}
