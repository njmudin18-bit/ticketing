<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller {

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
    $this->load->model('users_model', 'users');
    $this->load->model('perusahaan_model', 'perusahaan');
    $this->load->model('roles_model', 'roles');
  }

  public function index()
	{
    //CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 		= "Perusahaan";
			$data['nama_halaman'] 		= "Daftar Perusahaan";
			$data['perusahaan'] 			= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/perusahaan/perusahaan', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

  public function perusahaan_list()
  {
  	$list = $this->perusahaan->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $perusahaan) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$perusahaan->id."'".')"
									class="btn btn-success btn-sm text-white">
									<i class="fa fa-edit"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$perusahaan->id."'".')"
                	class="btn btn-danger btn-sm text-white">
                	<i class="fa fa-times"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalUpload('."'".$perusahaan->id."'".')" title="Tambahkan Icon Perusahaan"
                	class="btn btn-warning btn-sm text-white">
                	<i class="fa fa-upload"></i>
                </a>';
			$row[] = $perusahaan->aktivasi == 'Aktif' ? '<button class="btn btn-info btn-sm">'.strtoupper($perusahaan->aktivasi).'</button>' : '<button class="btn btn-secondary btn-sm">'.strtoupper($perusahaan->aktivasi).'</button>';
			$row[] = $perusahaan->nama;
			$row[] = $perusahaan->telepon;
			$row[] = $perusahaan->handphone;
			$row[] = $perusahaan->fax;
			$row[] = $perusahaan->email;
			$row[] = $perusahaan->alamat;
			$row[] = $perusahaan->icon_name;
			$row[] = $perusahaan->logo_name;
			$row[] = $perusahaan->twitter;
			$row[] = $perusahaan->facebook;
			$row[] = $perusahaan->instagram;
			$row[] = $perusahaan->pinterest;
			$row[] = $perusahaan->youtube;
			$row[] = $perusahaan->skype;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->perusahaan->count_all(),
			"recordsFiltered" => $this->perusahaan->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function perusahaan_add() 
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $this->_validation_perusahaan();

      //PREPARING CONFIG FILE UPLOAD
      $new_name                 = $_FILES['file']['name'];
      $config['file_name']      = $new_name;
      $config['upload_path'] 		= './upload/general_images';
      $config['allowed_types'] 	= 'jpg|png|webp';
      $config['max_size']  			= '8192';

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('file')) {
        $status = "error";
        $msg 		= $this->upload->display_errors();
      } else {

        $dataupload = $this->upload->data();
        $data = array(
          'nama'					=> $this->input->post('nama'),
          'logo_name'			=> $dataupload['file_name'],
          'aktivasi'			=> $this->input->post('aktivasi'),
          'telepon'				=> $this->input->post('telepon'),
          'handphone'			=> $this->input->post('handphone'),
          'fax'						=> $this->input->post('fax'),
          'email'					=> $this->input->post('email'),
          'alamat'				=> $this->input->post('alamat'),
          'maps'					=> $this->input->post('maps'),
          'twitter'				=> $this->input->post('twitter'),
          'facebook'			=> $this->input->post('facebook'),
          'instagram'			=> $this->input->post('instagram'),
          'pinterest'			=> $this->input->post('pinterest'),
          'youtube'				=> $this->input->post('youtube'),
          'skype'					=> $this->input->post('skype'),
          'create_date'		=> date('Y-m-d H:i:s'),
          'create_by' 		=> $this->session->userdata('user_id')
        );
        
        $insert = $this->perusahaan->save($data);
        echo json_encode(array("status" => "ok"));
      }
    } else {
			echo json_encode(array("status" => "forbidden"));
		}
  }

	public function perusahaan_edit($id)
	{
    //CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $data = $this->perusahaan->get_by_id($id);
      echo json_encode($data);
    } else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	public function perusahaan_update()
	{
    //CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $this->_validation_perusahaan();

      if ($_FILES['file']['name'] == '') {

        $data = array(
          'nama'					=> $this->input->post('nama'),
          'aktivasi'			=> $this->input->post('aktivasi'),
          'telepon'				=> $this->input->post('telepon'),
          'handphone'			=> $this->input->post('handphone'),
          'fax'						=> $this->input->post('fax'),
          'email'					=> $this->input->post('email'),
          'alamat'				=> $this->input->post('alamat'),
          'maps'					=> $this->input->post('maps'),
          'twitter'				=> $this->input->post('twitter'),
          'facebook'			=> $this->input->post('facebook'),
          'instagram'			=> $this->input->post('instagram'),
          'pinterest'			=> $this->input->post('pinterest'),
          'youtube'				=> $this->input->post('youtube'),
          'skype'					=> $this->input->post('skype'),
          'update_date'		=> date('Y-m-d H:i:s'),
          'update_by' 		=> $this->session->userdata('user_id')
        );
        $this->perusahaan->update(array('id' => $this->input->post('kode')), $data);

        echo json_encode(array("status" => "ok"));
      } else {
        $id 				= $this->input->post('kode');
        $get_image 	= $this->perusahaan->get_by_id($id);

        //PREPARING CONFIG FILE UPLOAD
        $new_name                 = $_FILES['file']['name'];
        $config['file_name']      = $new_name;
        $config['upload_path'] 		= './upload/general_images';
        $config['allowed_types'] 	= 'jpg|png|webp';
        $config['max_size']  			= '8192';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
          $status = "error";
          $msg 		= $this->upload->display_errors();
          echo $msg;
        } else {

          $dataupload = $this->upload->data();
          $data = array(
            'nama'					=> $this->input->post('nama'),
            'logo_name'			=> $dataupload['file_name'],
            'aktivasi'			=> $this->input->post('aktivasi'),
            'telepon'				=> $this->input->post('telepon'),
            'handphone'			=> $this->input->post('handphone'),
            'fax'						=> $this->input->post('fax'),
            'email'					=> $this->input->post('email'),
            'alamat'				=> $this->input->post('alamat'),
            'maps'					=> $this->input->post('maps'),
            'twitter'				=> $this->input->post('twitter'),
            'facebook'			=> $this->input->post('facebook'),
            'instagram'			=> $this->input->post('instagram'),
            'pinterest'			=> $this->input->post('pinterest'),
            'youtube'				=> $this->input->post('youtube'),
            'skype'					=> $this->input->post('skype'),
            'update_date'		=> date('Y-m-d H:i:s'),
            'update_by' 		=> $this->session->userdata('user_id')
          );
          
          $update = $this->perusahaan->update(array('id' => $this->input->post('kode')), $data);
          if ($update) {
            $files 			= "./upload/general_images/".$get_image->logo_name;
            $hapus_file = unlink($files);

            echo json_encode(array("status" => "ok"));
          } else {
            echo json_encode(array("status" => "failed"));
          }
        }
      }
    } else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	public function perusahaan_deleted($id)
	{
    //CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if ($check_permission->num_rows() == 1) {
      $cek_file 	= $this->perusahaan->get_by_id($id);
      $files 			= "./upload/general_images/".$cek_file->logo_name;
      $files2 		= "./upload/general_images/".$cek_file->icon_name;
      $hapus_file = unlink($files);
      $hapus_icon = unlink($files2);
      if ($hapus_file) {
        $data_delete 	= $this->perusahaan->get_by_id($id); //DATA DELETE
        $data 				= $this->perusahaan->delete_by_id($id);
        echo json_encode(array("status" => "ok"));
      }
    } else {
			echo json_encode(array("status" => "forbidden"));
		}
	}

	//FUNCTION UPLOAD ICON
	public function upload_icon()
	{
		$id 				= $this->input->post('kode_perusahaan');
		$get_image 	= $this->perusahaan->get_by_id($id);

		//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file_icon']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/general_images';
    $config['allowed_types'] 	= 'jpg|png|webp';
    $config['max_size']  			= '8192';

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file_icon')) {
      $status = "error";
      $msg 		= $this->upload->display_errors();

      echo $msg;
    } else {

      $dataupload = $this->upload->data();
	    $data = array(
				'icon_name'			=> $dataupload['file_name'],
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
       
      $update = $this->perusahaan->update(array('id' => $id), $data);
      if ($update) {

      	$cek_icon = $get_image->icon_name;
      	//echo $icon_name;
      	if ($cek_icon == '' || $cek_icon == null) {
      		echo json_encode(array("status" => "ok"));
      	} else {
      		$files 			= "./upload/general_images/".$get_image->icon_name;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
      	}
      } else {
      	echo json_encode(array("status" => "failed"));
      }
    }
	}

	private function _validation_perusahaan(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Perusahaan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('telepon') == '')
		{
			$data['inputerror'][] = 'telepon';
			$data['error_string'][] = 'Nomor Telepon is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('handphone') == '')
		{
			$data['inputerror'][] = 'handphone';
			$data['error_string'][] = 'Nomor Handphone is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('fax') == '')
		{
			$data['inputerror'][] = 'fax';
			$data['error_string'][] = 'Nomor Fax is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Alamat Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('alamat') == '')
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat Perusahaan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}