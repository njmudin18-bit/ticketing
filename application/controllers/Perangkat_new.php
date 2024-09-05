<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/fpdf/fpdf.php');
require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');

class Perangkat_new extends CI_Controller
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
		$this->load->model('perangkat_new_model', 'perangkat');
		$this->load->model('departments_model', 'departments');
	}

	public function index()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$data['group_halaman'] 	  = "Master Data";
			$data['nama_halaman'] 	  = "Data Perangkat";
			$data['perusahaan_all']   = $this->perusahaan->get_all();
			$data['perusahaan'] 		  = $this->perusahaan->get_details();
			$data['no_document'] 	  = ($data['perusahaan']->id == '2') ? "MAIN/FO/IT/05" : "MAS/FO/IT/05";
			$data['jenis_perangkat'] 	= $this->jenisperangkat->get_all();
			// var_dump($data['perusahaan']->id);
			// exit;
			//ADDING TO LOG
			$log_url 		= base_url() . $this->contoller_name . "/" . $this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";

			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/perangkat/perangkat_new', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function get_current_user()
	{
		$dept_id = $this->input->post('id_dept');
		// var_dump($dept_id);
		// exit;
		$data = $this->perangkat->get_current_user($dept_id);
		echo json_encode($data);
	}

	public function getKodePerangkat()
	{
		$pt = $this->input->post('pt');
		// var_dump($pt);
		// exit;
		$data = $this->perangkat->generate_perangkat_number($pt);
		echo json_encode($data);
	}

	public function perangkat_add()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
		if ($check_permission->num_rows() == 1) {
			$this->_validation_perangkat();

			$data = array(
				'company_id' 		    	=> $this->input->post('perusahaan'),
				'dept_id' 				  	=> $this->input->post('department'),
				'id_current_user' 	  => $this->input->post('current_user'),
				'kode_perangkat' 	  	=> $this->input->post('kode_perangkat'),
				'kode_asset' 	  			=> $this->input->post('kode_asset'),
				'id_jenis_perangkat' 	=> $this->input->post('jenis_perangkat'),
				'nama_perangkat' 			=> $this->input->post('nama_perangkat'),
				'spesifikasi' 				=> $this->input->post('spesifikasi'),
				'status' 							=> $this->input->post('status'),
				'ip_address' 					=> $this->input->post('ip_address'),
				'pass_pc' 						=> $this->input->post('pass_kom'),
				'created_date'				=> date('Y-m-d H:i:s'),
				'created_by'			  	=> $this->session->userdata('user_code')
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

	public function print_test($ids)
	{
		// var_dump('test');exit();

		$ids = [123, 125];
		$dir = FCPATH . 'qrcodes/';
		$files = glob($dir . '*'); // Ambil daftar file di direktori qrcodes/

		// Bersihkan direktori qrcodes terlebih dahulu
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file); // Hapus file
			}
		}

		// Inisialisasi array untuk menyimpan tautan PDF
		$pdfLinks = array();

		foreach ($ids as $id) {
			$data = $this->perangkat->get_by_id($id);
			$kode_perangkat = $data->kode_perangkat;
			$kode_assets = $data->kode_asset;
			$kode_asset = $kode_assets ? $kode_assets : '-';
			$isi_qrcode = "$kode_asset|$kode_perangkat";
			$kode = $kode_asset == '-' ? $kode_perangkat : $kode_asset;
			$datetime = $data->created_date;
			$date = substr($datetime, 0, 10);

			$pdf = new FPDF();
			$pdf->SetMargins(1, 0);
			$pdf->SetAutoPageBreak(true, 0);
			$pdf->AddPage('L', array(60, 30));
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetLineWidth(0.5);

			$qrCodeFile = FCPATH . 'qrcodes/' . $kode_perangkat . '.png';
			QRcode::png($isi_qrcode, $qrCodeFile, 'H', 10);

			// Mengatur posisi gambar QR code agar berada di tengah halaman
			$yCenter = 0; // Menyesuaikan dengan ukuran halaman (30 - 15)/2
			$xRight = $pdf->GetPageWidth() - 25; // 30 adalah lebar gambar QR code
			$pdf->Image($qrCodeFile, 35, 1, 25, 0);

			// Gambar kotak dengan Rect()
			$pdf->Rect(1, 2, 58, 27); // kotak keseluruhan
			$pdf->Rect(1, 2, 35, 6); // kotak $kode
			$pdf->Cell(35, 8, "$kode", 0, 0, 'C');
			$pdf->Rect(1, 2, 35, 27); // kotak $data->nama_perangkat
			$pdf->SetXY(1, 8);
			$pdf->MultiCell(35, 4, "$data->nama_perangkat", 0, '');
			$pdf->Rect(36, 2, 23, 23); // kotak $date
			$pdf->SetXY(36, 24);
			$pdf->Cell(23, 6, "$date", 0, 0, 'C');

			$pdfFileName = 'print_' . $kode_perangkat . '.pdf';
			$pdfFilePath = FCPATH . 'qrcodes/' . $pdfFileName;
			$pdf->Output($pdfFilePath, 'F'); // Simpan PDF sementara di server

			// Tambahkan tautan PDF ke array
			$pdfLinks[] = base_url('qrcodes/' . $pdfFileName);
		}

		// Tampilkan tautan untuk mengunduh PDF
		$response = array(
			'success' => true,
			'pdfUrls' => $pdfLinks
		);
		echo json_encode($response);
	}


	public function print($id)
	{
		$data = $this->perangkat->get_by_id($id);
		$kode_perangkat = $data->kode_perangkat;
		$kode_assets 		= $data->kode_asset;
		$kode_asset 		= $kode_assets ? $kode_assets : '-';
		$isi_qrcode 		=	"$kode_asset|$kode_perangkat";
		$kode 					= $kode_asset == '-' ? $kode_perangkat : $kode_asset;
		$datetime 			= $data->created_date;
		$date 					= substr($datetime, 0, 10);

		$dir = FCPATH . 'qrcodes/';
		$files = glob($dir . '*'); // Ambil daftar file di direktori qrcodes/

		foreach ($files as $file) { // Loop untuk menghapus setiap file
			if (is_file($file)) {
				unlink($file); // Hapus file
			}
		}

		$pdf = new FPDF();
		$pdf->SetMargins(1, 0);
		$pdf->SetAutoPageBreak(true, 0);
		$pdf->AddPage('L', array(60, 30));
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->SetLineWidth(0.5);

		$nama_file = 'qrcode';
		$qrCodeFile = FCPATH . 'qrcodes/' . $kode_perangkat . '.png';
		QRcode::png($isi_qrcode, $qrCodeFile, 'H', 10);

		// Mengatur posisi gambar QR code agar berada di tengah halaman
		$yCenter = 0; // Menyesuaikan dengan ukuran halaman (30 - 15)/2
		$xRight = $pdf->GetPageWidth() - 25; // 30 adalah lebar gambar QR code
		$pdf->Image($qrCodeFile, 35, 1, 25, 0);

		// Gambar kotak dengan Rect()
		$pdf->Rect(1, 2, 58, 27); // kotak keseluruhan
		$pdf->Rect(1, 2, 35, 6); //kotak $kode
		$pdf->Cell(35, 8, "$kode", 0, 0, 'C');
		$pdf->Rect(1, 2, 35, 27); //kotak $data->nama_perangkat
		$pdf->SetXY(1, 8);
		$pdf->MultiCell(35, 4, "$data->nama_perangkat", 0, '');
		$pdf->Rect(36, 2, 23, 23); //kotak $date
		$pdf->SetXY(36, 24);
		$pdf->Cell(23, 6, "$date", 0, 0, 'C');

		$pdfFileName = 'print_' . $kode_perangkat . '.pdf';
		$pdfFilePath = FCPATH . 'qrcodes/' . $pdfFileName;
		$pdf->Output($pdfFilePath, 'F'); // Simpan PDF sementara di server

		// Tampilkan tautan untuk mengunduh PDF
		$response = array(
			'success' => true,
			'pdfUrl' => base_url('qrcodes/' . $pdfFileName)
		);
		echo json_encode($response);
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
			$kode_asset = is_null($perangkat->kode_asset) || empty($perangkat->kode_asset) ? '-' : $perangkat->kode_asset;
			$row[] = $kode_asset;
			$row[] = $perangkat->status . "<br>" . $perangkat->kode_perangkat;
			$row[] = $perangkat->nama;
			$row[] = $perangkat->nama_dept; //$perangkat->nama_dept;
			$row[] = $perangkat->jenis;
			$row[] = $perangkat->nama_perangkat;
			$row[] = $perangkat->spesifikasi;
			$row[] = $perangkat->nama_pegawai;
			$row[] = $perangkat->ip_address ?? " - ";
			$row[] = $perangkat->pass_pc ?? " - ";
			//add html for action
			// $row[] = '
			// 					<a href="javascript:void(0)" onclick="info(' . "'" . $perangkat->id . "'" . ')"
			//             class="btn btn-info btn-sm text-white">
			//             <i class="fa fa-info"></i>
			//           </a>
			// 					<a href="javascript:void(0)" onclick="edit(' . "'" . $perangkat->id . "'" . ')"
			//             class="btn btn-success btn-sm text-white">
			//             <i class="fa fa-edit"></i>
			//           </a>
			//           <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $perangkat->id . "'" . ')"
			//             class="btn btn-danger btn-sm text-white">
			//             <i class="fa-solid fa-trash"></i>
			//           </a>';
			$row[] = '<div class="dropdown">
			<button class="btn btn-primary">...</button>
			<div class="dropdown-content">
						<a href="javascript:void(0)" onclick="info(' . "'" . $perangkat->id . "'" . ')"
							class="btn btn-info btn-sm text-white"> <i class="fa fa-inf"></i>
							Info
						</a>
						<a href="javascript:void(0)" onclick="edit(' . "'" . $perangkat->id . "'" . ')"
							class="btn btn-success btn-sm text-white"><i class="fa fa-edit"></i>
							Edit
						</a>
						<a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $perangkat->id . "'" . ')"
							class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i>
							Delete
						</a>
						<a href="javascript:void(0)" onclick="print(' . "'" . $perangkat->id . "'" . ')"
							class="btn btn-secondary btn-sm text-white"><i class="fa fa-print"></i>
							Print
						</a>
			</div>
	</div>';

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
				'company_id' 		    	=> $this->input->post('perusahaan'),
				'dept_id' 				  	=> $this->input->post('department'),
				'id_current_user' 		=> $this->input->post('current_user'),
				'kode_perangkat' 			=> $this->input->post('kode_perangkat'),
				'kode_asset' 	  			=> $this->input->post('kode_asset'),
				'id_jenis_perangkat' 	=> $this->input->post('jenis_perangkat'),
				'spesifikasi' 				=> $this->input->post('spesifikasi'),
				'nama_perangkat' 			=> $this->input->post('nama_perangkat'),
				'status' 							=> $this->input->post('status'),
				'ip_address' 					=> $this->input->post('ip_address'),
				'pass_pc' 						=> $this->input->post('pass_kom'),
				'updated_date'				=> date('Y-m-d H:i:s'),
				'updated_by'			  	=> $this->session->userdata('user_code')
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

		if ($this->input->post('nama_perangkat') == '') {
			$data['inputerror'][]     = 'nama_perangkat';
			$data['error_string'][]   = 'Nama Perangkat is required';
			$data['status'] = FALSE;
		}

		// 		if ($this->input->post('spesifikasi') == '') {
		// 			$data['inputerror'][]     = 'spesifikasi';
		// 			$data['error_string'][]   = 'Spesifikasi is required';
		// 			$data['status'] = FALSE;
		// 		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}
