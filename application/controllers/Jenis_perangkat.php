<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_perangkat extends CI_Controller {

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
    $this->load->model('Jenisperangkat_model', 'jenis');
  }

  public function index()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 	= "Master Data";
			$data['nama_halaman'] 	= "Jenis Perangkat";
			$data['perusahaan'] 		= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/perangkat/jenis_perangkat', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function jenis_perangkat_add()
  {
  	//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) { 
	  	$this->_validation_jp();

	  	$data = array(
				'jenis' 		        => $this->input->post('jenis_perangkat'),
				'status' 						=> $this->input->post('status'),
				'created_date'			=> date('Y-m-d H:i:s'),
				'created_by'			  => $this->session->userdata('user_code')
			);
			$insert = $this->jenis->save($data);
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

  public function jenis_perangkat_list()
  {
  	$list = $this->jenis->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $jenis) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="javascript:void(0)" onclick="edit('."'".$jenis->id."'".')"
                  class="btn btn-success btn-sm text-white">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$jenis->id."'".')"
                  class="btn btn-danger btn-sm text-white">
                  <i class="fa fa-times"></i>
                </a>';
      $row[] = $jenis->status == 'AKTIF' ? '<button class="btn btn-info btn-sm">'.strtoupper($jenis->status).'</button>' : '<button class="btn btn-secondary btn-sm">'.strtoupper($jenis->status).'</button>';
			$row[] = $jenis->jenis;
			$row[] = $jenis->nama_pegawai;
			$row[] = $jenis->created_date;
			
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->jenis->count_all(),
			"recordsFiltered" => $this->jenis->count_filtered(),
			"data"            => $data
		);
		//output to json format
		echo json_encode($output);
  }

  public function jenis_perangkat_edit($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data = $this->jenis->get_by_id($id);
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

	public function jenis_perangkat_update()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_jp();
			
			$data = array(
        'jenis' 		        => $this->input->post('jenis_perangkat'),
				'status' 						=> $this->input->post('status'),
				'updated_date'			=> date('Y-m-d H:i:s'),
				'updated_by'			  => $this->session->userdata('user_code')
			);
			$this->jenis->update(array('id' => $this->input->post('kode')), $data);
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

  public function jenis_perangkat_deleted($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $data_delete 		= $this->jenis->get_by_id($id); //DATA DELETE
			$data 					= $this->jenis->delete_by_id($id);
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

	private function _validation_jp(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('jenis_perangkat') == '')
		{
			$data['inputerror'][]     = 'jenis_perangkat';
			$data['error_string'][]   = 'Jenis Perangkat is required';
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