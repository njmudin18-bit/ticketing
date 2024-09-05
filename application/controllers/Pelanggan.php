<?php

use PSpell\Config;

defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
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

    $this->load->helper(array('url', 'form', 'cookie', 'file'));
    $this->load->model('auth_model', 'auth');
    if ($this->auth->isNotLogin());

    //START ADD THIS FOR USER ROLE MANAGMENT
    $this->contoller_name = $this->router->class;
    $this->function_name   = $this->router->method;
    $this->load->model('Rolespermissions_model');
    //END

    $this->load->model('Dashboard_model');
    $this->load->model('perusahaan_model', 'perusahaan');
    $this->load->model('perangkat_model', 'perangkat');
    $this->load->model('departments_model', 'departments');
    $this->load->model('partner_model', 'partner');
    $this->load->model('signature_model', 'signature');
  }

  public function index()
  {
    //CHECK FOR ACCESS FOR EACH FUNCTION
    $user_dept_id     = $this->session->userdata('user_dept_id');
    $user_id          = $this->session->userdata('user_id');
    $user_level       = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name, $this->function_name, $user_level);
    if ($check_permission->num_rows() == 1) {
      $data['group_halaman']     = "Pelanggan & Partner";
      $data['nama_halaman']     = "Form Perubahan Data Partner";
      $dept                     = $this->departments->get_by_id($user_dept_id);
      $company_id               = $dept->company_id;

      // $data['partner_all']      = $this->partner->get_all();
      $data['perusahaan_all']   = $this->perusahaan->get_all();
      $data['perusahaan']       = $this->perusahaan->get_details();
      // $data['signatures']       = $this->signature->get_all_by_company($company_id);

      //ADDING TO LOG
      $log_url     = base_url() . $this->contoller_name . "/" . $this->function_name;
      $log_type   = "VIEW";
      $log_data   = "";

      log_helper($log_url, $log_type, $log_data);
      //END LOG

      $this->load->view('adminx/pelanggan/form_perubahan_data_partner', $data, FALSE);
    } else {
      redirect('errorpage/error403');
    }
  }

  public function get_partner()
  {
    $id_perusahaan  = $this->input->post('id_perusahaan');
    $id_partner     = $this->input->post('id_partner');
    $revision       = $this->input->post('revision');
    $hosting_mas    = $this->load->database('hosting_mas', TRUE);

    $sql    = "SELECT * FROM ms_partner_revision 
                WHERE CompanyID = '$id_perusahaan' AND PartnerID = '$id_partner' AND RevisionNumber='$revision'
                ORDER BY PartnerName";

    $query  = $hosting_mas->query($sql);
    $cek    = $query->row();
    if ($cek) {
      $sql    = "SELECT * FROM ms_file_upload_partner WHERE PartnerID = '$id_partner' AND revision='$revision'";
      $query  = $this->db->query($sql);
      $result = $query->row();

      if ($result) {
        $nama_files = json_decode($result->nama_file);
        $lampiran['file'] = $nama_files;
        $lampiran['informasi'] = $result->informasi ?? '';
      } else {
        $lampiran = null;
      }

      $data_partner   = $this->partner->get_pelanggan_info_revisi($id_partner, $revision);
      $data_shipment  = $this->partner->get_pelanggan_shipment_revisi($id_partner, $revision);

      echo json_encode(
        array(
          "status_code"       => 200,
          "status"            => "success",
          "message"           => "Sukses menampilkan data",
          "partner_info"      => $data_partner,
          "partner_shipment"  => $data_shipment,
          "lampiran"          => $lampiran
        )
      );
    } else {
      $partner_id     = $this->input->post('id_partner');
      $data_partner   = $this->partner->get_pelanggan_info($partner_id);
      $data_shipment  = $this->partner->get_pelanggan_shipment($partner_id);
      $lampiran = null;

      echo json_encode(
        array(
          "status_code"       => 200,
          "status"            => "success",
          "message"           => "Sukses menampilkan data",
          "partner_info"      => $data_partner,
          "partner_shipment"  => $data_shipment,
          "lampiran"          => $lampiran
        )
      );
    }
  }


  public function get_partner_data()
  {
    $id_perusahaan  = $this->input->post('id_perusahaan');
    $hosting_mas    = $this->load->database('hosting_mas', TRUE);
    if ($id_perusahaan == '1') {
      $sql    = "SELECT PartnerID AS id, PartnerName AS text FROM Ms_Partner ORDER BY PartnerName";
      $query  = $hosting_mas->query($sql);
      $result = $query->result();

      echo json_encode(
        array(
          "status_code" => 200,
          "status"      => "success",
          "message"     => "Data sukses ditampilkan",
          "data"        => $result
        )
      );
    } else {
      echo "main";
    }
  }

  public function get_partner_revisi()
  {
    $hosting_mas    = $this->load->database('hosting_mas', TRUE);
    $id_perusahaan  = $this->input->post('id_perusahaan');
    $id_partner     = $this->input->post('id_partner');

    $sql    = "SELECT * FROM ms_partner_revision 
                WHERE CompanyID = '$id_perusahaan' AND PartnerID = '$id_partner'
                ORDER BY PartnerName";
    $query  =  $hosting_mas->query($sql);
    $cek    = $query->num_rows();
    if ($cek > 0) {
      $result = $query->result();

      echo json_encode(
        array(
          "status_code" => 200,
          "status"      => "success",
          "message"     => "Data revisi sukses ditemukan",
          "data"        => $result
        )
      );
    } else {
      echo json_encode(
        array(
          "status_code" => 404,
          "status"      => "not found",
          "message"     => "Data revisi tidak ditemukan",
          "data"        => array()
        )
      );
    }
  }

  //FUNGSI UPDATE DATA PARTNER
  public function update_data()
  {
    //delete dulu file yang kemarin di upload
    $revisi_no                        = $this->input->post('revisi_no');
    $partner_id                       = $this->input->post('partner_id');

    $sql    = "SELECT * FROM ms_file_upload_partner 
                WHERE PartnerID = '$partner_id' AND revision='$revisi_no'";
    $query  = $this->db->query($sql);
    $cek    = $query->row();

    if ($cek) {
      $nama_file = json_decode($cek->nama_file);
      if ($nama_file != []) {
        foreach ($nama_file as $file_name) {
          $file_path = './upload/partner/' . $file_name; //lokasi file yg berhasil di upload
          if (file_exists($file_path)) {
            unlink($file_path); //hapus file yg berhasil di upload
          }
        }
      }
    }

    // Mendapatkan informasi tanggal dan waktu saat ini
    $date = getdate();

    // Mengambil nilai tahun, bulan, tanggal, jam, dan menit
    $time = sprintf(
      "%04d%02d%02d%02d%02d",
      $date['year'],
      $date['mon'],
      $date['mday'],
      $date['hours'],
      $date['minutes']
    );

    $company_id                       = $this->input->post('company_id');
    $partner_name                     = $this->input->post('partner_name');
    $company_type                     = $this->input->post('company_type');
    $type_partner                     = $this->input->post('type_partner');
    $kontak                           = $this->input->post('kontak');
    $alamat                           = $this->input->post('alamat');
    $kota                             = $this->input->post('kota');
    $negara                           = $this->input->post('negara');
    $fax                              = $this->input->post('fax');
    $telex                            = $this->input->post('telex');
    $no_pkp                           = $this->input->post('no_pkp');
    $tanggal_pkp                      = $this->input->post('tanggal_pkp_real');
    $telepon                          = $this->input->post('telepon');
    $email                            = $this->input->post('email');
    $website                          = $this->input->post('website');
    $npwp                             = $this->input->post('npwp');
    $tempo_pembayaran                 = $this->input->post('tempo_pembayaran');
    $mata_uang_ap                     = $this->input->post('mata_uang_ap');
    $mata_uang_po                     = $this->input->post('mata_uang_po');
    $tipe_pembayaran                  = $this->input->post('tipe_pembayaran');
    $batas_kredit                     = str_replace('.', '', $this->input->post('batas_kredit'));
    $batas_kredit                     = str_replace(',', '.', $batas_kredit);
    $pajak_ppn                        = $this->input->post('pajak_ppn');
    $masa_berlaku_po                  = $this->input->post('masa_berlaku_po');
    $id_pengiriman                    = $this->input->post('id_pengiriman');
    $nama_penerima_pengiriman         = $this->input->post('nama_penerima_pengiriman');
    $alamat_pengiriman                = $this->input->post('alamat_pengiriman');
    $kota_pengiriman                  = $this->input->post('kota_pengiriman');
    $kontak_pengiriman                = $this->input->post('kontak_pengiriman');
    $pajak_pengiriman                 = $this->input->post('pajak_pengiriman');
    $aktif_pengiriman                 = $this->input->post('aktif_pengiriman');
    $telepon_pengiriman               = $this->input->post('telepon_pengiriman');
    $note_pengiriman                  = $this->input->post('note_pengiriman');
    $connection_pengiriman            = $this->input->post('connection_pengiriman');
    $kode_lokasi_pengiriman           = $this->input->post('kode_lokasi_pengiriman');
    $kode_wilayah_pengiriman          = $this->input->post('kode_wilayah_pengiriman');
    $kode_cabang_pengiriman           = $this->input->post('kode_cabang_pengiriman');
    $lokasi_cabang_pengiriman         = $this->input->post('lokasi_cabang_pengiriman');
    $kode_perusahaan_pengiriman_new   = $this->input->post('kode_perusahaan_pengiriman_new');
    $npwp_doc_new                     = $this->input->post('npwp_doc_new');
    $nib_doc_new                      = $this->input->post('nib_doc_new');
    $tdp_doc_new                      = $this->input->post('tdp_doc_new');
    $spkp_doc_new                     = $this->input->post('spkp_doc_new');
    $ktp_directur_doc_new             = $this->input->post('ktp_directur_doc_new');
    $spesimen_ttd_doc_new             = $this->input->post('spesimen_ttd_doc_new');
    $informasi_tambahan             = $this->input->post('informasi_tambahan');


    // Data untuk tabel partner
    $data_partner = array(
      'CompanyID'             => $company_id,
      'RevisionNumber'        => $revisi_no,
      'PartnerID'             => $partner_id,
      'PartnerName'           => $partner_name,
      'Type'                  => $company_type,
      'Address'               => $alamat,
      'City'                  => $kota,
      'Country'               => $negara,
      'Contact'               => $kontak,
      'Phone'                 => $telepon,
      //'Street'                => '',
      //'Block'                 => '',
      //'Number'                => '',
      //'Neighbourhood'         => '',
      //'Hamlet'                => '',
      //'District'              => '',
      //'AdministrativeVillage' => '',
      //'Regency'               => '',
      //'Province'              => '',
      //'Postcode'              => '',
      'Fax'                   => $fax,
      'Email'                 => $email,
      'Website'               => $website,
      'Telex'                 => $telex,
      'NPWP'                  => $npwp,
      'PKPNO'                 => $no_pkp,
      'PKPDATE'               => $tanggal_pkp,
      //'isImport'              => '',
      //'BankAccountName'       => '',
      //'BankAccountNo'         => '',
      //'BankName'              => '',
      //'BankAddress'           => '',
      //'SWIFT'                 => '',
      //'Corresponding'         => '',
      'TypePartner'           => $type_partner,
      'Currency'              => $mata_uang_ap,
      'CurrencyPO'            => $mata_uang_po,
      'PaymentType'           => $tipe_pembayaran,
      'CreditLimit'           => (float)$batas_kredit, ///$batas_kredit,
      'Term'                  => floatval($tempo_pembayaran),
      'ExpiryDay'             => floatval($masa_berlaku_po),
      'TipePPN'               => $pajak_ppn,
      //'Notes'                 => '',
      //'Aktif'                 => '',
      'CreateDate'            => date('Y-m-d H:i:s'),
      'CreateBy'              => $this->session->userdata('user_code'),
      //'CompanyCode'           => 'CKP',
    );

    // Data untuk tabel shipment
    $data_shipment = array(
      'IDHeader'          => '',
      'CompanyID'         => $company_id,
      'RevisionNumber'    => $revisi_no,
      'CustomerID'        => $partner_id,
      'NamaPenerima'      => $nama_penerima_pengiriman,
      'CustomerIDAlamat'  => $id_pengiriman,
      'Alamat'            => $alamat_pengiriman,
      'City'              => $kota_pengiriman,
      'Contact'           => $kontak_pengiriman,
      'Phone'             => $telepon_pengiriman,
      'Keterangan'        => $note_pengiriman,
      'Pajak'             => $pajak_pengiriman,
      'Aktif'             => $aktif_pengiriman,
      'Koneksi'           => $connection_pengiriman,
      'CreateDate'        => date('Y-m-d H:i:s'),
      'CreateBy'          => $this->session->userdata('user_code'),
      'KdLokasi'          => $kode_lokasi_pengiriman,
      'kdWilayah'         => $kode_wilayah_pengiriman,
      'KdCabang'          => $kode_cabang_pengiriman,
      //'KodeKirim'         => '',
      //'AlamatPrint'       => '',
      //'WithCompanyCode'   => '',
      //'CompanyCode'       => ''
    );

    $checkboxes = array(
      'npwp_doc', 'nib_doc', 'tdp_doc', 'sppkp_doc', 'ktp_directur_doc', 'spesimen_ttd_doc'
    );

    $upload_success = true;
    $file_inputs = array();
    $uploaded_files = array(); // Menampung file yang berhasil diupload

    // Lakukan loop untuk setiap checkbox
    foreach ($checkboxes as $checkbox) {
      $ceklis = $this->input->post($checkbox);
      if ($ceklis) {
        $input_file = str_replace('_doc', '_file', $checkbox);
        $file_inputs[] = $input_file;
      }
    }

    // Memuat perpustakaan unggah
    $this->load->library('upload');

    // Konfigurasi upload
    $config['upload_path'] = './upload/partner';
    $config['allowed_types'] = 'png|pdf';
    $config['max_size'] = '4192';


    // Loop untuk setiap file yang akan diunggah
    foreach ($file_inputs as $file_input) {
      // Menetapkan nama baru sesuai dengan nama file yang diunggah
      $file_type           = pathinfo($_FILES[$file_input]['name'], PATHINFO_EXTENSION);
      $new_name            = str_replace('_file', '', $file_input) . '-' . $time . '-' . $partner_id . '-Rev' . $revisi_no;
      $config['file_name'] = $new_name;

      // Mengonfigurasi upload dengan nama file yang baru
      $this->upload->initialize($config);

      // Melakukan unggah file
      if (!$this->upload->do_upload($file_input)) {
        $upload_success = false;
        break; // Hentikan loop jika ada kesalahan unggah
      } else {
        $uploaded_files[] = $new_name . '.' . $file_type;
      }
    }

    // Data untuk tabel file_upload_partner
    $file_upload_partner = array(
      'PartnerID'         => $partner_id,
      'revision'          => $revisi_no,
      'nama_file'         => json_encode($uploaded_files),
      'hapus'             => 'tidak',
      'informasi'         => $informasi_tambahan,
      'created_at'        => date('Y-m-d H:i:s'),
      'created_by'        => $this->session->userdata('user_code'),
    );

    $file_upload_partner_update = array(
      'PartnerID'         => $partner_id,
      'revision'          => $revisi_no,
      'nama_file'         => json_encode($uploaded_files),
      'hapus'             => 'tidak',
      'informasi'         => $informasi_tambahan,
      'updated_at'        => date('Y-m-d H:i:s'),
      'updated_by'        => $this->session->userdata('user_code'),
    );

    // Lakukan aksi berikutnya sesuai dengan keberhasilan upload
    if ($upload_success) {
      $hosting_mas  = $this->load->database('hosting_mas', TRUE);
      $sql    = "SELECT * FROM ms_partner_revision 
        WHERE CompanyID = '$company_id' AND PartnerID = '$partner_id' AND RevisionNumber='$revisi_no'
        ORDER BY PartnerName";

      $query  = $hosting_mas->query($sql);
      $cek    = $query->row();

      if (!$cek) {


        $this->db->trans_start(); // Memulai transaksi

        try {
          $hosting_mas  = $this->load->database('hosting_mas', TRUE);

          // Insert pertama
          $hosting_mas->insert('ms_partner_revision', $data_partner);

          // Insert kedua
          if ($id_pengiriman != null) {
            $hosting_mas->insert('ms_customeralamatkirim_revision', $data_shipment);
          }

          // Insert ketiga
          if ($uploaded_files != null || $informasi_tambahan != '') {
            $this->db->insert('ms_file_upload_partner', $file_upload_partner);
          }

          // Commit transaksi jika semua insert berhasil
          $this->db->trans_complete();

          // Periksa apakah transaksi berhasil atau tidak
          if ($this->db->trans_status() === FALSE) {
            // Jika terjadi kesalahan, rollback transaksi
            $this->db->trans_rollback();

            foreach ($uploaded_files as $file_name) {
              $file_path = './upload/partner/' . $file_name; //lokasi file yg berhasil di upload

              if (file_exists($file_path)) {
                unlink($file_path); //hapus file yg berhasil di upload
              }
            }
            echo json_encode(array("status" => "gagal", "message" => "Gagal update data"));
          } else {
            // Jika semuanya berhasil, commit transaksi
            $this->db->trans_commit();
            echo json_encode(array("status" => "ok"));
          }
        } catch (Exception $e) {
          // Tangkap dan tangani kesalahan
          echo "Terjadi kesalahan: " . $e->getMessage();
          $this->db->trans_rollback(); // Rollback jika terjadi kesalahan
          foreach ($uploaded_files as $file_name) {
            $file_path = './upload/partner/' . $file_name; //lokasi file yg berhasil di upload

            if (file_exists($file_path)) {
              unlink($file_path); //hapus file yg berhasil di upload
            }
          }
          echo json_encode(array("status" => "gagal", "message" => "Gagal update data"));
        }
      } else {

        $this->db->trans_start(); // Memulai transaksi

        try {
          $hosting_mas  = $this->load->database('hosting_mas', TRUE);

          // Insert pertama
          $hosting_mas->update('ms_partner_revision', $data_partner, array('PartnerID' => $partner_id, 'RevisionNumber' => $revisi_no));

          // Insert kedua
          if ($id_pengiriman != null) {
            $sql    = "SELECT * FROM ms_customeralamatkirim_revision 
                        WHERE  CustomerID = '$partner_id' AND RevisionNumber='$revisi_no'";
            $query  = $hosting_mas->query($sql);
            $cek    = $query->row();
            if ($cek) {
              //jika ada update
              $hosting_mas->update('ms_customeralamatkirim_revision', $data_shipment, array('CustomerID' => $partner_id, 'RevisionNumber' => $revisi_no));
            } else {
              //jika tidak ada insert
              $hosting_mas->insert('ms_customeralamatkirim_revision', $data_shipment);
            }
          }

          // Insert ketiga
          if ($uploaded_files != null || $informasi_tambahan != '') {
            $sql    = "SELECT * FROM ms_file_upload_partner 
                        WHERE PartnerID = '$partner_id' AND revision='$revisi_no'";
            $query  = $this->db->query($sql);
            $cek    = $query->row();

            if ($cek) {
              //jika ada update
              $this->db->update('ms_file_upload_partner', $file_upload_partner_update, array('PartnerID' => $partner_id, 'revision' => $revisi_no));
            } else {
              //jika tidak ada insert
              $this->db->insert('ms_file_upload_partner', $file_upload_partner);
            }
          }

          // Commit transaksi jika semua insert berhasil
          $this->db->trans_complete();

          // Periksa apakah transaksi berhasil atau tidak
          if ($this->db->trans_status() === FALSE) {
            // Jika terjadi kesalahan, rollback transaksi
            $this->db->trans_rollback();

            foreach ($uploaded_files as $file_name) {
              $file_path = './upload/partner/' . $file_name; //lokasi file yg berhasil di upload

              if (file_exists($file_path)) {
                unlink($file_path); //hapus file yg berhasil di upload
              }
            }
            echo json_encode(array("status" => "gagal", "message" => "Gagal update data"));
          } else {
            // Jika semuanya berhasil, commit transaksi
            $this->db->trans_commit();
            echo json_encode(array("status" => "ok"));
          }
        } catch (Exception $e) {
          // Tangkap dan tangani kesalahan
          echo "Terjadi kesalahan: " . $e->getMessage();
          $this->db->trans_rollback(); // Rollback jika terjadi kesalahan
          foreach ($uploaded_files as $file_name) {
            $file_path = './upload/partner/' . $file_name; //lokasi file yg berhasil di upload
            if (file_exists($file_path)) {
              unlink($file_path); //hapus file yg berhasil di upload
            }
          }
          echo json_encode(array("status" => "gagal", "message" => "Gagal update data"));
        }
      }
    } else {
      foreach ($uploaded_files as $file_name) {
        $file_path = './upload/partner/' . $file_name; //lokasi file yg berhasil di upload

        if (file_exists($file_path)) {
          unlink($file_path); //hapus file yg berhasil di upload
        }
      }
      echo json_encode(array("status" => "gagal", "message" => "Gagal Upload file, format file harus Png/Pdf"));
    }
  }
}
