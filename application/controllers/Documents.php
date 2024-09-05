<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Controller {

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
    $this->load->model('documents_model', 'documents');
  }

  public function index()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 	= "Master Data";
			$data['nama_halaman'] 	= "Documents";
      $data['perusahaan_all'] = $this->perusahaan->get_all();
			$data['perusahaan'] 		= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/documents/document', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function documents_add()
  {
  	//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) { 
	  	$this->_validation_documents();

	  	$data = array(
				'id_perusahaan' 		=> $this->input->post('perusahaan'),
				'nomor_doc' 				=> $this->input->post('no_doc'),
				'nama_doc' 				  => $this->input->post('nama_doc'),
				'status' 						=> $this->input->post('status'),
				'created_date'			=> date('Y-m-d H:i:s'),
				'created_by'			  => $this->session->userdata('user_code')
			);
			$insert = $this->documents->save($data);
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

  public function documents_list()
  {
  	$list = $this->documents->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $documents) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="javascript:void(0)" onclick="edit('."'".$documents->id."'".')"
                  class="btn btn-success btn-sm text-white">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$documents->id."'".')"
                  class="btn btn-danger btn-sm text-white">
                  <i class="fa fa-times"></i>
                </a>';
      $row[] = $documents->status == 'AKTIF' ? '<button class="btn btn-info btn-sm">'.strtoupper($documents->status).'</button>' : '<button class="btn btn-secondary btn-sm">'.strtoupper($documents->status).'</button>';
			$row[] = $documents->nomor_doc;
			$row[] = $documents->nama_doc;
			$row[] = $documents->nama;
			
		
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->documents->count_all(),
			"recordsFiltered" => $this->documents->count_filtered(),
			"data"            => $data
		);
		//output to json format
		echo json_encode($output);
  }

  public function documents_edit($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data = $this->documents->get_by_id($id);
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

	public function documents_update()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_documents();
			
			$data = array(
        'id_perusahaan' 		=> $this->input->post('perusahaan'),
				'nomor_doc' 				=> $this->input->post('no_doc'),
				'nama_doc' 				  => $this->input->post('nama_doc'),
				'status' 						=> $this->input->post('status'),
				'updated_date'			=> date('Y-m-d H:i:s'),
				'updated_by'			  => $this->session->userdata('user_code')
			);
			$this->documents->update(array('id' => $this->input->post('kode')), $data);
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

  public function documents_deleted($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $data_delete 		= $this->documents->get_by_id($id); //DATA DELETE
			$data 					= $this->documents->delete_by_id($id);
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

	private function _validation_documents(){
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

		if($this->input->post('no_doc') == '')
		{
			$data['inputerror'][]     = 'no_doc';
			$data['error_string'][]   = 'Nomor Document is required';
			$data['status'] = FALSE;
		}

    if($this->input->post('no_doc') == '')
		{
			$data['inputerror'][]     = 'no_doc';
			$data['error_string'][]   = 'Nomor Document is required';
			$data['status'] = FALSE;
		}

    if($this->input->post('nama_doc') == '')
		{
			$data['inputerror'][]     = 'nama_doc';
			$data['error_string'][]   = 'Nama Document is required';
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