<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
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
    $this->load->model('departments_model', 'departments');
    $this->load->model('roles_model', 'roles');
    $this->load->model('peminjaman_model', 'peminjaman');
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
      $data['group_halaman']     = "Peminjaman";
      $data['nama_halaman']     = "Peminjaman";
      $data['perusahaan_all']   = $this->perusahaan->get_all();
      $data['perusahaan']       = $this->perusahaan->get_details();
      $data['no_document']     = ($data['perusahaan']->id == '2') ? "MAIN/FO/IT/07" : "MAS/FO/IT/07";


      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "VIEW";
      $log_data   = "";

      log_helper($log_url, $log_type, $log_data);
      //END LOG

      $this->load->view('adminx/peminjaman/peminjaman_view', $data, FALSE);
    } else {
      redirect('errorpage/error403');
    }
  }

  /*

=== OK GASS ==

*/

  public function update_data_status()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $resultCheck = $this->checkTable($this->input->post('kode'), 'status', 'Sudah-kembali');
      if ($resultCheck) {
        $data = array(
          'status'            => $this->input->post('status'),
          'updatedate'        => date('Y-m-d H:i:s'),
          'updateby'          => $this->username
        );
        $this->peminjaman->update_data(array('id' => $this->input->post('kode')), $data);
        echo json_encode(array("status" => "ok"));
        //ADDING TO LOG
        $data       = array("id" => $this->input->post("kode")) + $data;
        $log_url    = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "UPDATE";
        $log_data   = json_encode($data);

        log_helper($log_url, $log_type, $log_data);
        // END LOG
      } else {
        echo json_encode(array(
          "status" => "gagal",
          "message" => "Status Sudah-kembali, tidak dapat diubah!"
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
      $resultCheck = $this->checkTable($this->input->post('kode'), 'status', 'Sudah-kembali');
      if ($resultCheck) {
        $this->_validation_peminjaman();

        $data = array(
          'nama_barang'       => $this->input->post('nama_barang'),
          'tgl_pinjam'        => $this->input->post('tglAwal'),
          'tgl_kembali'       => $this->input->post('tglAkhir'),
          'keterangan_pinjaman' => $this->input->post('keterangan'),
          'updatedate'        => date('Y-m-d H:i:s'),
          'updateby'          => $this->username
        );

        $this->peminjaman->update_data(array('id' => $this->input->post('kode')), $data);
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
          "message" => "Status Sudah-kembali, tidak dapat diedit!"
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
        $pilihStatus = $this->input->post('approve_it');
        $data = array(
          'approve_spv_it'  =>  $pilihStatus,
          'updatedate'      => date('Y-m-d H:i:s'),
          'updateby'        => $this->username
        );
        $this->peminjaman->update_data(array('id' => $this->input->post('kode')), $data);

        if ($pilihStatus == "Approved") {
          echo json_encode(array(
            "status" => "ok",
            "message" => "Berhasil di Approve!"
          ));
        } else {
          echo json_encode(array(
            "status" => "ok",
            "message" => "Berhasil di Reject!"
          ));
        }

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
    $this->_validation_peminjaman();

    $data = array(
      'no_request'        => $this->input->post('no_request'),
      'nama_barang'       => $this->input->post('nama_barang'),
      'tgl_pinjam'        => $this->input->post('tglAwal'),
      'tgl_kembali'       => $this->input->post('tglAkhir'),
      'keterangan_pinjaman' => $this->input->post('keterangan'),
      'id_user'           => $this->session->userdata('user_code'),
      'status'            => 'Belum-kembali',
      'approve_spv_it'    => 'Menunggu Persetujuan IT',
      'createdate'        => date('Y-m-d H:i:s'),
      'createby'          => $this->username,

    );

    $insert = $this->peminjaman->insert_data($data);
    echo json_encode(array("status" => "ok"));
  }

  public function edit_data($id)
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {

      $data = $this->peminjaman->get_by_id($id);
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
      $data_delete        = $this->peminjaman->get_by_id($id); //DATA DELETE
      $data               = $this->peminjaman->delete_data($id);
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

    $list = $this->peminjaman->get_data($deptname, $start_date, $end_date, $perusahaan);

    $data = array();
    $no   = $_POST['start'];
    $noUrut = 0;

    foreach ($list as $peminjaman) {

      if ($peminjaman->status == 'Belum-kembali') {
        $status = '<a href="javascript:void(0)" onclick="gantiStatus(' . "'" . $peminjaman->id . "'" . ')" title="Klik untuk ganti status"
        ><span class="btn btn-danger btn-sm text-white" style="font-size: 14px;">
        ' . $peminjaman->status . '</span>
        </a>';
      } elseif ($peminjaman->status == 'Sudah-kembali') {
        $status = '<a href="javascript:void(0)" onclick="gantiStatus(' . "'" . $peminjaman->id . "'" . ')" title="Klik untuk ganti status"
        ><span class="btn btn-success btn-sm text-white" style="font-size: 14px;">
        ' . $peminjaman->status . '</span>
        </a>';
      } else {
        $status = '<a href="javascript:void(0)" onclick="gantiStatus(' . "'" . $peminjaman->id . "'" . ')" title="Klik untuk ganti status"
        ><span class="btn btn-secondary btn-sm text-white" style="font-size: 14px;">
        ' . $peminjaman->status . '</span>
        </a>';
      }

      if ($peminjaman->approve_spv_it == 'Rejected') {
        $approve_spv_it = '<span class="btn btn-danger btn-sm text-white" style="font-size: 14px;">' . $peminjaman->approve_spv_it . '</span>';
      } elseif ($peminjaman->approve_spv_it == 'Approved') {
        $approve_spv_it = '<span class="btn btn-success btn-sm text-white" style="font-size: 14px;">' . $peminjaman->approve_spv_it . '</span>';
      } else {
        $approve_spv_it = $peminjaman->approve_spv_it;
      }



      $no++;
      $noUrut++;
      $row = array();
      $row[] = $no;
      $row[] = '<a href="javascript:void(0)" onclick="edit(' . "'" . $peminjaman->id . "'" . ')"
                class="btn btn-success btn-sm text-white" title="Klik untuk Edit">
                <i class="fa fa-edit"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $peminjaman->id . "'" . ')"
                class="btn btn-danger btn-sm text-white" title="Klik untuk Delete">
                <i class="fa-solid fa-trash"></i>
                </a>
                <a href="javascript:void(0)" onclick="approve_spv_it(' . "'" . $peminjaman->id . "'" . ')"
                class="btn btn-primary btn-sm text-white" title="Klik untuk Approve">
                <i class="fa-solid fa-user-check"></i>
                </a>
                ';
      $row[] = $peminjaman->no_request;
      $row[] = $peminjaman->nama_pegawai;
      $row[] = $peminjaman->nama_dept;
      $row[] = $approve_spv_it;
      $row[] = $status;
      $row[] = $peminjaman->nama_barang;
      $row[] = $peminjaman->keterangan_pinjaman;
      $row[] = $peminjaman->tgl_pinjam;
      $row[] = $peminjaman->tgl_kembali;
      $row[] = $peminjaman->createdate;

      $data[] = $row;
    }

    $output = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->peminjaman->count_all(),
      "recordsFiltered" => $this->peminjaman->count_filtered($deptname, $start_date, $end_date, $perusahaan),
      "data"            => $data
    );
    //output to json format
    echo json_encode($output);
  }

  public function checkTable($id, $check, $word)
  {
    $result = $this->peminjaman->checkTable($id, $check, $word);
    return $result;
  }

  public function getNoRequest()
  {
    $data = $this->peminjaman->generate_request_number();
    echo json_encode($data);
  }

  private function _validation_peminjaman()
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

    // Validasi tambahan untuk kolom nama_barang
    if ($this->input->post('nama_barang') == '') {
      $data['inputerror'][]     = 'nama_barang';
      $data['error_string'][]   = 'Nama Barang is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom tglAwal
    if ($this->input->post('tglAwal') == '') {
      $data['inputerror'][]     = 'tglAwal';
      $data['error_string'][]   = 'Tanggal peminjaman is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom tglAkhir
    if ($this->input->post('tglAkhir') == '') {
      $data['inputerror'][]     = 'tglAkhir';
      $data['error_string'][]   = 'Tanggal pengembalian is required';
      $data['status'] = FALSE;
    }

    // Validasi tambahan untuk kolom keterangan
    if ($this->input->post('keterangan') == '') {
      $data['inputerror'][]     = 'keterangan';
      $data['error_string'][]   = 'keterangan is required';
      $data['status'] = FALSE;
    }

    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    }
  }
}