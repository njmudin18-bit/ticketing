<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Perawatan extends CI_Controller
{



  /**

   * Index Page for this controller.

   *

   * Maps to the following URL

   * 		http://example.com/index.php/welcome

   *	- or -

   * 		http://example.com/index.php/welcome/index

   *	- or -

   * Since this controller is set as the default controller in

   * config/routes.php, it's displayed at http://example.com/

   *

   * So any other public methods not prefixed with an underscore will

   * map to /index.php/welcome/<method_name>

   * @see https://codeigniter.com/user_guide/general/urls.html

   */



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

    $this->load->model('perawatan_model', 'perawatan');

    $this->load->model('perusahaan_model', 'perusahaan');

    $this->load->model('roles_model', 'roles');

    $this->load->model('documents_model', 'documents');

    $this->load->model('perangkat_model', 'perangkat');
  }



  public function generateDates(string $startDate, int $count): array
  {

    $date = new DateTime($startDate);

    $dates = [$date->format('d-m-Y')];

    for ($i = 0; $i < $count - 1; $i++) {

      $dateTime = $date->add(new DateInterval('P3M'));

      $dates[] = $dateTime->format('d-m-Y');
    }

    return $dates;
  }



  public function index()

  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {

      $data['group_halaman']     = "Perawatan";

      $data['nama_halaman']     = "Jadwal Perawatan";

      $data['perusahaan']       = $this->perusahaan->get_details();

      $data['perusahaan_all']   = $this->perusahaan->get_all();



      //ADDING TO LOG

      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;

      $log_type   = "VIEW";

      $log_data   = "";



      log_helper($log_url, $log_type, $log_data);

      //END LOG



      $this->load->view('adminx/perawatan/perawatan', $data, FALSE);
    } else {

      redirect('errorpage/error403');
    }
  }



  public function perawatan_list()

  {

    $list = $this->perawatan->get_datatables();

    $data = array();

    $no   = $_POST['start'];

    $noUrut = 0;

    foreach ($list as $perawatan) {

      $no++;

      $noUrut++;

      $row = array();

      $row[] = $no;

      //add html for action

      $row[] = '<a href="javascript:void(0)" onclick="edit(' . "'" . $perawatan->id . "'" . ')"

									class="btn btn-success btn-sm text-white">

									<i class="fa fa-edit"></i>

								</a>

                <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $perawatan->id . "'" . ')"

                	class="btn btn-danger btn-sm text-white">

                	<i class="fa fa-times"></i>

                </a>

                <a href="javascript:void(0)" onclick="lihat_jadwal(' . "'" . $perawatan->id . "'" . ')"

                	class="btn btn-info btn-sm text-white" title="Klik untuk lihat jadwal">

                	<i class="fa fa-eye"></i>

                </a>

                <a href="' . base_url() . 'perawatan/view/' . $perawatan->id . '" target="_blank"

                	class="btn btn-warning btn-sm text-white" title="Klik untuk lihat jadwal di calendar">

                	<i class="fa fa-calendar"></i>

                </a>';

      $row[] = $perawatan->aktivasi == 'AKTIF' ? '<button class="btn btn-success btn-sm">' . strtoupper($perawatan->aktivasi) . '</button>' : '<button class="btn btn-secondary btn-sm">' . strtoupper($perawatan->aktivasi) . '</button>';

      $row[] = $perawatan->document_id;

      $row[] = $perawatan->judul;

      $row[] = $this->get_company_name($perawatan->company_id); //$perawatan->nama; //$perawatan->company_id;

      $row[] = $perawatan->created_date;



      $data[] = $row;
    }



    $output = array(

      "draw"             => $_POST['draw'],

      "recordsTotal"     => $this->perawatan->count_all(),

      "recordsFiltered" => $this->perawatan->count_filtered(),

      "data"             => $data,

    );

    //output to json format

    echo json_encode($output);
  }



  public function perawatan_add()

  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {

      $this->_validation_perawatan();



      $company_id   = $this->input->post('perusahaan');

      $judul        = $this->input->post('judul');

      $no_doc       = $this->input->post('no_doc');

      $aktivasi     = $this->input->post('aktivasi');

      $generate     = $this->input->post('generate');

      $jlh_bulan    = 4 * floatval($generate);

      $result       = $this->generateDates(date('Y-m-d'), $jlh_bulan);

      $data_detail  = array();



      //DATA HEADER

      $data = array(

        'company_id'         => $company_id,

        'document_id'       => $no_doc,

        'judul'             => $judul,

        'aktivasi'           => $aktivasi,

        'generate_tahun'     => $generate,

        'created_date'      => date('Y-m-d H:i:s'),

        'created_by'        => $this->session->userdata('user_code')

      );



      //INSERT TO HEADER

      $insert     = $this->perawatan->save($data);

      $insert_id  = $this->db->insert_id();

      if ($insert) {

        //DATA DETAIL

        foreach ($result as $key => $value) {

          $data_detail[] = array(

            'id_header'         => $insert_id,

            'tgl_perencanaan'   => date("Y-m-d", strtotime($value)),

            'status'             => "Plan"

          );
        }



        //INSERT TO DETAIL

        $insert_detail = $this->db->insert_batch('tbl_jadwal_perawatan_detail', $data_detail);

        if ($insert_detail) {

          echo json_encode(

            array(

              "statuc_code" => 200,

              "status"      => "ok",

              "message"     => "Sukses input ke data header and detail"

            )

          );
        } else {

          echo json_encode(

            array(

              "statuc_code" => 500,

              "status"      => "error",

              "message"     => "Gagal input ke data detail"

            )

          );
        }
      } else {

        echo json_encode(

          array(

            "statuc_code" => 500,

            "status"      => "error",

            "message"     => "Gagal input ke data header"

          )

        );
      }



      //ADDING TO LOG

      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;

      $log_type   = "ADD";

      $log_data   = json_encode($data);



      log_helper($log_url, $log_type, $log_data);
    } else {

      echo json_encode(array("status" => "forbidden"));
    }
  }



  public function perawatan_edit($id)

  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {

      $data           = $this->perawatan->get_by_id($id);

      echo json_encode(

        array(

          "status_code" => 200,

          "status"      => "success",

          "message"     => "Sukses menampilkan data",

          "data"        => $data

        )

      );

      //echo json_encode($data);

    } else {

      echo json_encode(array("status" => "forbidden"));
    }
  }



  public function perawatan_update()

  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {

      $this->_validation_perawatan();



      $id           = $this->input->post('kode');

      $company_id   = $this->input->post('perusahaan');

      $judul        = $this->input->post('judul');

      $no_doc       = $this->input->post('no_doc');

      $aktivasi     = $this->input->post('aktivasi');

      $generate     = $this->input->post('generate');

      $jlh_bulan    = 4 * floatval($generate);

      $result       = $this->generateDates(date('Y-m-d'), $jlh_bulan);

      $data_detail  = array();



      //SET DATA HEADER

      $data = array(

        'company_id'         => $company_id,

        'document_id'       => $no_doc,

        'judul'             => $judul,

        'aktivasi'           => $aktivasi,

        'generate_tahun'     => $generate,

        'updated_date'      => date('Y-m-d H:i:s'),

        'updated_by'        => $this->session->userdata('user_code')

      );

      //UPDATE HEADER

      $update = $this->perawatan->update(array('id' => $id), $data);

      if ($update) {

        //DELETE DATA DETAIL FIRST

        $data_detail    = $this->perawatan->delete_detail_by_id($id); //DETELE DATA DETAILS

        //DATA DETAIL

        foreach ($result as $key => $value) {

          $data_detail[] = array(

            'id_header'         => $id,

            'tgl_perencanaan'   => date("Y-m-d", strtotime($value)),

            'status'             => "Plan"

          );
        }



        //INSERT TO DETAIL

        $insert_detail = $this->db->insert_batch('tbl_jadwal_perawatan_detail', $data_detail);

        if ($insert_detail) {

          echo json_encode(

            array(

              "statuc_code" => 200,

              "status"      => "ok",

              "message"     => "Sukses input ke data header and detail"

            )

          );
        } else {

          echo json_encode(

            array(

              "statuc_code" => 500,

              "status"      => "error",

              "message"     => "Gagal input ke data detail"

            )

          );
        }
      } else {

        echo json_encode(array("status" => "error when update data header"));
      }



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



  public function perawatan_deleted($id)

  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {

      $data_delete    = $this->perawatan->get_by_id($id);

      $data           = $this->perawatan->delete_by_id($id); //DELETE DATA HEADER

      $data_detail    = $this->perawatan->delete_detail_by_id($id); //DETELE DATA DETAILS



      echo json_encode(array("status" => "ok"));



      //ADDING TO LOG

      $log_url        = base_url() . $this->contoller_name . "/" . $this->function_name;

      $log_type       = "DELETE";

      $log_data       = json_encode($data_delete);



      log_helper($log_url, $log_type, $log_data);

      //END LOG

    } else {

      echo json_encode(array("status" => "forbidden"));
    }
  }



  public function perawatan_transaksi()

  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {



      $hader_id                 = $this->uri->segment(3);

      $company_id               = $this->uri->segment(4);

      $tgl_perencanaan          = $this->uri->segment(5);

      $data['group_halaman']     = "Perawatan";

      $data['nama_halaman']     = "Transaksi Perawatan";

      $data['perusahaan']       = $this->perusahaan->get_details();

      $data['detail']           = $this->perawatan->get_by_id_with_company($hader_id, $tgl_perencanaan);

      $data['perangkat_all']    = $this->perangkat->get_all_data_perangkat($company_id);



      $this->load->view('adminx/perawatan/transaksi', $data, FALSE);



      //ADDING TO LOG

      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;

      $log_type   = "VIEW";

      $log_data   = "";



      log_helper($log_url, $log_type, $log_data);

      //END LOG

    } else {

      redirect('errorpage/error403');
    }
  }



  public function generate_jadwal()
  {

    $detail_id    = $this->input->post('detail_id');

    $plan_date    = $this->input->post('plan_date');

    $company_id   = $this->input->post('company_id');



    $sql  = $this->db->query("SELECT a.*, b.nama_dept FROM tbl_perangkat_new a

                              LEFT JOIN tbl_department b ON b.id = a.dept_id

                              LEFT JOIN tbl_jenis_perangkat c ON c.id = a.id_jenis_perangkat

                              WHERE a.company_id = '$company_id' AND a.status = 'AKTIF'

                              AND c.jenis IN ('PC', 'Laptop', 'Tablet')

                              ORDER BY a.id DESC");

    $res  = $sql->result();

    $data = array();

    //echo count($res); exit;

    foreach ($res as $key => $value) {

      $data[] = array(

        'id_detail'           => $detail_id,

        'id_perangkat'        => $value->id,

        'status_pengerjaan'   => 'PROSES',

        'created_date'        => date('Y-m-d H:i:s')

      );
    }



    $save = $this->db->insert_batch('tbl_transaksi_perawatan', $data);

    if ($save) {

      $data = array(

        'jumlah_perangkat'  => count($res),

        'status'            => 'Progress'

      );

      $this->db->where('id_detail', $detail_id);

      $this->db->update('tbl_jadwal_perawatan_detail', $data);



      echo json_encode(

        array(

          'status_code' => 200,

          'status'      => 'success',

          'message'     => 'Sukses membuat jadwal planning'

        )

      );
    } else {

      echo json_encode(

        array(

          'status_code' => 500,

          'status'      => 'error',

          'message'     => 'Gagal membuat jadwal planning'

        )

      );
    }
  }

  public function get_company_name($Id)
  {
    $Result = $this->db->get_where('tbl_perusahaan', array('id' => $Id))->row();
    
    return $Result->nama;
  }

  public function get_nodoc_by_perusahaan()
  {

    $id   = $this->input->post('id');

    $data = $this->documents->get_nodoc_by_perusahaan($id);



    echo json_encode($data);
  }



  private function _validation_perawatan()
  {

    $data                 = array();

    $data['error_string'] = array();

    $data['inputerror']   = array();

    $data['status']       = TRUE;



    if ($this->input->post('judul') == '') {

      $data['inputerror'][]   = 'judul';

      $data['error_string'][] = 'Judul is required';

      $data['status'] = FALSE;
    }



    if ($this->input->post('aktivasi') == '') {

      $data['inputerror'][]   = 'aktivasi';

      $data['error_string'][] = 'Aktivasi is required';

      $data['status'] = FALSE;
    }



    if ($this->input->post('perusahaan') == '') {

      $data['inputerror'][]   = 'perusahaan';

      $data['error_string'][] = 'Perusahaan is required';

      $data['status'] = FALSE;
    }



    if ($this->input->post('generate') == '') {

      $data['inputerror'][]   = 'generate';

      $data['error_string'][] = 'Pilihan tahun is required';

      $data['status'] = FALSE;
    }



    if ($data['status'] === FALSE) {

      echo json_encode($data);

      exit();
    }
  }



  public function view($id)
  {

    $data['group_halaman']     = "Perawatan";

    $data['nama_halaman']     = "View Perawatan";

    $data['id_perawatan']     = $id;

    $data['perusahaan']       = $this->perusahaan->get_details();

    $data['detail']           = $this->perawatan->get_by_id($id);



    //ADDING TO LOG

    $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;

    $log_type   = "VIEW";

    $log_data   = "";



    log_helper($log_url, $log_type, $log_data);

    //END LOG



    $this->load->view('adminx/perawatan/view', $data, FALSE);
  }



  public function view_list($id)
  {

    $data = $this->perawatan->get_data_by_id($id);



    echo json_encode($data);
  }



  public function lihat_jadwal_detail()
  {

    $id     = $this->input->post('id_jadwal');

    $data   = $this->perawatan->get_data_detail_by_id($id);

    //print_r($data); exit;

    $header = "";

    $table  = "";

    $no     = 1;

    foreach ($data as $key => $value) {

      //GET JUMLAH PERANGKAT YANG TELAH DIKEJAKAN

      $JLH_SELESAI  = 0;

      $nama_pegawai = "";

      $sql2   = "SELECT 

                    a.dikerjakan_oleh,

                    COUNT(*) AS JLH_SELESAI,

                    b.nama_pegawai

                FROM

                    tbl_transaksi_perawatan a

                LEFT JOIN tbl_user b ON b.id = a.dikerjakan_oleh

                WHERE a.id_detail = '$value->id_detail' AND a.status_pengerjaan = 'SELESAI'

                GROUP BY a.status_pengerjaan";

      $q2     = $this->db->query($sql2);

      $cek    = $q2->num_rows();

      if ($cek > 0) {

        $res  = $q2->row();

        $JLH_SELESAI  = $res->JLH_SELESAI;

        $nama_pegawai = $res->nama_pegawai;
      } else {

        $JLH_SELESAI  = 0;

        $nama_pegawai = "";
      }



      $new_tab          = base_url() . "perawatan/perawatan_transaksi/" . $value->id_header . "/" . $value->id_perusahaan . "/" . $value->tgl_perencanaan . "/" . $value->id_detail;

      $isi_laporan      = base_url() . "perawatan/laporan_perawatan/" . $value->id_detail . "/" . $value->tgl_perencanaan . "/" . $value->id_perusahaan . "/" . $value->id_header;

      $tgl_perencanaan  = $value->tgl_perencanaan == null ? '-' : $value->tgl_perencanaan;

      $isi              = "'" . $value->id_detail . "', '" . $value->tgl_perencanaan . "', '" . $value->id_perusahaan . "'";

      $btn_generate     = '';

      $content_finish   = '';

      if ($value->status == 'Plan') {

        $btn_generate   = '<button type="button" onclick="generate_jadwal(' . $isi . ')" class="btn btn-sm btn-warning text-white" title="Klik untuk generate dahulu">

                            <i class="fa fa-recycle"></i>

                          </button>';
      } elseif ($value->status == 'Finish') {

        $btn_generate   = '<button type="button" onclick="open_modal_transaksi(' . $isi . ')" class="btn btn-sm btn-success text-white" title="Klik untuk masuk ke transaksi">

                            <i class="fa fa-flag-checkered"></i>

                          </button>

                          <a href="' . $isi_laporan . '" target="_blank" class="btn btn-danger btn-sm" title="Cetak laporan">

                            <i class="fa fa-print"></i>

                          </a>';
      } else {

        $btn_generate   = '<button type="button" onclick="open_modal_transaksi(' . $isi . ')" class="btn btn-sm btn-info text-white" title="Klik untuk masuk ke transaksi">

                            <i class="fa fa-sliders"></i>

                          </button>';
      }



      $table .= '<tr>

                  <td class="text-center">' . $btn_generate . '</td>

                  <td class="text-center">' . $no++ . '</td>

                  <td class="text-center">' . $tgl_perencanaan . '</td>

                  <td class="text-center">selesai ' . $JLH_SELESAI . ' dari ' . $value->jumlah_perangkat . '</td>

                  <td>' . strtolower($nama_pegawai) . '</td>

                  <td class="text-center">' . $value->status . '</td>

                </tr>'; //'.$dikerjakan_oleh.'

    }



    echo json_encode(

      array(

        "status_code" => 200,

        "status"      => "success",

        "message"     => "Sukses menampilkan data",

        "data"        => $data,

        "table"       => $table

      )

    );
  }



  public function show_data_perangkat_by_company()
  {

    $detail_id  = $this->input->post('detail_id');

    $plan_date  = $this->input->post('plan_date');

    $company_id = $this->input->post('company_id');

    //GET HEADER

    $header = $this->db->query("SELECT a.*, b.*, c.nama

                                FROM tbl_jadwal_perawatan_detail a

                                LEFT JOIN tbl_jadwal_perawatan b ON b.id = a.id_header

                                LEFT JOIN tbl_perusahaan c ON c.id = b.company_id

                                WHERE a.id_detail = '$detail_id'");

    $result = $header->row();

    //GET DATA PERANGKAT

    $sql = $this->db->query("SELECT a.id, a.status, a.spesifikasi,

                             b.nama_dept, c.jenis, d.nama, f.nama_pegawai,

                             e.dikerjakan_oleh, e.status_pengerjaan, e.id as ID_TRS,

                             e.id_detail AS ID_JADWAL_DETAIL, a.id_current_user

                             FROM tbl_perangkat_new a

                             LEFT JOIN tbl_department b ON b.id = a.dept_id

                             LEFT JOIN tbl_jenis_perangkat c ON c.id = a.id_jenis_perangkat

                             LEFT JOIN tbl_perusahaan d ON d.id = a.company_id

                             LEFT JOIN tbl_transaksi_perawatan e ON e.id_perangkat = a.id
                            
                              LEFT JOIN tbl_user f ON f.id = a.id_current_user

                             WHERE a.company_id = '$company_id' AND a.status = 'AKTIF' 

                             AND e.id_detail = '$detail_id' AND c.jenis IN ('Laptop','Pc', 'Tablet')

                             ORDER BY a.id DESC");

    $res      = $sql->result();

    $no       = 1;

    $data     = array();

    $checkbox = "";

    foreach ($res as $key => $value) {

      if ($value->status_pengerjaan == 'PROSES') {

        $checkbox = '<input type="checkbox" name="id_perangkat" id="id_perangkat" class="form-check-input" value="' . $value->id . "-" . $value->ID_TRS . '">';
      } else {

        $isi      = "'" . $value->id . "', '" . $value->ID_TRS . "', '" . $value->ID_JADWAL_DETAIL . "'";

        $checkbox = '<input type="checkbox" name="id_perangkat" id="id_perangkat" class="form-check-input" value="' . $value->id . "-" . $value->ID_TRS . '" onclick="proses_unchecked(' . $isi . ')" checked >';
      }



      $row   = array();

      $row[] = $no++;

      $row[] = $checkbox;

      $row[] = $value->jenis;

      $row[] = mb_strimwidth($value->spesifikasi, 0, 150, ' ...');

      $row[] = $value->nama_pegawai . "<br>" . $value->nama_dept;



      $data[] = $row;
    }



    echo json_encode(

      array(

        'status_code' => 200,

        'status'      => 'success',

        'message'     => 'Sukses menampilkan data',

        'data'        => $res,

        'table'       => $data,

        'header'      => $result

      )

    );
  }



  public function perawatan_transaksi_save()
  {

    $id_details     = $this->input->post('id_details');

    $jlh_perangkat  = $this->input->post('jlh_perangkat');

    $array_items    = $this->input->post('items');

    $array_id_trs   = $this->input->post('id_trs');

    $data_update    = array();

    foreach ($array_items as $key => $value) {

      $split_val    = explode('-', $value);

      $id_perangkat = $split_val[0];

      $id_trs       = $split_val[1];

      $data_update[] = array(

        'id'                => $id_trs,

        'id_detail'         => $id_details,

        'id_perangkat'      => $id_perangkat,

        'tgl_pengerjaan'    => date('Y-m-d'),

        'dikerjakan_oleh'   => $this->session->userdata('user_code'),

        'status_pengerjaan' => 'SELESAI',

        'updated_date'      => date('Y-m-d H:i:s')

      );
    };



    $update = $this->db->update_batch('tbl_transaksi_perawatan', $data_update, 'id');

    if ($update) {

      //GET JUMLAH PERANGKAT YANG SELESAI

      $q_cek      = $this->db->query("SELECT COUNT(*) AS JLH_SELESAI 

                                      FROM tbl_transaksi_perawatan 

                                      WHERE id_detail = '$id_details' 

                                      AND status_pengerjaan = 'SELESAI' 

                                      GROUP BY status_pengerjaan");

      $cek_data     = $q_cek->row();

      $jlh_selesai  = $cek_data->JLH_SELESAI;

      if ($jlh_selesai == $jlh_perangkat) {

        $update = "UPDATE tbl_jadwal_perawatan_detail SET status = 'Finish' WHERE id_detail = '$id_details'";

        $query  = $this->db->query($update);



        echo json_encode(

          array(

            "status_code" => 200,

            "status"      => "success",

            "message"     => "Data sukses di update"

          )

        );
      } else {

        $update = "UPDATE tbl_jadwal_perawatan_detail SET status = 'Progress' WHERE id_detail = '$id_details'";

        $query  = $this->db->query($update);



        echo json_encode(

          array(

            "status_code" => 200,

            "status"      => "success",

            "message"     => "Data sukses di update"

          )

        );
      }







      // $sql_update = "UPDATE tbl_jadwal_perawatan_detail 

      //                SET tgl_pengerjaan = date('Y-m-d'), 

      //                dikerjakan_oleh = $this->session->userdata('user_code'), 

      //                status = 'Progress' 

      //                WHERE id_detail = '$id_details'";

      // $q_update   = $this->db->query($sql_update);



      // echo json_encode(

      //   array(

      //     "status_code" => 200,

      //     "status"      => "success",

      //     "message"     => "Data sukses di update"

      //   )

      // );

    } else {

      echo json_encode(

        array(

          "status_code" => 500,

          "status"      => "error",

          "message"     => "Data gagal di update"

        )

      );
    }
  }



  public function proses_unchecked()
  {

    $perangkat_id     = $this->input->post('perangkat_id');

    $perawatan_trs_id = $this->input->post('perawatan_trs_id');

    $jadwal_detail_id = $this->input->post('jadwal_detail_id');



    $data_update[] = array(

      'id'                => $perawatan_trs_id,

      'tgl_pengerjaan'    => date('Y-m-d'),

      'dikerjakan_oleh'   => $this->session->userdata('user_code'),

      'status_pengerjaan' => 'PROSES',

      'updated_date'      => date('Y-m-d H:i:s')

    );



    $update = $this->db->update_batch('tbl_transaksi_perawatan', $data_update, 'id');

    if ($update) {



      $sql = "UPDATE tbl_jadwal_perawatan_detail SET status = 'Progress' WHERE id_detail = '$jadwal_detail_id'";

      $q   = $this->db->query($sql);



      echo json_encode(

        array(

          "status_code" => 200,

          "status"      => "success",

          "message"     => "Data sukses di update"

        )

      );
    } else {

      echo json_encode(

        array(

          "status_code" => 500,

          "status"      => "error",

          "message"     => "Data gagal di update"

        )

      );
    }
  }



  public function show_data_perangkat_choosen()
  {

    $detail_id  = $this->input->post('detail_id');

    $plan_date  = $this->input->post('plan_date');

    $company_id = $this->input->post('company_id');

    //GET DATA PERANGKAT

    $sql = $this->db->query("SELECT a.id, a.status, a.spesifikasi,

                             b.nama_dept, c.jenis, d.nama, 

                             e.dikerjakan_oleh, e.status_pengerjaan, e.id as ID_TRS,

                             e.id_detail AS ID_JADWAL_DETAIL, e.tgl_pengerjaan, f.nama_pegawai

                             FROM tbl_perangkat_new a

                             LEFT JOIN tbl_department b ON b.id = a.dept_id

                             LEFT JOIN tbl_jenis_perangkat c ON c.id = a.id_jenis_perangkat

                             LEFT JOIN tbl_perusahaan d ON d.id = a.company_id

                             LEFT JOIN tbl_transaksi_perawatan e ON e.id_perangkat = a.id

                             LEFT JOIN tbl_user f ON f.id = e.dikerjakan_oleh

                             WHERE a.company_id = '$company_id' AND a.status = 'AKTIF' 

                             AND e.id_detail = '$detail_id'

                             ORDER BY a.id DESC");

    $res      = $sql->result();

    $no       = 1;

    $data     = array();

    $checkbox = "";

    foreach ($res as $key => $value) {

      $row   = array();



      $row[] = $no++;

      $row[] = strtolower($value->status_pengerjaan);

      $row[] = $value->jenis;

      //$row[] = mb_strimwidth($value->spesifikasi, 0, 150, ' ...');

      $row[] = $value->spesifikasi;

      $row[] = $value->nama_dept;

      $row[] = $value->tgl_pengerjaan;

      $row[] = strtolower($value->nama_pegawai);



      $data[] = $row;
    }



    echo json_encode(

      array(

        'status_code' => 200,

        'status'      => 'success',

        'message'     => 'Sukses menampilkan data',

        'data'        => $data

      )

    );
  }



  public function laporan_perawatan()
  {

    $id_detail                = $this->uri->segment(3);

    $tgl_perencanaan          = $this->uri->segment(4);

    $id_perusahaan            = $this->uri->segment(5);

    $id_header                = $this->uri->segment(6);



    $data['group_halaman']     = "Perawatan";

    $data['nama_halaman']     = "Laporan Perawatan";

    $data['id_perawatan']     = $id_detail;

    $data['perusahaan']       = $this->perusahaan->get_details();

    $data['detail']           = $this->perawatan->get_by_id_with_company($id_header, $tgl_perencanaan);

    $data['id_detail']        = $id_detail;

    $data['tgl_perencanaan']  = $tgl_perencanaan;

    $data['id_perusahaan']    = $id_perusahaan;



    //ADDING TO LOG

    $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;

    $log_type   = "VIEW";

    $log_data   = "";



    log_helper($log_url, $log_type, $log_data);

    //END LOG



    $this->load->view('adminx/laporan/laporan_perawatan', $data, FALSE);
  }



  public function laporan_perawatan_all()
  {

    //CHECK FOR ACCESS FOR EACH FUNCTION

    $user_level       = $this->session->userdata('user_level');

    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);

    if ($check_permission->num_rows() == 1) {

      $data['group_halaman']     = "Perawatan";

      $data['nama_halaman']     = "Laporan Jadwal Perawatan";

      $data['perusahaan']       = $this->perusahaan->get_details();

      $data['perusahaan_all']   = $this->perusahaan->get_all();



      //ADDING TO LOG

      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;

      $log_type   = "VIEW";

      $log_data   = "";



      log_helper($log_url, $log_type, $log_data);

      //END LOG



      $this->load->view('adminx/laporan/laporan_perawatan_all', $data, FALSE);
    } else {

      redirect('errorpage/error403');
    }
  }



  public function laporan_perawatan_all_list()
  {

    $perusahaan_id  = $this->input->post('perusahaan');

    $list           = $this->perawatan->get_laporan_jadwal_perawatan($perusahaan_id);

    $res            = $list;

    $no             = 1;

    $data           = array();

    foreach ($res as $key => $value) {

      $isi_laporan      = base_url() . "perawatan/laporan_perawatan/" . $value->id_detail . "/" . $value->tgl_perencanaan . "/" . $value->id_perusahaan . "/" . $value->id_header;



      $row   = array();



      $row[] = $no++;

      $row[] = $value->status;

      if ($this->session->userdata('user_perusahaan') == 1) {
        $row[] = '<a href="' . $isi_laporan . '" target="_blank" title="Cetak laporan">MAS/FO/IT/03</a>';
      } else {
        $row[] = '<a href="' . $isi_laporan . '" target="_blank" title="Cetak laporan">MAIN/FO/IT/02</a>';
      }

      //$row[] = '<a href="'.$isi_laporan.'" target="_blank" title="Cetak laporan">'.$value->document_id.'</a>';

      $row[] = $value->judul;

      $row[] = $value->tgl_perencanaan;

      $row[] = $value->tgl_pengerjaan == NULL ? '-' : $value->tgl_pengerjaan;

      $row[] = $value->nama;



      $data[] = $row;
    }



    echo json_encode(

      array(

        'status_code' => 200,

        'status'      => 'success',

        'message'     => 'Sukses menampilkan data',

        'data'        => $data

      )

    );
  }
}
