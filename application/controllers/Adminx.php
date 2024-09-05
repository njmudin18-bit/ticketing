<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminx extends CI_Controller {

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
        $this->load->model('Analytics_model', 'analytics');
        $this->load->model('Perawatan_model', 'perawatan');
        $this->load->model('Users_model', 'users');
        $this->load->model('Perusahaan_model', 'perusahaan');
        $this->load->model('Perangkat_model', 'perangkat');
        $this->load->model('Jenisperangkat_model', 'jenis_perangkat');
    }
  
	public function index()
	{
        //CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level = $this->session->userdata('user_level');
		$check_permission = $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			//ADDING TO LOG
			$log_url 	= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type = "VIEW";
			$log_data = "";
			log_helper($log_url, $log_type, $log_data);
			//END LOG
			
			$data['perusahaan'] = $this->perusahaan->get_details();
		    $this->load->view('adminx/dashboard', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

    public function show_jumlah_perangkat_by_jenis() {
        $res_perangkat  = $this->analytics->get_perangkat_berdasarkan_jenis();
        $tbl_perangkat  = "";
        $no             = 1;
        foreach ($res_perangkat as $key => $value) {
            $tbl_perangkat .= '<tr>
                                  <td class="text-start">'.$no++.'</td>
                                  <td class="text-start">'.$value->JENIS_PERANGKAT.'</td>
                                  <td class="text-end">'.$value->JLH_PERANGKAT.'</td>
                                </tr>';
        }
        
        echo json_encode(
            array(
                "status_code"     => 200,
                "status"          => "success",
                "message"         => "Sukses menampilkan data",
                "data_perangkat"  => $res_perangkat,
                "tbl_perangkat"   => $tbl_perangkat
            )
        );
    }

    public function show_jumlah_perangkat_by_perusahaan() {
        $result         = $this->analytics->get_perangkat_by_perusahaan();
        $tbl_perangkat  = "";
        $no             = 1;
        foreach ($result as $key => $value) {
          $tbl_perangkat .= '<tr>
                              <td class="text-start">'.$no++.'</td>
                              <td class="text-start">'.$value->NAMA_PERUSAHAAN.'</td>
                              <td class="text-end">'.$value->JLH_PERANGKAT.'</td>
                            </tr>';
        }
        
        echo json_encode(
            array(
                "status_code"     => 200,
                "status"          => "success",
                "message"         => "Sukses menampilkan data",
                "data"            => $result,
                "tbl_perangkat"   => $tbl_perangkat
            )
        );
    }

    public function show_jadwal_perawatan() {
        $result = $this->perawatan->get_data_all_perawatan();
        echo json_encode(
            array(
                "status_code"     => 200,
                "status"          => "success",
                "message"         => "Sukses menampilkan data",
                "data"            => $result
            )
        );
    }

    public function show_count_data() {
        $user_result            = $this->users->get_alls();
        $perusahaan_result      = $this->perusahaan->get_all();
        $perangkat_result       = $this->perangkat->get_alls();
        $jenis_perangkat_result = $this->jenis_perangkat->get_all();
        echo json_encode(
            array(
                "status_code"             => 200,
                "status"                  => "success",
                "message"                 => "Sukses menampilkan data",
                "jumlah_user"             => count($user_result),
                "jumlah_perusahaan"       => count($perusahaan_result),
                "jumlah_perangkat"        => count($perangkat_result),
                "jumlah_jenis_perangkat"  => count($jenis_perangkat_result)
            )
        );
    }

    public function logout()
	{
		$id       = $this->session->userdata('user_code');
		$data     = $this->users->get_by_id($id);
		//ADDING TO LOG
		$log_url  = base_url() . $this->contoller_name . "/" . $this->function_name;
		$log_type = "LOGOUT";
		$log_data = json_encode($data);
		log_helper($log_url, $log_type, $log_data);
		//END LOG
		
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
