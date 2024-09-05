<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perangkat extends CI_Controller
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
		$this->function_name 	= $this->router->method;
		$this->load->model('Rolespermissions_model');
		//END

		$this->load->model('Dashboard_model');
		$this->load->model('perusahaan_model', 'perusahaan');
		$this->load->model('jenisperangkat_model', 'jenisperangkat');
		$this->load->model('riwayatperangkat_model', 'riwayatHistory');
		$this->load->model('perangkat_model', 'perangkat');
		$this->load->model('departments_model', 'departments');
	}

	public function index()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 	  = "Master Data";
			$data['nama_halaman'] 	  = "Perangkat";
			$data['perusahaan_all']   = $this->perusahaan->get_all();
			$data['perusahaan'] 		  = $this->perusahaan->get_details();
			$data['jenis_perangkat'] 	= $this->jenisperangkat->get_all();

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";

			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/perangkat/perangkat', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function perangkat_add()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_perangkat();

			$data = array(
				'company_id' 		    => $this->input->post('perusahaan'),
				'dept_id' 				  => $this->input->post('department'),
				'id_jenis_perangkat' => $this->input->post('jenis_perangkat'),
				'spesifikasi' 			=> $this->input->post('spesifikasi'),
				'status' 						=> $this->input->post('status'),
				'created_date'			=> date('Y-m-d H:i:s'),
				'created_by'			  => $this->session->userdata('user_code')
			);
			$insert = $this->perangkat->save($data);
			echo json_encode(array("status" => "ok"));

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "ADD";
			$log_data 	= json_encode($data);

			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	public function perangkat_list()
	{
		$list = $this->perangkat->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $perangkat) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '
								<a href="javascript:void(0)" onclick="info(' . "'" . $perangkat->id . "'" . ')"
                  class="btn btn-info btn-sm text-white">
                  <i class="fa fa-info"></i>
                </a>
								<a href="javascript:void(0)" onclick="edit(' . "'" . $perangkat->id . "'" . ')"
                  class="btn btn-success btn-sm text-white">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $perangkat->id . "'" . ')"
                  class="btn btn-danger btn-sm text-white">
                  <i class="fa fa-times"></i>
                </a>';
			$row[] = $perangkat->status . "<br>" . $perangkat->id_perangkat;
			$row[] = $perangkat->nama;
			$row[] = $perangkat->nama_dept; //$perangkat->nama_dept;
			$row[] = $perangkat->jenis;
			$row[] = $perangkat->spesifikasi;
			$row[] = $perangkat->nama_pegawai;

			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->perangkat->count_all(),
			"recordsFiltered" => $this->perangkat->count_filtered(),
			"data"            => $data
		);
		//output to json format
		echo json_encode($output);
	}

	public function perangkat_edit($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data = $this->perangkat->get_by_id($id);
			echo json_encode($data);

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "EDIT";
			$log_data 	= json_encode($data);

			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	public function getHistoryPerangkat($id)
	{
		$data = $this->riwayatHistory->get_by_id_3($id);
		echo json_encode($data);
	}

	public function perangkat_edit_2($id)
	{
		// //CHECK FOR ACCESS FOR EACH FUNCTION
		// $user_level 			= $this->session->userdata('user_level');
		// $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		// if ($check_permission->num_rows() == 1) {
		$data = $this->perangkat->get_by_id_2($id);
		// var_dump($data);
		// exit;
		echo json_encode($data);

		// 	//ADDING TO LOG
		// 	$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
		// 	$log_type 	= "EDIT";
		// 	$log_data 	= json_encode($data);

		// 	log_helper($log_url, $log_type, $log_data);
		// 	//END LOG
		// } else {
		// 	echo json_encode(array("status" => "forbidden"));
		// }
	}

	public function perangkat_update()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_perangkat();

			$data = array(
				'company_id' 		    => $this->input->post('perusahaan'),
				'dept_id' 				  => $this->input->post('department'),
				'id_jenis_perangkat' => $this->input->post('jenis_perangkat'),
				'spesifikasi' 			=> $this->input->post('spesifikasi'),
				'status' 						=> $this->input->post('status'),
				'updated_date'			=> date('Y-m-d H:i:s'),
				'updated_by'			  => $this->session->userdata('user_code')
			);
			$this->perangkat->update(array('id' => $this->input->post('kode')), $data);
			echo json_encode(array("status" => "ok"));

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "UPDATE";
			$log_data 	= json_encode($data);

			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	public function perangkat_deleted($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data_delete 		= $this->perangkat->get_by_id($id); //DATA DELETE
			$data 					= $this->perangkat->delete_by_id($id);
			echo json_encode(array("status" => "ok"));

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "DELETE";
			$log_data 	= json_encode($data_delete);

			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	private function _validation_perangkat()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('perusahaan') == '') {
			$data['inputerror'][]     = 'perusahaan';
			$data['error_string'][]   = 'Perusahaan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('department') == '') {
			$data['inputerror'][]     = 'department';
			$data['error_string'][]   = 'Department is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('jenis_perangkat') == '') {
			$data['inputerror'][]     = 'jenis_perangkat';
			$data['error_string'][]   = 'Jenis Perangkat is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('status') == '') {
			$data['inputerror'][]     = 'status';
			$data['error_string'][]   = 'Status is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}