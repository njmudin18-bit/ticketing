<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
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
   * @see https://codeigniter.com/userguide3/general/urls.html
   */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model', 'auth');
        $this->load->model('checking_model', 'checking');
        $this->load->model('perusahaan_model', 'perusahaan');
        
        //START ADD THIS FOR USER ROLE MANAGMENT
        $this->contoller_name  = $this->router->class;
        $this->function_name   = $this->router->method;
        //END
    }

    public function index()
    {
        $remember           = get_cookie("remember");
        $email              = get_cookie("email");
        $company            = get_cookie("company_id");
        $data['remember']   = $remember == 'remember-me' ? 'checked' : '';
        $data['email']      = $email == '' ? '' : $email;
        $data['company_id'] = $company;
        $data['perusahaan'] = $this->perusahaan->get_details();
        $this->load->view('welcome_message', $data, FALSE);
    }

    public function login_proses()
    {
        $recaptchaResponse  = trim($this->input->post('g-recaptcha-response'));
        $userIp             = $this->input->ip_address();
        $secret             = $this->config->item('secret_key');
        
        $url    = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $status = json_decode($output, true);
        
        if ($status['success']) {
            //CEK DATA APAKAH ADA
            $data['email']    = htmlspecialchars($this->input->post('email'));
            $data['password'] = htmlspecialchars($this->input->post('password'));
            $remember_me      = htmlspecialchars($this->input->post('remember-me'));
            if ($remember_me == 'remember-me') {
                set_cookie('email', $this->input->post('email'), '2592000');
                set_cookie('remember', $this->input->post('remember-me'), '2592000');
            } else {
                delete_cookie('email');
                delete_cookie('remember');
            }
            
            $res      = $this->auth->islogin($data);
            $params   = array();
            
            if ($res == 0) {
                $params = array(
                    "status_code"   => 404,
                    "status"        => "not found",
                    "message"       => "Email tidak ditemukan!",
                    "url"           => null
                );
                echo json_encode($params);
            } elseif ($res == 10) {
                $params = array(
                    "status_code"   => 400,
                    "status"        => "error",
                    "message"       => "Email atau password salah!",
                    "url"           => null
                );
                
                echo json_encode($params);
            } elseif ($res == 20) {
                $params = array(
                    "status_code"   => 401,
                    "status"        => "error",
                    "message"       => "Username anda di block!",
                    "url"           => null
                );
                
                echo json_encode($params);
            } elseif ($res == 30) {
                $params = array(
                    "status_code"   => 200,
                    "status"        => "success",
                    "message"       => "Login sukses",
                    "url"           => base_url() . "adminx"
                );
                
                echo json_encode($params);
            };
        } else {
            $params = array(
                "status_code" => 400,
                "status"       => "error",
                "message"     => "Harap centang captcha",
                "url"          => null
            );
            
            echo json_encode($params);
        }
        
        array_push($params, array(
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        ));
        
        //ADDING TO LOG
        $log_url    = base_url() . $this->contoller_name . "/" . $this->function_name;
        $log_type   = "LOGIN | TICKETING APPS";
        $log_data   = json_encode($params);
        
        log_helper($log_url, $log_type, $log_data);
        //END LOG
    }
    
    public function login_with_token() 
    {
        $token              = $this->uri->segment(3);
        $email              = $this->uri->segment(4);
        $now                = date('Y-m-d H:i:s');
        $data['perusahaan'] = $this->perusahaan->get_details();
        
        $query              = $this->db->get_where('tbl_user', array('email_pegawai' => $email, 'tokens' => $token));
        $cek_email          = $query->num_rows();
        if($cek_email > 0) {
            $result         = $query->row();
            $expired_time   = $result->expired_time;
            $exp            = strtotime($expired_time);
            $today          = strtotime($now);
            
            if($today > $exp) {
                $data['status_code']    = "500";
                $data['status']         = "error";
                $data['titles']         = "Link Expired";
                $data['message']        = "The link you followed has expired, please go back to your first App. or log in with your E-Ticketing account.";
                
                $this->load->view('link_expired', $data, FALSE);
            } else {
                $data['status_code']    = "200";
                $data['status']         = "success";
                $data['titles']         = "Sign in";
                $data['emails']         = $email;
                $data['tokens']         = $token;
                $data['message']        = "The link you followed still active.";
                
                $this->load->view('link_active', $data, FALSE);
            }
        } else {
            $data['status_code']    = "500";
            $data['status']         = "error";
            $data['titles']         = "Not Registered";
            $data['message']        = "Username or token is not registered, please go back to your first App. or log in with your E-Ticketing account.";
            
            $this->load->view('link_expired', $data, FALSE);
        }
    }
    
    public function login_with_email_and_token() 
    {
        $email    = htmlspecialchars($this->input->post('email'));
        $token    = htmlspecialchars($this->input->post('token'));
        $res      = $this->checking->check_username_and_token($email, $token);
        $params   = array();
        if ($res == 'not registered') {
            $params = array(
                "status_code"   => 404,
                "status"        => "error",
                "message"       => "Email dan token tidak ditemukan!",
                "url"           => null
            );
            
            echo json_encode($params);
        } elseif ($res == 'expired') {
            $params = array(
                "status_code"   => 500,
                "status"        => "error",
                "message"       => "Token sudah expired.",
                "url"           => null
            );
            
            echo json_encode($params);
        } elseif ($res == 'expired') {
            $params = array(
                "status_code"   => 500,
                "status"        => "error",
                "message"       => "Username diblock, silahkan hubungi administrator.",
                "url"           => null
            );
            
            echo json_encode($params);
        } elseif ($res == 'success') {
            $params = array(
                "status_code"   => 200,
                "status"        => "success",
                "message"       => "Login sukses",
                "url"           => base_url() . "adminx"
            );
            echo json_encode($params);
        };
    }
  
    // check login username from other apps
    public function check_username_from_other_apps() 
    {
        $method = $this->input->method(TRUE);
        if ($method == 'POST') {
            //GET AND SET USER & PASS FROM CURL
            $username = $this->input->server('PHP_AUTH_USER');
            $password = $this->input->server('PHP_AUTH_PW');
            
            if ($username == 'njmudin@omas-mfg.com' && $password == '$2y$10$PUqxZ.VazFVo7yiSnS6PQOpDrgaAkNb7Sd5VRtS2qCiINDnMRJXRK') {
                
                $email    = htmlspecialchars($this->input->post('email'));
                $res      = $this->checking->check_username($email);
                $params   = array();
                if ($res == 0) {
                    $params = array(
                        "status_code"   => 404,
                        "status"        => "not found",
                        "message"       => "Email tidak ditemukan!",
                        "url"           => null
                    );
                    
                    echo json_encode($params);
                } elseif ($res == 10) {
                    $params = array(
                        "status_code"   => 400,
                        "status"        => "error",
                        "message"       => "Email atau password salah!",
                        "url"           => null
                    );
                    
                    echo json_encode($params);
                } elseif ($res == 20) {
                    $params = array(
                        "status_code"   => 401,
                        "status"        => "error",
                        "message"       => "Username anda di block!",
                        "url"           => null
                    );
                    
                    echo json_encode($params);
                } elseif ($res == 30) {
                    
                    $string = "0123456789qwertzuioplkjhgfdsayxcvbnmABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $string = str_shuffle($string);
                    $string = substr($string, 0, 100);
                    
                    $update = $this->db->query("UPDATE tbl_user SET tokens = '$string', expired_time = DATE_ADD(NOW(), INTERVAL 10 MINUTE)
                                                WHERE email_pegawai = '$email'");
                    $url = base_url()."welcome/login_with_token/$string/$email";
                    
                    $params = array(
                        "status_code"   => 200,
                        "status"        => "success",
                        "message"       => "Login sukses",
                        "url"           => $url
                    );
                    echo json_encode($params);
                };
            } else {
                echo json_encode(
                    array(
                        "status_code"   => 401,
                        "status"        => "Unauthorized",
                        "message"       => "Restricted data",
                        "data"          => array()
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "status_code"   => 405,
                    "status"        => "Error",
                    "message"       => "Method Not Allowed",
                    "data"          => array()
                )
            );
        }
    }
    
    public function sitemap()
	{
		$this->load->view('sitemap');
	}
}