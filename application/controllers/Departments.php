<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller {

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

	public function __construct() {
    parent::__construct();

    $this->load->model('auth_model', 'auth');
    if($this->auth->isNotLogin());

    //START ADD THIS FOR USER ROLE MANAGMENT
		$this->contoller_name = $this->router->class;
    $this->function_name 	= $this->router->method;
    $this->load->model('Rolespermissions_model');
    //END

    $this->load->model('Dashboard_model');
    $this->load->model('perusahaan_model', 'perusahaan');
    $this->load->model('departments_model', 'departments');
  }

  public function index()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 	= "Master Data";
			$data['nama_halaman'] 	= "Departments";
      $data['perusahaan_all'] = $this->perusahaan->get_all();
			$data['perusahaan'] 		= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/departments/departments', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function departments_add()
  {
  	//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) { 
	  	$this->_validation_department();

	  	$data = array(
				'company_id' 		    => $this->input->post('perusahaan'),
				'nama_dept' 				=> $this->input->post('nama_dept'),
				'status' 						=> $this->input->post('status'),
				'created_date'			=> date('Y-m-d H:i:s'),
				'created_by'			  => $this->session->userdata('user_code')
			);
			$insert = $this->departments->save($data);
			echo json_encode(array("status" => "ok"));

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "ADD";
			$log_data 	= json_encode($data);
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
  }

  public function departments_list()
  {
  	$list = $this->departments->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $departments) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="javascript:void(0)" onclick="edit('."'".$departments->id."'".')"
                  class="btn btn-success btn-sm text-white">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$departments->id."'".')"
                  class="btn btn-danger btn-sm text-white">
                  <i class="fa fa-times"></i>
                </a>';
      $row[] = $departments->status == 'AKTIF' ? '<button class="btn btn-info btn-sm">'.strtoupper($departments->status).'</button>' : '<button class="btn btn-secondary btn-sm">'.strtoupper($departments->status).'</button>';
			$row[] = $departments->nama;
			$row[] = $departments->nama_dept;
			
		
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->departments->count_all(),
			"recordsFiltered" => $this->departments->count_filtered(),
			"data"            => $data
		);
		//output to json format
		echo json_encode($output);
  }

  public function departments_edit($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data = $this->departments->get_by_id($id);
			echo json_encode($data);

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "EDIT";
			$log_data 	= json_encode($data);
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	public function departments_update()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_department();
			
			$data = array(
        'company_id' 		    => $this->input->post('perusahaan'),
				'nama_dept' 				=> $this->input->post('nama_dept'),
				'status' 						=> $this->input->post('status'),
				'updated_date'			=> date('Y-m-d H:i:s'),
				'updated_by'			  => $this->session->userdata('user_code')
			);
			$this->departments->update(array('id' => $this->input->post('kode')), $data);
			echo json_encode(array("status" => "ok"));

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "UPDATE";
			$log_data 	= json_encode($data);
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

  public function departments_deleted($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $data_delete 		= $this->departments->get_by_id($id); //DATA DELETE
			$data 					= $this->departments->delete_by_id($id);
			echo json_encode(array("status" => "ok"));

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "DELETE";
			$log_data 	= json_encode($data_delete);
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG
		} else {
		  echo json_encode(array("status" => "forbidden"));
		}
	}

  public function get_department_by_company() 
  {
    $id_company = $this->input->post('id');
    $data       = $this->departments->get_dept_by_perusahaan($id_company);

    echo json_encode($data);
  }

	private function _validation_department(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('perusahaan') == '')
		{
			$data['inputerror'][]     = 'perusahaan';
			$data['error_string'][]   = 'Perusahaan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('nama_dept') == '')
		{
			$data['inputerror'][]     = 'nama_dept';
			$data['error_string'][]   = 'Nama Department is required';
			$data['status'] = FALSE;
		}

    if($this->input->post('status') == '')
		{
			$data['inputerror'][]     = 'status';
			$data['error_string'][]   = 'Status is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}