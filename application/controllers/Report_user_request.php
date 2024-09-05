<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_user_request extends CI_Controller
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
   * @see https://codeigniter.com/userguide3/general/urls.html
   */

  public function __construct()
  {
    parent::__construct();
    $this->load->model('auth_model', 'auth');
    if ($this->auth->isNotLogin());

    $this->load->model('perusahaan_model', 'perusahaan');
    $this->load->model('users_model', 'users');

    //START ADD THIS FOR USER ROLE MANAGMENT
    $this->contoller_name = $this->router->class;
    $this->function_name = $this->router->method;
    $this->load->model('Rolespermissions_model');
    //END

    $this->load->model('Dashboard_model');
    $this->load->model('Report_user_request_m', 'report');
  }

  public function index()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_level = $this->session->userdata('user_level');
    $check_permission = $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      //ADDING TO LOG
      $log_url   = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type = "VIEW";
      $log_data = "";

      log_helper($log_url, $log_type, $log_data);
      //END LOG

      $data['perusahaan'] = $this->perusahaan->get_details();
      $this->load->view('adminx/user_requests/report_user_request', $data, FALSE);
    } else {
      redirect('errorpage/error403');
    }
  }
  public function show_count_data()
  {
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');

    $get_software_selesai       = $this->report->get_software_selesai($start_date, $end_date);
    $get_software_total       = $this->report->get_software_total($start_date, $end_date);
    $get_hardware_selesai       = $this->report->get_hardware_selesai($start_date, $end_date);
    $get_hardware_total       = $this->report->get_hardware_total($start_date, $end_date);

    $result = array(
      "status_code"                 => 200,
      "status"                      => "success",
      "message"                     => "Sukses menampilkan data",
      "get_software_selesai"        => $get_software_selesai,
      "get_software_total"          => $get_software_total,
      "get_hardware_selesai"        => $get_hardware_selesai,
      "get_hardware_total"          => $get_hardware_total,
    );

    echo json_encode($result);
  }

  public function show_jumlah_perangkat_by_perusahaan()
  {
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');

    $result         = $this->report->get_jumlah_request_status($start_date, $end_date);
    $tbl_perangkat  = "";
    $no             = 1;
    foreach ($result as $key => $value) {
      $tbl_perangkat .= '<tr>
                          <td class="text-start">' . $no++ . '</td>
                          <td class="text-start">' . $value->status_trans . '</td>
                          <td class="text-end">' . $value->jumlah . '</td>
                        </tr>';
    }

    $result = array(
      "status_code"     => 200,
      "status"          => "success",
      "message"         => "Sukses menampilkan data",
      "data"            => $result,
      "tbl_perangkat"   => $tbl_perangkat
    );

    echo json_encode($result);
  }
}
