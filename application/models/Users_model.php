<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Users_model extends CI_Model
{



  var $table = 'tbl_user';

  var $column_order = array(
    'A.id', 'D.nama_dept', 'nip', 'nama_pegawai', 'email_pegawai', 'B.roles_name', 'C.nama',

    'username', 'user_level', 'A.aktivasi', 'last_login', null
  );

  var $column_search = array(
    'A.id', 'D.nama_dept', 'nip', 'nama_pegawai', 'email_pegawai', 'B.roles_name', 'C.nama',

    'username', 'user_level', 'A.aktivasi', 'last_login'
  );

  var $order = array('A.id' => 'desc');



  public function __construct()

  {

    parent::__construct();

    $this->load->database();
  }



  private function _get_datatables_query()

  {
          $this->db->select("A.id, D.nama_dept, nip, nama_pegawai, email_pegawai, B.roles_name, C.nama,username, user_level, A.aktivasi, last_login");


    $this->db->from('tbl_user A');

    $this->db->join('roles B', 'B.idroles = A.user_level', 'left');

    $this->db->join('tbl_perusahaan C', 'C.id = A.perusahaan', 'left');
    $this->db->join('tbl_department D', 'D.id = A.dept_id',  'left');



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

    $this->db->where('nip', $id);

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

    $this->db->where('nip', $id);

    $this->db->delete($this->table);
  }



  public function get_alls()

  {

    $this->db->from($this->table);

    $query = $this->db->get();



    return $query->result();
  }
}
