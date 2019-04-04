<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

     // Facebook OAuth Crediential
        private $appId = "2359875784248843";
        private $secret = "432e1d55af7320dcdef6ca308dadb669";

     // Google OAuth Crediential
        private $client_id = '791682562559-31fu80ugk4a22gh7pmsj2pibi51o2l7l.apps.googleusercontent.com';
        private $client_secret = '84RGN4jX88dghxoEMCXuCxCe';
        private $redirect_uri = 'http://localhost:8012/ci_loginapp_fb_google/login/google_login';
        private $simple_api_key = 'AIzaSyBVsFekXxArH6jLhnfwo9Ptjq-nwm6hvlQ';

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('loginapp_model');
        $this->load->helper('cookie');
        $this->load->library('email');

        session_start();
        // Load facebook library and pass associative array which contains appId and secret key
        $this->load->library('facebook', array('appId' => $this->appId, 'secret' => $this->secret));
    }

    public function index() {
       //call back browser function
        $this->back_browser();
       //call autologin function
        $this->autologin();

            if (isset($_GET['p']) && $_GET['p'] == 'popup') {
                $error =  array('error' => '');
                $this->load->view('login_view', $error);
            } elseif (isset($_GET['p']) && $_GET['p'] == 'entry') {
                  $error =  array('error' => '');
                $this->load->view('login_view', $error);
            } else {
                  $error =  array('error' => '');
                $this->load->view('login_view', $error);
            }

    }

    public function facebook_login(){
           $data = $this->facebook_oauth();

              // If already user login in facebook, it pass the user profile values, which get from facebook id.
        if(isset($data['fb_login_url'])){
          header('Location:' .$data['fb_login_url']);
        }
        if (isset($data['user_email'])) {
            $user_fb_data = array(
                'user_picture' => $data['user_picture'],
                'user_name' => $data['user_name'],
                'user_email' => $data['user_email'],
                'logout_url' => $data['logout_url']
            );

            //checking email id exists or not in database
            $data = $this->loginapp_model->user_email_check($user_fb_data['user_email']);
            isset($data[0]) ? $check_email = trim(strtolower($data[0]->user_email)) : $check_email = '';

            //if not exists then save on db
            if ($check_email != $user_fb_data['user_email']) {
                $insert_fb_data = array(
                    'user_name' => $user_fb_data['user_name'],
                   'user_email' => $user_fb_data['user_email'],
                     'is_active' => 1
                    );
                // Sucess New User Registration
                $new_user = $this->loginapp_model->new_user_registration($insert_fb_data);
            }
              // if exit save all data in session and view home page
                    $this->session->set_userdata($user_fb_data);
                    $this->session->all_userdata();
                    $this->home();
        }
    }

    public function google_login(){

        $data = $this->google_oauth();

        if(isset($data['authUrl'])){
          header('Location:' .$data['authUrl']);
        }

        //get google oauth userdata
        if (isset($data['userData'])) {

            $user_name = $data['userData']->given_name . " " . $data['userData']->family_name;
            $user_email = $data['userData']->email;
            $user_picture = $data['userData']->picture;
            $user_google_data = array(
                'user_picture' => $user_picture,
                'user_name' => $user_name,
                'user_email' => $user_email
            );

            //checking email id exists or not in database
            $data = $this->loginapp_model->user_email_check($user_google_data['user_email']);
            isset($data[0]) ? $check_email = trim(strtolower($data[0]->user_email)) : $check_email = '';

            //if not exists then save on db
            if ($check_email != $user_google_data['user_email']) {

                $insert_google_data = array(
                    'user_name' => $user_name,
                    'user_email' => $user_email,
                     'is_active' => 1

                );
                // Sucess New User Registration
                $new_user = $this->loginapp_model->new_user_registration($insert_google_data);
            }
            //set user data to session
            $this->session->set_userdata($user_google_data);
            $this->session->all_userdata();
            $this->home();
        }

    }

     // Log In via Facebook.
    public function facebook_oauth() {
        $facebook_user = "";
        // Get user's login information
        $facebook_user = $this->facebook->getUser();



        if (isset($_GET['error_reason']) && $_GET['error_reason'] == 'user_denied') {
            header('Location:'.  base_url());
        } else {

        if ($facebook_user) {
            $user_profile = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
            $data['user_email'] = $user_profile['email'];
            $data['user_name'] = $user_profile['first_name'];
            $data['user_picture'] = "https://graph.facebook.com/" . $user_profile['id'] . "/picture";
            $data['logout_url'] = $this->facebook->getLogoutUrl(array('next' => base_url() . 'login/logout'));
        } else {
            $data['fb_login_url'] = $this->facebook->getLoginUrl(array(
                'scope' => 'email,public_profile'

            ));
        }
        }
        return $data;
    }

    //Google OAuth Function
    public function google_oauth() {

        // Include google-php-client library in controller
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

        // Store values in variables from project created in Google Developer Console
        $client_id = $this->client_id;
        $client_secret = $this->client_secret;
        $redirect_uri = $this->redirect_uri;
        $simple_api_key = $this->simple_api_key;

        // Create Client Request to access Google API
        $client = new Google_Client();
        $client->setApplicationName("PHP Google OAuth Login Example");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");

        // Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);

        // Add Access Token to Session
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

        // Set Access Token to make Request
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        }

        // Get User Data from Google and store them in $data
        if ($client->getAccessToken()) {
            $userData = $objOAuthService->userinfo->get();
            $data['userData'] = $userData;
            $_SESSION['access_token'] = $client->getAccessToken();
        }  else {
            $authUrl = $client->createAuthUrl();
            $data['authUrl'] = $authUrl;
            $this->load->view('login_view', $data);
            exit;
        }
        return $data;

    }

    //For new User Registration and verification
    public function user_registration() {

        //set validtion and xss clean
        $this->load->library('form_validation');
        $this->form_validation->set_rules('uname', 'Full Name', 'required|min_length[3]|max_length[25]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[25]');

        //Checking form validtion if true then getting posted data  by user
        if ($this->form_validation->run() === TRUE) {

            //get value from submitted data
            $user_reg_data = array(
                'user_name' => trim($this->input->post('uname')),
                'user_email' => trim(strtolower($this->input->post('email'))),
                'user_password' => md5($this->input->post('password'))
            );

            //checking email id exists or not in database
            $data = $this->loginapp_model->user_email_check($user_reg_data['user_email']);
            isset($data[0]) ? $check_email = trim(strtolower($data[0]->user_email)) : $check_email = '';

            //if not exists then save on db
            if ($check_email != $user_reg_data['user_email']) {

                // Sucess New User Registration
                $new_user = $this->loginapp_model->new_user_registration($user_reg_data);
                if ($new_user == TRUE) {

                    $this->send_account_varification_link($user_reg_data['user_name'], $user_reg_data['user_email']);
                }
            }
            //send error msg on registration panel for email id already exists
            else {
                $error_message = array('alert_message' => $user_reg_data['user_email'] . " : already exists",'email_already_flag' => '1');
                $this->load->view('login_view', $error_message);
            }
        }
        //Send error message on registration panel for form validation
        else {
            $error_message = array('alert_message' => " All Field is required");
            $this->load->view('login_view', $error_message);
        }
    }

    //Send  user account  activation link
    public function send_account_varification_link($user_name, $user_email) {

        $to = $user_email;
        $encode_user_name = $this->base64_url_encode($user_name);
        $encode_user_email = $this->base64_url_encode($user_email);

        //Create a link for accoution activation
        $link = base_url() . 'login/email_activation/' . $encode_user_name . "/" . $encode_user_email;

        //Designing a template for email
        $msg = '<html xmlns="http://www.w3.org/1999/xhtml">
          <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="css/text">.fg-button{
                padding: 20px 40px 20px 36px;
                color: #fff;

                font-size: 22px;
                border-radius: 4px;

                text-decoration: none;
                background-color: #1BC7F2;
                webkit-box-shadow: 0 3px 0 #2477BF;
                -moz-box-shadow: 0 3px 0 #2477BF;
                box-shadow: 0 3px 0 #2477BF;

            }
            .fg-button:hover{
                background:  #1cd2ff;
				color:white;
            }</style>
</head>
<body>
<div style="width:800px;
height:200px;
background-color:#eeeeee;
margin:0 auto;">
<h2 style="padding:20px;
text-align:center;">For Account Activation  Please Click On Below Link</h2>
<h1 style="padding:20px;
text-align:center;"><a  style="
                padding: 20px 40px 20px 36px;
                color: #fff;
                font-size: 22px;
                border-radius: 4px;

                text-decoration: none;
                background-color: #1BC7F2;
                webkit-box-shadow: 0 3px 0 #2477BF;
                -moz-box-shadow: 0 3px 0 #2477BF;
                box-shadow: 0 3px 0 #2477BF;
           " href="' . $link . '" class="fg-button">Active Your Account</a></h1>
</div>
</body>
</html>';

        //Subject for email
        $sub = "FormGet : Loginapp Account Activation";

        //Calling email sending function
        $this->GlobalMail($to, $sub, $msg);

        $this->load->view('email_verification');
    }

    function GlobalMail($to, $sub = '', $msg = '', $header = '') {

        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('noreply@formget.com', $header);
        $this->email->reply_to('noreply@formget.com', 'noreply@formget.com');
        $this->email->to($to);
        $this->email->subject($sub);
        $this->email->message($msg);
        $this->email->send();
    }

    // For email Activation
    public function email_activation() {
        $user_email = $this->uri->segment(4);
        $decode_user_email = $this->base64_url_decode($user_email);
        $data = $this->loginapp_model->set_is_active($decode_user_email);
        if ($data == TRUE) {
            $this->load->view('email_activation');
        } else {
            header('Location:' . base_url() . 'login');
        }
    }

    public function login_check() {

        //get value from submitted data
        $user_login_data = array(
            'remember' => $this->input->post('remember'),
            'user_email' => trim(strtolower($this->input->post('email'))),
            'user_password' => md5($this->input->post('password'))
        );

        $data = $this->loginapp_model->login_get($user_login_data['user_email'], $user_login_data['user_password']);


        foreach ($data as $row) {
            $user_id = $row->user_id;
            $user_name = $row->user_name;
            $is_active = $row->is_active;
            $user_email = $row->user_email;
        }

        if (isset($user_id) && isset($user_name)) {
            $user_data = array(
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_email' => $user_email
            );

            if ($is_active == 1) {
                $this->loginapp_model->update_client_ip($user_data['user_email']);
                $this->session->set_userdata($user_data);

                $arr = $this->session->all_userdata();
                $u_data = serialize(array("user_id" => $arr['user_id'], "user_name" => $arr["user_name"], "user_email" => $arr["user_email"]));

                //create cookies
                if ($user_login_data['remember'] == "true") {


                    $cookie_email = array(
                        'name' => 'user_email',
                        'value' => $user_email,
                        'expire' => '31572500',
                    );

                    $cookie_name = array(
                        'name' => 'user_name',
                        'value' => $user_name,
                        'expire' => '31572500',
                    );
                    $cookie_id = array(
                        'name' => 'user_id',
                        'value' => $user_id,
                        'expire' => '31572500',
                    );

                    $this->input->set_cookie($cookie_email);
                    $this->input->set_cookie($cookie_name);
                    $this->input->set_cookie($cookie_id);
                }


                header('Location:' . base_url() . 'login/home');
            } else {
                $error = array('error' => 'Your account is not active');
                $this->load->view('login_view', $error);
            }
            // popup changes end
        } else {
            $error = array('error' => 'Username and Password NOT Found');
            $this->load->view('login_view', $error);
        }
    }

    //loding home view
    public function home() {
        $this->back_browser();

        $user_email = $this->session->userdata('user_email');
        $res = $this->loginapp_model->get_user_name($user_email);

        foreach ($res as $row) {
            $data['user_name'] = $row->user_name;
            $data['contact_no'] = $row->contact_no;
            $data['address'] = $row->address;
        }

        $this->load->view('home', $data);
    }

    //loading profile view
    public function profile() {
        $this->back_browser();
        $user_email = $this->session->userdata('user_email');
        $res = $this->loginapp_model->get_user_name($user_email);
        foreach ($res as $row) {
            $data['user_name'] = $row->user_name;
            $data['contact_no'] = $row->contact_no;
            $data['address'] = $row->address;
        }

        $this->load->view('profile', $data);
    }

    //logout and destroy the session value
    public function logout() {
        $newdata = array(
            'user_name' => '',
            'user_email' => '',
            'user_id' => '',
        );

        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        delete_cookie("user_email");
        delete_cookie("user_id");
        delete_cookie("user_name");
        unset($_SESSION['access_token']);
        session_destroy();
        header('Location:' . base_url() . 'login');
    }

    public function update_password() {

        $user_email = $this->session->userdata('user_email');
        $oldpassword = ($this->input->post('oldpassword'));
        $newpassword = ($this->input->post('newpassword'));
        $confirmpassword = ($this->input->post('confirmpassword'));

        $data['msg'] = $this->loginapp_model->updatepassword($user_email, $oldpassword, $newpassword, $confirmpassword);
        $res = $this->loginapp_model->get_user_name($user_email);
        foreach ($res as $row){
            $data['user_name'] = $row->user_name;
            $data['contact_no'] = $row->contact_no;
            $data['address'] = $row->address;
        }
        $this->load->view('profile', $data);
    }

    public function update_details() {
        $user_email = $this->session->userdata('user_email');
        $data = array(
            'user_name' => $this->input->post('full_name'),
            'contact_no' => $this->input->post('mobile_number'),
            'address' => $this->input->post('address')
        );
        $data['user_detail'] = $this->loginapp_model->update_details_db($user_email, $data);
        $this->load->view('profile', $data);
    }

    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '+_-');
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '+_-', '+/='));
    }

    public function autologin() {

        $user_email = $this->input->cookie('user_email', true);
        $user_name = $this->input->cookie('user_name', true);
        $user_id = $this->input->cookie('user_id', true);

        if (!empty($user_email) && !empty($user_name)) {

            $user_data = array(
                'user_email' => $user_email,
                'user_name' => $user_name,
                'user_id' => $user_id,
            );

            $this->session->set_userdata($user_data);

            $arr = $this->session->all_userdata();
            $u_data = serialize(array("user_id" => $arr['user_id'], "user_name" => $arr["user_name"], "user_email" => $arr["user_email"]));

            header('Location:' . base_url() . 'login/home');
        }
    }

    //Making sure a web page is not cached, across all browsers
    public function back_browser() {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
    }

}
