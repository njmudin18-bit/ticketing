<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checking_model extends CI_Model
{
    var $_table = 'tbl_user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        $this->load->helper(array('cookie', 'url'));
    }
  
    //check login from other apps
    public function check_username($email)
    {
        $query          = $this->db->get_where('tbl_user', array('email_pegawai' => $email));
        $success        = $query->num_rows();
        $successData    = $query->row();
        
        //JIKA EMAIL DITEMUKAN
        if ($success > 0) {
            if ($successData->aktivasi == 'Aktif') {
                //tambahan 20231016
                $dept_id    = $successData->dept_id;
                $this->db->where('id', $dept_id);
                $query      = $this->db->get('tbl_department');
                $cek        = $query->num_rows();
                
                if ($cek > 0) {
                    $result     = $query->row();
                    $nama_dept  = $result->nama_dept;
                } else {
                    $nama_dept  = "Nama dept belum terdaftar";
                }
                //tambahan 20231016 
                
                $dataLogin =  array(
                    'user_id'         => $successData->id,
                    'user_code'       => $successData->id,
                    'user_dept_id'    => $successData->dept_id,
                    'user_dept_name'  => $nama_dept,
                    'user_nip'        => $successData->nip,
                    'user_name'       => $successData->username,
                    'user_realName'   => $successData->nama_pegawai,
                    'user_perusahaan' => $successData->perusahaan,
                    'user_level'      => $successData->user_level,
                    'user_email'      => $successData->email_pegawai,
                    'user_valid'      => true
                );
                
                $this->session->set_userdata($dataLogin);
                //SET COOKIE
                set_cookie('company_id', $successData->perusahaan, '2592000');
                //GET TANGGAL SEKARANG
                $now = date('Y-m-d H:i:s');
                
                //UPDATE TABLE USER AND SET LAST LOGIN
                $update = $this->db->query("UPDATE tbl_user SET last_login = '$now' WHERE id = '" . $successData->id . "'");
                
                return 30;
            } else {
                return 20; //USERNAME DI BLOCK
            }
        } else {
            return 0; //DATA TIDAK DITEMUKAN
        }
    }
    
    public function check_username_and_token($email, $token)
    {
        $query          = $this->db->get_where('tbl_user', array('email_pegawai' => $email, 'tokens' => $token));
        $cek_email      = $query->num_rows();
        $now            = date('Y-m-d H:i:s');
        if($cek_email > 0) {
            $result         = $query->row();
            $expired_time   = $result->expired_time;
            $exp            = strtotime($expired_time);
            $today          = strtotime($now);
            
            if($today > $exp) {
                return "expired";
            } else {
                $successData    = $query->row();
                if ($successData->aktivasi == 'Aktif') {
                    //tambahan 20231016
                    $dept_id    = $successData->dept_id;
                    $this->db->where('id', $dept_id);
                    $query      = $this->db->get('tbl_department');
                    $cek        = $query->num_rows();
                    
                    if ($cek > 0) {
                        $result = $query->row();
                        $nama_dept = $result->nama_dept;
                    } else {
                        $nama_dept = "Nama dept belum terdaftar";
                    }
                    //tambahan 20231016 
                    
                    $dataLogin =  array(
                        'user_id'         => $successData->id,
                        'user_code'       => $successData->id,
                        'user_dept_id'    => $successData->dept_id,
                        'user_dept_name'  => $nama_dept,
                        'user_nip'        => $successData->nip,
                        'user_name'       => $successData->username,
                        'user_realName'   => $successData->nama_pegawai,
                        'user_perusahaan' => $successData->perusahaan,
                        'user_level'      => $successData->user_level,
                        'user_email'      => $successData->email_pegawai,
                        'user_valid'      => true
                    );
                    
                    $this->session->set_userdata($dataLogin);
                    //SET COOKIE
                    set_cookie('company_id', $successData->perusahaan, '2592000');
                    //GET TANGGAL SEKARANG
                    $now = date('Y-m-d H:i:s');
                    //UPDATE TABLE USER AND SET LAST LOGIN
                    $update = $this->db->query("UPDATE tbl_user SET last_login = '$now' WHERE id = '" . $successData->id . "'");
                    
                    return "success";
                } else {
                    return "block";
                }
            }
        } else {
            return "not registered";
        }
    }
}