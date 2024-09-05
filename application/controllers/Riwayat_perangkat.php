<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_perangkat extends CI_Controller
{
  private $deptname;
  private $username;
  public function __construct()
  {
    parent::__construct();

    $this->load->model('auth_model', 'auth');
    if ($this->auth->isNotLogin());

    //START ADD THIS FOR USER ROLE MANAGMENT
    $this->contoller_name = $this->router->class;
    $this->function_name   = $this->router->method;
    $this->load->model('Rolespermissions_model');
    //END

    $this->load->model('Dashboard_model');
    $this->load->model('perusahaan_model', 'perusahaan');
    $this->load->model('jenisperangkat_model', 'jenisperangkat');
    $this->load->model('perangkat_new_model', 'perangkat');
    $this->load->model('riwayatperangkat_model', 'riwayatHistory');
    $this->load->model('departments_model', 'departments');
    $this->deptname = $this->session->userdata('user_dept_name');
    $this->username = $this->session->userdata('user_realName');
  }

  public function index()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $data['group_halaman']     = "Riwayat Perangkat";
      $data['nama_halaman']     = "Riwayat Perangkat";
      $data['perusahaan_all']   = $this->perusahaan->get_all();
      $data['perusahaan']       = $this->perusahaan->get_details();
      $data['no_document']     = ($data['perusahaan']->id == '2') ? "MAIN/FO/IT/04" : "MAS/FO/IT/04";
      // $data['jenis_perangkat']   = $this->jenisperangkat->get_all();

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "VIEW";
      $log_data   = "";

      log_helper($log_url, $log_type, $log_data);
      //END LOG

      $this->load->view('adminx/user_requests/riwayat_perangkat_view', $data, FALSE);
    } else {
      redirect('errorpage/error403');
    }
  }

  public function getNamaPerangkat($id_perangkat = "null")
  {
    if ($id_perangkat == "null") {
      $kode_perangkat = $this->input->post('kode_perangkat');
      $data = $this->perangkat->get_by_id($kode_perangkat);
      echo json_encode($data);
    } else {
      $data = $this->perangkat->get_by_id_perangkat($id_perangkat);
      return $data->id;
    }
  }


  public function getNoHistory()
  {
    $data = $this->riwayatHistory->generate_request_number();
    echo json_encode($data);
  }

  public function show()
  {
    $list = $this->riwayatHistory->get_data();
    $data = array();
    $no   = $_POST['start'];
    $noUrut = 0;
    foreach ($list as $riwayatHistory) {
      $no++;
      $noUrut++;
      $row = array();
      $row[] = $no;
      //add html for action
      $row[] =   '<a href="javascript:void(0)" onclick="edit(' . "'" . $riwayatHistory->id . "'" . ')"
                    class="btn btn-success btn-sm text-white" title="Klik untuk Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $riwayatHistory->id . "'" . ')"
                    class="btn btn-danger btn-sm text-white" title="Klik untuk Delete">
                    <i class="fa-solid fa-trash"></i>
                  </a>';

      $row[] = $riwayatHistory->no_history;
      $row[] = $riwayatHistory->nama_perangkat;
      $row[] = $riwayatHistory->keterangan;
      $row[] = $riwayatHistory->createby;
      $row[] = $riwayatHistory->created_at;
      $data[] = $row;
    }

    $output = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->riwayatHistory->count_all(),
      "recordsFiltered" => $this->riwayatHistory->count_filtered(),
      "data"            => $data
    );
    //output to json format
    echo json_encode($output);
  }

  public function add_data()
  {
    // //CHECK FOR ACCESS FOR EACH FUNCTION
    // $user_level       = $this->session->userdata('user_level');
    // $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    // if ($check_permission->num_rows() == 1) {
    // $this->_validation_riwayat();
    $kode_perangkat = $this->input->post('kode_perangkat_2');
    $id = $this->getNamaPerangkat($kode_perangkat);

    $data = array(
      'no_history'        => $this->input->post('no_history'),
      'id_perangkat'     =>  $id,
      'keterangan'        => $this->input->post('comment_2'),
      'created_at'        => date('Y-m-d H:i:s'),
      'createby'          => $this->username,

    );
    $insert = $this->riwayatHistory->insert_data($data);
    echo json_encode(array("status" => "ok"));

    //   //ADDING TO LOG
    //   $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
    //   $log_type   = "ADD";
    //   $log_data   = json_encode($data);

    //   log_helper($log_url, $log_type, $log_data);
    //   //END LOG
    // } else {
    //   echo json_encode(array("status" => "forbidden"));
    // }
  }

  public function edit_data($id)
  {
    // //CHECK FOR ACCESS FOR EACH FUNCTION
    // $user_level       = $this->session->userdata('user_level');
    // $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    // if ($check_permission->num_rows() == 1) {
    $data = $this->riwayatHistory->get_by_id_2($id);
    echo json_encode($data);

    //   //ADDING TO LOG
    //   $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
    //   $log_type   = "EDIT";
    //   $log_data   = json_encode($data);

    //   log_helper($log_url, $log_type, $log_data);
    //   //END LOG
    // } else {
    //   echo json_encode(array("status" => "forbidden"));
    // }
  }

  public function update_data()
  {
    // //CHECK FOR ACCESS FOR EACH FUNCTION
    // $user_level       = $this->session->userdata('user_level');
    // $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    // if ($check_permission->num_rows() == 1) {
    $this->_validation_riwayat();
    $id_perangkat = $this->input->post('kode_perangkat_2');
    $id = $this->getNamaPerangkat("$id_perangkat");
    $data = array(
      'no_history'        => $this->input->post('no_history'),
      'id_perangkat'     =>  $id,
      'keterangan'        => $this->input->post('comment_2'),
      'updated_at'      => date('Y-m-d H:i:s'),
      'updateby'        => $this->username
    );

    $this->riwayatHistory->update_data(array('id' => $this->input->post('kode')), $data);
    echo json_encode(array("status" => "ok"));

    //   //ADDING TO LOG
    //   $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
    //   $log_type   = "UPDATE";
    //   $log_data   = json_encode($data);

    //   log_helper($log_url, $log_type, $log_data);
    //   //END LOG
    // } else {
    //   echo json_encode(array("status" => "forbidden"));
    // }
  }

  public function delete_data($id)
  {
    // //CHECK FOR ACCESS FOR EACH FUNCTION
    // $user_level       = $this->session->userdata('user_level');
    // $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    // if ($check_permission->num_rows() == 1) {
    $data_delete     = $this->riwayatHistory->get_by_id($id); //DATA DELETE
    $data           = $this->riwayatHistory->delete_data($id);
    echo json_encode(array("status" => "ok"));

    //   //ADDING TO LOG
    //   $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
    //   $log_type   = "DELETE";
    //   $log_data   = json_encode($data_delete);

    //   log_helper($log_url, $log_type, $log_data);
    //   //END LOG
    // } else {
    //   echo json_encode(array("status" => "forbidden"));
    // }
  }

  private function _validation_riwayat()
  {
    $data                 = array();
    $data['error_string'] = array();
    $data['inputerror']   = array();
    $data['status']       = TRUE;
    // Validasi tambahan untuk kolom no_history
    if ($this->input->post('no_history') == '') {
      $data['inputerror'][]     = 'no_history';
      $data['error_string'][]   = 'No History is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom kode_perangkat_2
    if ($this->input->post('kode_perangkat_2') == '') {
      $data['inputerror'][]     = 'kode_perangkat_2';
      $data['error_string'][]   = 'Kode Perangkat is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom Keterangan
    if ($this->input->post('comment_2') == '') {
      $data['inputerror'][]     = 'comment_2';
      $data['error_string'][]   = 'Keterangan is required';
      $data['status'] = FALSE;
    }

    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    }
  }
}
