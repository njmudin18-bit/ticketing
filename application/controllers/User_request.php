<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_request extends CI_Controller
{
  private $deptname;
  private $username;
  private $user_level;

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
      $data['group_halaman']     = "Form Perbaikan";
      $data['nama_halaman']     = "Form Perbaikan";
      $data['norequest'] = $this->userrequest->generate_request_number();
      $data['perusahaan_all']   = $this->perusahaan->get_all();
      $data['perusahaan']       = $this->perusahaan->get_details();
      $data['no_document']     = ($data['perusahaan']->id == '2') ? "MAIN/FO/IT/01" : "MAS/FO/IT/01";

      // $data['jenis_perangkat']   = $this->jenisperangkat->get_all();

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "VIEW";
      $log_data   = "";

      log_helper($log_url, $log_type, $log_data);
      //END LOG

      $this->load->view('adminx/user_requests/user_request_view', $data, FALSE);
    } else {
      redirect('errorpage/error403');
    }
  }

  public function add_data()
  {
    $roles_name     = $this->getRoles($this->user_level);
    $NoRequest      = $this->input->post('norequest');
    $JenisRequest   = $this->input->post('jenisrequest');
    $User           = $this->username;
    if (strstr($roles_name, "SPV")) {
      $this->_validation_userrequest();
      $data = array(
        'no_request'        => $this->input->post('norequest'),
        'jenis_request'     => $this->input->post('jenisrequest'),
        'keterangan'        => $this->input->post('keterangan'),
        'id_user'           => $this->session->userdata('user_code'),
        'status_trans'      => 'Pending',
        'approve_spv_user'  => 'Approved',
        'comment'           => 'Menunggu Approve dari SPV	IT',
        'approve_spv_it'    => 'Pending',
        'created_at'        => date('Y-m-d H:i:s'),
        'createby'          => $this->username,

      );
      $insert = $this->userrequest->insert_data($data);
      echo json_encode(array("status" => "ok"));

      $this->send_to_whatsapp_group($NoRequest, $JenisRequest, $User);
    } else {
      $this->_validation_userrequest();
      $data = array(
        'no_request'        => $this->input->post('norequest'),
        'jenis_request'     => $this->input->post('jenisrequest'),
        'keterangan'        => $this->input->post('keterangan'),
        'id_user'           => $this->session->userdata('user_code'),
        'status_trans'      => 'Pending',
        //by pass approve
        'approve_spv_user'  => 'Approved',
        'comment'           => 'Menunggu Approve dari SPV	IT',
        /* validasi untuk approve user */
        // 'approve_spv_user'  => 'Pending',
        // 'comment'           => 'Menunggu Approve dari SPV	' . $this->deptname,
        'approve_spv_it'    => 'Pending',
        'created_at'        => date('Y-m-d H:i:s'),
        'createby'          => $this->username,

      );
      $insert = $this->userrequest->insert_data($data);
      echo json_encode(array("status" => "ok"));

      $this->send_to_whatsapp_group($NoRequest, $JenisRequest, $User);
    }
  }

  public function edit_data_pelaksana($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $resultCheckApproveUser = $this->checkApproval($id, 'approve_spv_user', 'Approved');
      if ($resultCheckApproveUser) {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Blm di Approved SPV!"
        ));
      } else {
        $data = $this->userrequest->get_by_id($id);
        echo json_encode($data);

        //ADDING TO LOG
        $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "EDIT";
        $log_data   = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        //END LOG
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function preview($id)
  {
    $data = $this->userrequest->get_preview($id);
    // var_dump($data);
    // exit;
    echo json_encode($data);
  }

  public function edit_data($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {

      $data = $this->userrequest->get_by_id($id);
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

  public function getRoles($user_level)
  {
    $data = $this->roles->get_by_id($user_level);
    return $data->roles_name;
  }

  public function getNamaPerangkat($id_perangkat = "null")
  {
    if ($id_perangkat == "null") {
      $kode_perangkat = $this->input->post('kode_perangkat');
      $data = $this->perangkat->get_by_kode_perangkat($kode_perangkat);
      echo json_encode($data);
    } else {
      $data = $this->perangkat->get_by_kode_perangkat($id_perangkat);
      return $data->id;
    }
  }

  public function friwayat_add_data()
  {

    $id_perangkat = $this->input->post('kode_perangkat_2');
    $id = $this->getNamaPerangkat("$id_perangkat");

    $data = array(
      'no_history'    => $this->input->post('no_history'),
      'id_perangkat'  => $id,
      'keterangan'    => $this->input->post('comment_2'),
      'created_at'    => date('Y-m-d H:i:s'),
      'createby'      => $this->username,
    );

    // Panggil metode insert_data untuk menyisipkan data
    $insert = $this->riwayatHistory->insert_data($data);

    if ($insert) {
      // Jika penyisipan berhasil, lakukan pembaruan data lain
      $update_data = array(
        'add_riwayat' => 1,
        'updated_at'  => date('Y-m-d H:i:s'),
        'updateby'    => $this->username,
      );
      $this->userrequest->update_data(array('id' => $this->input->post('kode_2')), $update_data);

      // Keluar dari fungsi jika berhasil
      echo json_encode(array(
        "status"  => "ok",
        "message" => "Berhasil Add Riwayat!"
      ));
      return;
    } else {
      // Keluar dari fungsi dengan pesan kesalahan jika penyisipan gagal
      echo json_encode(array(
        "status"  => "error",
        "message" => "Gagal menambahkan Riwayat."
      ));
      return;
    }
  }

  public function edit_data_friwayat($id)
  {

    $resultCheckApproveUser = $this->checkApproval($id, 'status_trans', 'Selesai');
    if ($resultCheckApproveUser) {
      echo json_encode(array(
        "status" => "gagal",
        "message" => "Status Belum Selesai!"
      ));
    } else {
      $checkRiwayat = $this->checkApproval($id, 'add_riwayat', 1);
      if ($checkRiwayat != 0) {
        $data = $this->userrequest->get_by_id($id);
        echo json_encode($data);
      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Sudah di input ke riwayat!"
        ));
      }
    }
  }

  public function checkRiwayat($id)
  {
    $checkRiwayat = $this->checkApproval($id, 'add_riwayat', 1);
    if ($checkRiwayat > 0) {
      echo json_encode(array(
        "status" => "gagal",
        "message" => "Sudah di input ke riwayat!"
      ));
    } else {
      echo json_encode(array(
        "status" => "ok",
        "message" => "Belum di input ke riwayat!"
      ));
    }
  }

  public function update_data()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $this->_validation_userrequest();

      $data = array(
        'no_request'        => $this->input->post('norequest'),
        'jenis_request'     => $this->input->post('jenisrequest'),
        'keterangan'        => $this->input->post('keterangan'),
        'updated_at'      => date('Y-m-d H:i:s'),
        'updateby'        => $this->username
      );

      $this->userrequest->update_data(array('id' => $this->input->post('kode')), $data);
      echo json_encode(array("status" => "ok"));

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "UPDATE";
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
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $data_delete     = $this->userrequest->get_by_id($id); //DATA DELETE
      $data           = $this->userrequest->delete_data($id);
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
    $deptname = $this->session->userdata('user_dept_name');
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');
    $perusahaan = $this->input->post('pilih_pt');

    $list = $this->userrequest->get_data($deptname, $start_date, $end_date, $perusahaan);
    $data = array();
    $no   = $_POST['start'];
    $noUrut = 0;
    foreach ($list as $userrequest) {
      if ($userrequest->status_trans == 'Pending') {
        $status = '<span class="btn btn-danger btn-sm text-white" style="font-size: 14px;">' . $userrequest->status_trans . '</span>';
      } elseif ($userrequest->status_trans == 'Selesai') {
        $status = '<span class="btn btn-success btn-sm text-white" style="font-size: 14px;">' . $userrequest->status_trans . '</span>';
      } else {
        $status = $userrequest->status_trans;
      }

      $no++;
      $noUrut++;
      $row = array();
      $row[] = $no;
      //add html for action 
      if ($deptname == "IT") {
        $row[] =   '<a href="javascript:void(0)" onclick="edit(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-success btn-sm text-white" title="Klik untuk edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-danger btn-sm text-white" title="Klik untuk delete">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="approve_spv_it(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-primary btn-sm text-white" title="Klik untuk Approve">
                    <i class="fa-solid fa-user-check"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="pelaksana(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-primary btn-sm text-white" title="Klik untuk mengerjakan">
                    <i class="fa-solid fa-briefcase"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="preview(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-info btn-sm text-white" title="Klik untuk preview">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  ';
      } else {
        $row[] = '<a href="javascript:void(0)" onclick="edit(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-success btn-sm text-white" title="Klik untuk Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="approve_spv_user(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-info btn-sm text-white" title="Klik untuk Approve">
                    <i class="fa-solid fa-user-check"></i>
                  </a>
                  <a href="javascript:void(0)" onclick="preview(' . "'" . $userrequest->id . "'" . ')"
                    class="btn btn-info btn-sm text-white" title="Klik untuk preview">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  ';
      }
      $row[] = $userrequest->no_request;
      $row[] = $userrequest->nama_pegawai;
      $row[] = $userrequest->nama_dept;
      $row[] = $userrequest->approve_spv_user;
      $row[] = $userrequest->approve_spv_it;
      $row[] = $status;
      $row[] = $userrequest->jenis_request;
      $row[] = $userrequest->keterangan;
      $row[] = $userrequest->comment;
      $row[] = $userrequest->nama_pegawai;
      $row[] = $userrequest->created_at;
      if ($deptname == "IT") {
        $row[] = '<a href="javascript:void(0)" onclick="riwayat(' . "'" . $userrequest->id . "'" . ')"
      class="btn btn-success btn-sm text-white">
      Add Riwayat Perangkat
    </a>';
      } else {
        $row[] = '<a href="javascript:void(0)" onclick="closeRequest(' . "'" . $userrequest->id . "'" . ')"
      class="btn btn-success btn-sm text-white">
      Selesai
    </a>';
      }
      $data[] = $row;
    }

    $output = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->userrequest->count_all(),
      "recordsFiltered" => $this->userrequest->count_filtered($deptname, $start_date, $end_date, $perusahaan),
      "data"            => $data
    );
    //output to json format
    echo json_encode($output);
  }

  public function closeRequest($id)
  {
    $resultCheckApproveUser = $this->checkApproval($id, 'approve_spv_user', 'Approved');
    $resultCheckApproveIT = $this->checkApproval($id, 'approve_spv_it', 'Approved');

    if ($resultCheckApproveIT == '' && $resultCheckApproveUser == '') {
      $resultCheck = $this->checkApproval($id, 'status_trans', 'Selesai');
      if ($resultCheck) {
        $data = array(
          'status_trans'    => 'Selesai',
          'updated_at'      => date('Y-m-d H:i:s'),
          'updateby'        => $this->username
        );
        $this->userrequest->update_data(array('id' => $id), $data);
        echo json_encode(array(
          "status" => "ok",
          "message" => "User request Berhasil di close!"
        ));
      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "User Request sudah Clear!"
        ));
      }
    } else {
      echo json_encode(array(
        "status" => "gagal",
        "message" => "Approved SPV belum lengkap!"
      ));
    }
  }


  public function checkApproval($id, $check, $word)
  {
    $result = $this->userrequest->checkApprovalStatus($id, $check, $word);
    return $result;
  }

  public function update_approveit($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $resultCheckApproveUser = $this->checkApproval($id, 'approve_spv_user', 'Approved');
      if ($resultCheckApproveUser) {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Blm di Approved SPV User!"
        ));
      } else {
        $resultCheck = $this->checkApproval($id, 'approve_spv_it', 'Approved');
        if ($resultCheck) {
          $data = array(
            'approve_spv_it'  => 'Approved',
            'comment' => ' ',
            'updated_at'      => date('Y-m-d H:i:s'),
            'updateby'        => $this->username
          );
          $this->userrequest->update_data(array('id' => $id), $data);
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
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function update_approveuser($id)
  {
    // CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {


      $resultCheck = $this->checkApproval($id, 'approve_spv_user', 'Approved');

      if ($resultCheck) {
        $data = array(
          'approve_spv_user' => 'Approved',
          'comment' => 'Menunggu Approve dari SPV IT',
          'updated_at' => date('Y-m-d H:i:s'),
          'updateby' => $this->username
        );
        $this->userrequest->update_data(array('id' => $id), $data);
        echo json_encode(array(
          "status" => "ok",
          "message" => "Berhasil di Approve!"
        ));

        // ADDING TO LOG
        $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type    = "EDIT";
        $log_data    = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        // END LOG
      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Sudah di Approved!"
        ));
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  public function update_data_it()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $id = $this->input->post('kode_1');
      $resultCheck = $this->checkApproval($id, 'status_trans', 'Selesai');
      if ($resultCheck) {
        $this->_validation_userrequestIT();

        $data = array(
          'status_trans'    => $this->input->post('status_1'),
          'comment'         => $this->input->post('comment_1'),
          'updated_at'      => date('Y-m-d H:i:s'),
          'updateby'        => $this->username
        );

        $this->userrequest->update_data(array('id' => $this->input->post('kode_1')), $data);
        echo json_encode(array("status" => "ok"));

        //ADDING TO LOG
        $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "UPDATE";
        $log_data   = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        //END LOG
      } else {
        echo json_encode(array("status" => "gagal"));
      }
    } else {
      echo json_encode(array("status" => "forbidden"));
    }
  }

  //pake hanya sekali, atau WA ANDA AKAN DI BANNED
  /*public function create_id_whatsapp_group()
  {
    $Token = "sumnUuip43K6jaNiUypr";
    
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/fetch-group',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        "Authorization: $Token"
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/get-whatsapp-group',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        "Authorization: $Token"
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;
  }*/

  public function send_to_whatsapp_group($NoRequest, $JenisRequest, $User)
  {
    //$NoRequest      = '01234567890'; 
    //$JenisRequest   = 'software';
    //$User           = 'NJ';

    $Token  = "sumnUuip43K6jaNiUypr";
    $Target = "120363044169011040@g.us";

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'target' => $Target,
        'message' => 'Info: Request baru No. #' . $NoRequest . ' dengan jenis *' . $JenisRequest . '* dari _' . $User . '_'
      ),
      CURLOPT_HTTPHEADER => array(
        "Authorization: $Token"
      ),
    ));

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
      $error_msg = curl_error($curl);
    }

    curl_close($curl);
    if (isset($error_msg)) {
      echo $error_msg;
    }

    //echo $response;
  }


  public function getNoRequest()
  {
    $data = $this->userrequest->generate_request_number();
    echo json_encode($data);
  }

  private function _validation_userrequest()
  {
    $data                 = array();
    $data['error_string'] = array();
    $data['inputerror']   = array();
    $data['status']       = TRUE;
    // Validasi tambahan untuk kolom no_request
    if ($this->input->post('norequest') == '') {
      $data['inputerror'][]     = 'no_request';
      $data['error_string'][]   = 'No Request is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom jenis_request
    if ($this->input->post('jenisrequest') == '') {
      $data['inputerror'][]     = 'jenis_request';
      $data['error_string'][]   = 'Jenis Request is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom keterangan
    if ($this->input->post('keterangan') == '') {
      $data['inputerror'][]     = 'keterangan';
      $data['error_string'][]   = 'Keterangan is required';
      $data['status'] = FALSE;
    }

    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    }
  }

  private function _validation_userrequestIT()
  {
    $data                 = array();
    $data['error_string'] = array();
    $data['inputerror']   = array();
    $data['status']       = TRUE;
    // Validasi tambahan untuk kolom no_request
    if ($this->input->post('status_1') == '') {
      $data['inputerror'][]     = 'status';
      $data['error_string'][]   = 'status is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom jenis_request
    if ($this->input->post('comment_1') == '') {
      $data['inputerror'][]     = 'comment';
      $data['error_string'][]   = 'comment is required';
      $data['status'] = FALSE;
    }


    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    }
  }
}