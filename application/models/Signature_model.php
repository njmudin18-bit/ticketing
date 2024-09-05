<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signature_model extends CI_Model {

  var $table = 'tbl_tanda_tangan';
  var $column_order   = array('a.id', 'a.Nip', 'a.Title', 'a.Status', 'b.nama_dept', 'c.nama', 'd.nama_pegawai', null);
  var $column_search  = array('a.id', 'a.Nip', 'a.Title', 'a.Status', 'b.nama_dept', 'c.nama', 'd.nama_pegawai');
  var $order = array('a.id' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  private function _get_datatables_query()
  {
    $this->db->select('a.id, a.Nip, a.Title, a.Status, b.nama_dept, c.nama, d.nama_pegawai');
    $this->db->from('tbl_tanda_tangan a');
    $this->db->join('tbl_department b', 'b.id = a.DepartmentID', 'left');
    $this->db->join('tbl_perusahaan c', 'c.id = a.CompanyID', 'left');
    $this->db->join('tbl_user d', 'd.nip = a.Nip', 'left');

    $i = 0;
  
    foreach ($this->column_search as $item)
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {
        
        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }
    
    if(isset($_POST['order']))
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } 
    else if(isset($this->order))
    {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
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

  public function get_all()
	{
		$this->db->from($this->table);
    $this->db->where('Status', 'AKTIF');
    $query = $this->db->get();

		return $query->result();
	}

  public function get_all_by_company($company_id)
	{
		$sql = "SELECT a.id, a.CompanyID, a.Status, b.nama AS NamaPerusahaan, 
            a.DibuatOleh AS PreparedNIP, c.PreparedTitle, c.PreparedBy, c.PreparedDepartment,
            a.DiperiksaOleh AS CheckedNIP, d.CheckedTitle, d.CheckedBy, d.CheckedDepartment,
            a.DisetujuiOleh AS ApprovedNIP, e.ApprovedTitle, e.ApprovedBy, e.ApprovedDepartment
            FROM tbl_tanda_tangan_group a
            LEFT JOIN tbl_perusahaan b ON b.id = a.CompanyID
            LEFT JOIN (
              SELECT a.nip, a.dept_id, a.nama_pegawai AS PreparedBy, 
              b.Title AS PreparedTitle, c.nama_dept AS PreparedDepartment
              FROM tbl_user a
              LEFT JOIN tbl_tanda_tangan b ON b.Nip = a.nip
              LEFT JOIN tbl_department c ON c.id = a.dept_id
            ) c ON c.nip = a.DibuatOleh
            LEFT JOIN (
              SELECT a.nip, a.dept_id, a.nama_pegawai AS CheckedBy, 
              b.Title AS CheckedTitle, c.nama_dept AS CheckedDepartment
              FROM tbl_user a
              LEFT JOIN tbl_tanda_tangan b ON b.Nip = a.nip
              LEFT JOIN tbl_department c ON c.id = a.dept_id
            ) d ON d.nip = a.DiperiksaOleh
            LEFT JOIN (
              SELECT a.nip, a.dept_id, a.nama_pegawai AS ApprovedBy, 
              b.Title AS ApprovedTitle, c.nama_dept AS ApprovedDepartment
              FROM tbl_user a
              LEFT JOIN tbl_tanda_tangan b ON b.Nip = a.nip
              LEFT JOIN tbl_department c ON c.id = a.dept_id
            ) e ON e.nip = a.DisetujuiOleh
            WHERE a.CompanyID = '$company_id'";
    $que = $this->db->query($sql);
    $res = $que->result();

    return $res;
	}
}