<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partner_model extends CI_Model
{

//   var $table = 'ms_partner';
//   var $column_order   = array(
//     'PartnerID', 'PartnerName', 'Type', 'Address', 'City', 'Country',
//     'Contact', 'Phone', 'Street', 'Block', 'Number', 'Neighbourhood',
//     'Hamlet', 'District', 'AdministrativeVillage', 'Regency', 'Province',
//     'Postcode', 'Fax', 'Email', 'Website', 'Telex', 'NPWP', 'PKPNO',
//     'PKPDATE', 'isImport', 'BankAccountName', 'BankAccountNo', 'BankName',
//     'BankAddress', 'SWIFT', 'Corresponding', 'TypePartner', 'Currency',
//     'CurrencyPO', 'PaymentType', 'CreditLimit', 'Term', 'ExpiryDay',
//     'TipePPN', 'Notes', 'Aktif', 'CreateDate', 'CreateBy', 'CompanyCode', null
//   );
//   var $column_search  = array(
//     'PartnerID', 'PartnerName', 'Type', 'Address', 'City', 'Country',
//     'Contact', 'Phone', 'Street', 'Block', 'Number', 'Neighbourhood',
//     'Hamlet', 'District', 'AdministrativeVillage', 'Regency', 'Province',
//     'Postcode', 'Fax', 'Email', 'Website', 'Telex', 'NPWP', 'PKPNO',
//     'PKPDATE', 'isImport', 'BankAccountName', 'BankAccountNo', 'BankName',
//     'BankAddress', 'SWIFT', 'Corresponding', 'TypePartner', 'Currency',
//     'CurrencyPO', 'PaymentType', 'CreditLimit', 'Term', 'ExpiryDay',
//     'TipePPN', 'Notes', 'Aktif', 'CreateDate', 'CreateBy', 'CompanyCode'
//   );
//   var $order = array('PartnerID' => 'desc');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

//   public function count_all()
//   {
//     $this->db->from($this->table);
//     return $this->db->count_all_results();
//   }

//   public function get_all()
//   {
//     $this->db->from($this->table);
//     $query = $this->db->get();
//     return $query->result();
//   }

  public function get_pelanggan_info($partner_id)
  {
    $hosting_mas  = $this->load->database('hosting_mas', TRUE);
    $sql    = "SELECT * FROM Ms_Partner WHERE PartnerID = '$partner_id'";
    $query  = $hosting_mas->query($sql);
    $result = $query->row();

    // Memeriksa dan mengganti nilai NULL dengan string kosong ('')
    if ($result) {
      foreach ($result as $key => $value) {
        if ($value === null) {
          $result->$key = ''; // Mengganti nilai NULL dengan string kosong
        }
      }
    }
    return $result;
  }

  public function get_pelanggan_info_revisi($partner_id, $revision)
  {
    $hosting_mas  = $this->load->database('hosting_mas', TRUE);
    $sql    = "SELECT * FROM ms_partner_revision WHERE PartnerID = '$partner_id' AND RevisionNumber = '$revision'";
    $query  = $hosting_mas->query($sql);
    $result = $query->row();

    // Memeriksa dan mengganti nilai NULL dengan string kosong ('')
    if ($result) {
      foreach ($result as $key => $value) {
        if ($value === null) {
          $result->$key = ''; // Mengganti nilai NULL dengan string kosong
        }
      }
    }
    return $result;
  }



  public function get_pelanggan_shipment($partner_id)
  {
    $hosting_mas  = $this->load->database('hosting_mas', TRUE);
    $sql    = "SELECT * FROM Ms_CustomerAlamatKirim WHERE CustomerID = '$partner_id'";
    $query  = $hosting_mas->query($sql);
    $result = $query->row();

    // Memeriksa dan mengganti nilai NULL dengan string kosong ('')
    if ($result) {
      foreach ($result as $key => $value) {
        if ($value === null) {
          $result->$key = ''; // Mengganti nilai NULL dengan string kosong
        }
      }
    }
    return $result;
  }

  public function get_pelanggan_shipment_revisi($partner_id, $revision)
  {
    $hosting_mas  = $this->load->database('hosting_mas', TRUE);
    $sql    = "SELECT * FROM ms_customeralamatkirim_revision WHERE CustomerID = '$partner_id' AND RevisionNumber='$revision'";
    $query  = $hosting_mas->query($sql);
    $result = $query->row();

    // Memeriksa dan mengganti nilai NULL dengan string kosong ('')
    if ($result) {
      foreach ($result as $key => $value) {
        if ($value === null) {
          $result->$key = ''; // Mengganti nilai NULL dengan string kosong
        }
      }
    }
    return $result;
  }

//   public function get_by_id($id)
//   {
//     $this->db->from($this->table);
//     $this->db->where('PartnerID', $id);
//     $query = $this->db->get();

//     return $query->row();
//   }

  public function get_pelanggan_shipment_old($partner_id)
  {
    $sql    = "SELECT * FROM ms_customeralamatkirim WHERE CustomerID = '$partner_id'";
    $query  = $this->db->query($sql);

    return $query->row();
  }

  public function get_pelanggan_info_old($partner_id)
  {
    $sql    = "SELECT * FROM ms_partner WHERE PartnerID = '$partner_id'";
    $query  = $this->db->query($sql);

    return $query->row();
  }
}
