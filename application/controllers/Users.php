<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
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
		$this->load->model('users_model', 'users');
		$this->load->model('perusahaan_model', 'perusahaan');
		$this->load->model('roles_model', 'roles');
	}

	public function index()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 		= "Users";
			$data['nama_halaman'] 		= "Daftar Users";
			$data['perusahaan_all'] 	= $this->perusahaan->get_all();
			$data['perusahaan'] 			= $this->perusahaan->get_details();
			$data['roles'] 						= $this->roles->get_alls();

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";

			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/users/users', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function user_profile()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 		= "Users";
			$data['nama_halaman'] 		= "Profile User";
			$data['icon_halaman'] 		= "icon-user";

			$id 											= $this->session->userdata('user_nip');
			$data['karyawan_detail'] 	= get_karyawan_details($id);
			$data['perusahaan'] 			= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";

			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/users/profile', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function reset_password()
	{
		// $user_level 			= $this->session->userdata('user_level');
		// $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		// if ($check_permission->num_rows() == 1) {
		// $this->_validation_user_wp();
		$nip = $this->input->post('nip');
		$data = $this->users->get_by_id($nip);
		$pt = $data->perusahaan;

		$default = ($pt == 1) ? 'Mas2023!' : 'Main2023!';
		// var_dump($default);
		// exit;
		$data = array(
			'password' 					=> $this->hash_password($default),
			'update_date'				=> date('Y-m-d H:i:s'),
			'update_by' 				=> $this->session->userdata('user_code')
		);

		$this->users->update(array('nip' => $this->input->post('nip')), $data);
		echo json_encode(array("status" => "ok", "message" => "Berhasil direset"));

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "UPDATE";
			$log_data 	= json_encode($data);

			log_helper($log_url, $log_type, $log_data);
		// 	//END LOG
		// } else {
		// 	echo json_encode(array("status" => "forbidden"));
		// }
	}

	public function users_add()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {

			$this->_validation_user();

			$data = array(
				'dept_id' 				=> $this->input->post('department'),
				'nip' 							=> $this->input->post('nip'),
				'nama_pegawai' 			=> $this->input->post('nama'),
				'email_pegawai' 		=> $this->input->post('email'),
				'username' 					=> $this->input->post('username'),
				'password' 					=> $this->hash_password($this->input->post('password')),
				'perusahaan' 				=> $this->input->post('perusahaan'),
				'user_level' 				=> $this->input->post('user_level'), //ROLES
				'aktivasi' 					=> $this->input->post('aktivasi'),
				'insert_date'				=> date('Y-m-d H:i:s'),
				'insert_by' 				=> $this->session->userdata('user_code')
			);
			$insert = $this->users->save($data);
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

	public function users_list()
	{
		$list = $this->users->get_datatables();
		// var_dump($list);
		// exit;
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $users) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="javascript:void(0)" onclick="edit(' . "'" . $users->nip . "'" . ')"
									class="btn btn-success btn-sm text-white">
									<i class="fa fa-edit"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $users->nip . "'" . ')"
                	class="btn btn-danger btn-sm text-white">
                	<i class="fa fa-times"></i>
                </a>
								<a href="javascript:void(0)" onclick="reset_password(' . "'" . $users->nip . "'" . ')"
                	class="btn btn-info btn-sm text-white">
                	<i class="fa fa-refresh"></i>
                </a>';
			$row[] = $users->nama_dept;
			$row[] = $users->nip;
			$row[] = $users->nama_pegawai;
			$row[] = $users->email_pegawai;
			//$row[] = $users->username;
			$row[] = $users->nama;
			$row[] = $users->roles_name;
			$row[] = $users->aktivasi == 'Aktif' ? '<button class="btn btn-info btn-sm">' . strtoupper($users->aktivasi) . '</button>' : '<button class="btn btn-secondary btn-sm">' . strtoupper($users->aktivasi) . '</button>';
			$row[] = $users->last_login == NULL ? '-' : $users->last_login;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->users->count_all(),
			"recordsFiltered" => $this->users->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function users_edit($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data = $this->users->get_by_id($id);
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

	public function users_update()
	{
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_user_wp();

			$data = array(
				'dept_id' 				=> $this->input->post('department'),
				'nip' 							=> $this->input->post('nip'),
				'nama_pegawai' 			=> $this->input->post('nama'),
				'email_pegawai' 		=> $this->input->post('email'),
				'username' 					=> $this->input->post('username'),
				'perusahaan' 				=> $this->input->post('perusahaan'),
				'user_level' 				=> $this->input->post('user_level'), //ROLES
				'aktivasi' 					=> $this->input->post('aktivasi'),
				'update_date'				=> date('Y-m-d H:i:s'),
				'update_by' 				=> $this->session->userdata('user_code')
			);
			$this->users->update(array('id' => $this->input->post('kode')), $data);
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

	public function users_deleted($id)
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data_delete 		= $this->users->get_by_id($id); //DATA DELETE
			$data 					= $this->users->delete_by_id($id);
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

	public function update_password()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 		= "Users";
			$data['nama_halaman'] 		= "Update Password";
			$data['icon_halaman'] 		= "icon-layers";
			$data['perusahaan'] 			= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";

			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/users/update_password', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function update_password_action()
	{
		$data = array(
			'password' 				=> $this->hash_password($this->input->post('confirm_new_password')),
			'update_date'			=> date('Y-m-d H:i:s'),
			'update_by' 			=> $this->session->userdata('user_code')
		);
		$update = $this->users->update(array('id' => $this->session->userdata('user_id')), $data);
		if ($update) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status"      => "success",
					"message"     => "Sukses mengupdate password"
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 500,
					"status"      => "error",
					"message"     => "Gagal mengupdate password"
				)
			);
		}

		//ADDING TO LOG
		$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
		$log_type 	= "UPDATE";
		$log_data 	= json_encode($data);

		log_helper($log_url, $log_type, $log_data);
		//END LOG 
	}

	private function _validation_user()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('department') == '') {
			$data['inputerror'][] = 'department';
			$data['error_string'][] = 'Department is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nip') == '') {
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'NIP is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nama') == '') {
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama karyawan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		// if($this->input->post('username') == '')
		// {
		// 	$data['inputerror'][] = 'username';
		// 	$data['error_string'][] = 'Username is required';
		// 	$data['status'] = FALSE;
		// }

		if ($this->input->post('password') == '') {
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('aktivasi') == '') {
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('user_level') == '') {
			$data['inputerror'][] = 'user_level';
			$data['error_string'][] = 'Roles is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('perusahaan') == '') {
			$data['inputerror'][] = 'perusahaan';
			$data['error_string'][] = 'Perusahaan is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	private function _validation_user_wp()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('department') == '') {
			$data['inputerror'][] = 'department';
			$data['error_string'][] = 'Department is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nip') == '') {
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'NIP is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nama') == '') {
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama karyawan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		// if($this->input->post('username') == '')
		// {
		// 	$data['inputerror'][] = 'username';
		// 	$data['error_string'][] = 'Username is required';
		// 	$data['status'] = FALSE;
		// }

		if ($this->input->post('aktivasi') == '') {
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('user_level') == '') {
			$data['inputerror'][] = 'user_level';
			$data['error_string'][] = 'Roles is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('perusahaan') == '') {
			$data['inputerror'][] = 'perusahaan';
			$data['error_string'][] = 'Perusahaan is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	private function hash_password($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
}