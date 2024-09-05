<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Perangkat_model extends CI_Model
{



  var $table = 'tbl_perangkat';

  //var $table = 'tbl_perangkat_new';

  var $column_order   = array('A.id', 'A.id_perangkat', 'A.spesifikasi', 'A.status', 'B.nama', 'C.nama_dept', 'D.jenis', null);

  var $column_search  = array('A.id', 'A.id_perangkat', 'A.spesifikasi', 'A.status', 'B.nama', 'C.nama_dept', 'D.jenis');

  var $order = array('A.id' => 'desc');



  public function __construct()

  {

    parent::__construct();

    $this->load->database();
  }



  private function _get_datatables_query()

  {

    //$this->db->from($this->table);



    //$this->db->select("A.id, A.id_perangkat, A.DivisionID, A.spesifikasi, A.status, B.nama, C.nama_dept, D.jenis");

    // $this->db->select("A.id, A.id_perangkat, A.deskripsi, A.status, B.nama, C.nama_dept, D.jenis");

    // $this->db->from('tbl_perangkat_new A');

    // $this->db->join('tbl_perusahaan B', 'B.id = A.company_id', 'left');

    // $this->db->join('tbl_department C', 'C.id = A.dept_id', 'left');

    // $this->db->join('tbl_jenis_perangkat D', 'D.id = A.id_jenis_perangkat', 'left');



    $this->db->select("A.id, A.id_perangkat, A.user_id, A.spesifikasi, A.status, B.nama, C.nama_dept, D.jenis");

    //$this->db->from('tbl_perangkat_new A');

    $this->db->from('tbl_perangkat A');

    $this->db->join('tbl_perusahaan B', 'B.id = A.company_id', 'left');

    $this->db->join('tbl_department C', 'C.id = A.dept_id', 'left');

    $this->db->join('tbl_jenis_perangkat D', 'D.id = A.id_jenis_perangkat', 'left');



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

  public function get_by_id_perangkat($id)

  {

    $this->db->from($this->table);

    $this->db->where('id_perangkat', $id);

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

    $sql    = "SELECT a.*, b.nama_dept FROM tbl_perangkat a

               LEFT JOIN tbl_department b ON b.id = a.dept_id

               WHERE a.company_id = '$company_id' AND a.status = 'AKTIF' 

               ORDER BY a.id DESC";

    $query  = $this->db->query($sql);



    return $query->result();
  }



  public function auto_generate($company_id, $dept_id)

  {

    $tgl          = date("Ym"); //date(Ymd) : jika mau tahun 4 digit

    $company_code = "";

    $this->db->select('RIGHT(tbl_perangkat.id_perangkat, 3) as kode', FALSE);

    $this->db->order_by('id_perangkat', 'DESC');

    $this->db->limit(1);

    $query = $this->db->get('tbl_perangkat');

    if ($query->num_rows() <> 0) {

      //$data = $query->row();

      //$kode = intval($data->kode) + 1;

      $kode = $this->db->count_all('tbl_perangkat') + 1;
    } else {

      $kode = 1;
    }



    if ($company_id == 1) {

      $company_code = "MAS";
    } else {

      $company_code = "MAiN";
    }



    $kodemax  = date('Ym', strtotime($tgl)) . str_pad($kode, 3, 0, STR_PAD_LEFT);

    $kodejadi = $company_code . "-" . $dept_id . $kodemax;



    return $kodejadi;
  }



  public function GenerateID($company_id, $dept_name)
  {

    $tgl            = date("Ym");

    $company_code   = "";

    if ($company_id == 1) {

      $company_code = "MAS";
    } else {

      $company_code = "MAiN";
    }



    $query = $this->db->select('id_perangkat')

      ->from('tbl_perangkat')

      ->get();

    $row = $query->last_row();

    if ($row) {

      $idPostfix  = (int)substr($row->id_perangkat, 1) + 1;

      $nextId     = $company_code . '-' . $dept_name . '-' . $tgl . STR_PAD((string)$idPostfix, 5, "0", STR_PAD_LEFT);
    } else {

      $nextId     = $company_code . '-' . $dept_name . '-' . $tgl . '00001';
    } // For the first time



    return $nextId;
  }



  public function get_alls()

  {

    $this->db->from($this->table);

    $this->db->where('status', 'AKTIF');

    $query = $this->db->get();



    return $query->result();
  }
}
