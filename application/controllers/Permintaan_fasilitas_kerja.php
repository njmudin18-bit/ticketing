<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_fasilitas_kerja extends CI_Controller
{
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
    $this->load->model('Users_model', 'user');
    $this->load->model('perusahaan_model', 'perusahaan');
    $this->load->model('jenisperangkat_model', 'jenisperangkat');
    $this->load->model('perangkat_new_model', 'perangkat');
    $this->load->model('riwayatperangkat_model', 'riwayatHistory');
    $this->load->model('userrequest_model', 'userrequest');
    $this->load->model('departments_model', 'departments');
    $this->load->model('roles_model', 'roles');
    $this->load->model('permintaan_fasilitas_kerja_m', 'permintaan');
    $this->deptname = $this->session->userdata('user_dept_name');
    $this->username = $this->session->userdata('user_realName');
    $this->user_level = $this->session->userdata('user_level');
  }

  public function index()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $data['group_halaman']     = "Permintaan Fasilitas Kerja";
      $data['nama_halaman']     = "Permintaan Fasilitas Kerja";
      $data['norequest'] = $this->userrequest->generate_request_number();
      $data['perusahaan_all']   = $this->perusahaan->get_all();
      $data['perusahaan']       = $this->perusahaan->get_details();
      $data['no_document']     = ($data['perusahaan']->id == '2') ? "MAIN/FO/IT/03" : "MAS/FO/IT/06";

      // $data['jenis_perangkat']   = $this->jenisperangkat->get_all();

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "VIEW";
      $log_data   = "";

      log_helper($log_url, $log_type, $log_data);
      //END LOG

      $this->load->view('adminx/user_requests/permintaan_fasilitas_kerja', $data, FALSE);
    } else {
      redirect('errorpage/error403');
    }
  }


  public function update_data_status()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $resultCheck = $this->checkTable($this->input->post('kode'), 'status', 'Selesai');
      if ($resultCheck) {
        $data = array(
          'status'            => $this->input->post('status'),
          'updated_at'        => date('Y-m-d H:i:s'),
          'updateby'          => $this->username
        );
        $this->permintaan->update_data(array('id' => $this->input->post('kode')), $data);
        echo json_encode(array("status" => "ok"));
        //ADDING TO LOG
        $data       = array("id" => $this->input->post("kode")) + $data;
        $log_url    = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "UPDATE";
        $log_data   = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        //END LOG
      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Status Selesai, tidak dapat diubah!"
        ));
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function update_data()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $resultCheck = $this->checkTable($this->input->post('kode'), 'status', 'Selesai');
      if ($resultCheck) {
        $this->_validation_permintaan();

        $data = array(
          'jenis_request'     => $this->input->post('jenis_request'),
          'nama_request'      => $this->input->post('nama_request'),
          'kebutuhan_request' => $this->input->post('kebutuhan_request'),
          'updated_at'        => date('Y-m-d H:i:s'),
          'updateby'          => $this->username
        );

        $this->permintaan->update_data(array('id' => $this->input->post('kode')), $data);
        echo json_encode(array("status" => "ok"));

        //ADDING TO LOG
        $data       = array("id" => $this->input->post("kode")) + $data;
        $log_url    = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "UPDATE";
        $log_data   = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        //END LOG

      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Status Selesai, tidak dapat diedit!"
        ));
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function update_approveit($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $resultCheck = $this->checkTable($id, 'approve_spv_it', 'Approved');
      if ($resultCheck) {
        $data = array(
          'approve_spv_it'  => 'Approved',
          'updated_at'      => date('Y-m-d H:i:s'),
          'updateby'        => $this->username
        );
        $this->permintaan->update_data(array('id' => $id), $data);
        echo json_encode(array(
          "status" => "ok",
          "message" => "Berhasil di Approve!"
        ));
        //ADDING TO LOG
        $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "EDIT";
        $log_data   = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        //END LOG
      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Sudah di Approved SPV!"
        ));
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function add_data()
  {
    $this->_validation_permintaan();

    $data = array(
      'no_request'        => $this->input->post('no_request'),
      'jenis_request'     => $this->input->post('jenis_request'),
      'nama_request'      => $this->input->post('nama_request'),
      'kebutuhan_request' => $this->input->post('kebutuhan_request'),
      'id_user'           => $this->session->userdata('user_code'),
      'status'            => 'Pending',
      'approve_spv_it'    => 'Pending',
      'created_at'        => date('Y-m-d H:i:s'),
      'createby'          => $this->username,

    );


    $insert = $this->permintaan->insert_data($data);
    echo json_encode(array("status" => "ok"));
  }

  public function edit_data($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {

      $data = $this->permintaan->get_by_id($id);
      echo json_encode($data);

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "EDIT";
      $log_data   = json_encode($data);

      log_helper($log_url, $log_type, $log_data);
      //END LOG

    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function delete_data($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level           = $this->session->userdata('user_level');
    $check_permission     =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {
      $data_delete        = $this->permintaan->get_by_id($id); //DATA DELETE
      $data               = $this->permintaan->delete_data($id);
      echo json_encode(array("status" => "ok"));

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "DELETE";
      $log_data   = json_encode($data_delete);

      log_helper($log_url, $log_type, $log_data);
      //END LOG
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function show()
  {
    $deptname   = $this->session->userdata('user_dept_name');
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');
    $perusahaan = $this->input->post('pilih_pt');

    $list = $this->permintaan->get_data($deptname, $start_date, $end_date, $perusahaan);

    // var_dump($start_date . ' ' . $end_date . ' ' . $perusahaan);
    // exit;
    $data = array();
    $no   = $_POST['start'];
    $noUrut = 0;

    foreach ($list as $permintaan) {

      if ($permintaan->status == 'Pending') {
        $status = '<a href="javascript:void(0)" onclick="gantiStatus(' . "'" . $permintaan->id . "'" . ')" title="Klik untuk ganti status"
        ><span class="btn btn-danger btn-sm text-white" style="font-size: 14px;">
        ' . $permintaan->status . '</span>
        </a>';
      } elseif ($permintaan->status == 'Selesai') {
        $status = '<a href="javascript:void(0)" onclick="gantiStatus(' . "'" . $permintaan->id . "'" . ')" title="Klik untuk ganti status"
        ><span class="btn btn-success btn-sm text-white" style="font-size: 14px;">
        ' . $permintaan->status . '</span>
        </a>';
      } else {
        $status = '<a href="javascript:void(0)" onclick="gantiStatus(' . "'" . $permintaan->id . "'" . ')" title="Klik untuk ganti status"
        ><span class="btn btn-secondary btn-sm text-white" style="font-size: 14px;">
        ' . $permintaan->status . '</span>
        </a>';
      }

      if ($permintaan->approve_spv_it == 'Pending') {
        $approve_spv_it = '<span class="btn btn-danger btn-sm text-white" style="font-size: 14px;">' . $permintaan->approve_spv_it . '</span>';
      } elseif ($permintaan->approve_spv_it == 'Approved') {
        $approve_spv_it = '<span class="btn btn-success btn-sm text-white" style="font-size: 14px;">' . $permintaan->approve_spv_it . '</span>';
      } else {
        $approve_spv_it = $permintaan->approve_spv_it;
      }



      $no++;
      $noUrut++;
      $row = array();
      $row[] = $no;
      $row[] = '<a href="javascript:void(0)" onclick="edit(' . "'" . $permintaan->id . "'" . ')"
                class="btn btn-success btn-sm text-white" title="Klik untuk Edit">
                <i class="fa fa-edit"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $permintaan->id . "'" . ')"
                class="btn btn-danger btn-sm text-white" title="Klik untuk Delete">
                <i class="fa-solid fa-trash"></i>
                </a>
                <a href="javascript:void(0)" onclick="approve_spv_it(' . "'" . $permintaan->id . "'" . ')"
                class="btn btn-primary btn-sm text-white" title="Klik untuk Approve">
                <i class="fa-solid fa-user-check"></i>
                </a>
                ';
      $row[] = $permintaan->no_request;
      $row[] = $permintaan->nama_pegawai;
      $row[] = $permintaan->nama_dept;
      $row[] = $approve_spv_it;
      $row[] = $status;
      $row[] = $permintaan->jenis_request;
      $row[] = strtoupper($permintaan->nama_request);
      $row[] = strtolower($permintaan->kebutuhan_request);
      $row[] = $permintaan->created_at;

      $data[] = $row;
    }

    $output = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->permintaan->count_all(),
      "recordsFiltered" => $this->permintaan->count_filtered($deptname, $start_date, $end_date, $perusahaan),
      "data"            => $data
    );
    //output to json format
    echo json_encode($output);
  }

  public function checkTable($id, $check, $word)
  {
    $result = $this->permintaan->checkTable($id, $check, $word);
    return $result;
  }

  public function getNoRequest()
  {
    $data = $this->permintaan->generate_request_number();
    echo json_encode($data);
  }

  private function _validation_permintaan()
  {
    $data                 = array();
    $data['error_string'] = array();
    $data['inputerror']   = array();
    $data['status']       = TRUE;
    // Validasi tambahan untuk kolom no_request
    if ($this->input->post('no_request') == '') {
      $data['inputerror'][]     = 'no_request';
      $data['error_string'][]   = 'No Request is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom jenis_request
    if ($this->input->post('jenis_request') == '') {
      $data['inputerror'][]     = 'jenis_request';
      $data['error_string'][]   = 'Jenis Request is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom jenis_request
    if ($this->input->post('nama_request') == '') {
      $data['inputerror'][]     = 'nama_request';
      $data['error_string'][]   = 'Nama Request is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom keterangan
    if ($this->input->post('kebutuhan_request') == '') {
      $data['inputerror'][]     = 'kebutuhan_request';
      $data['error_string'][]   = 'Kebutuhan Request is required';
      $data['status'] = FALSE;
    }

    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    }
  }
}