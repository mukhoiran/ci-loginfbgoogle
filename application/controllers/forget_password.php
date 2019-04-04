<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forget_password extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("password_model");
        $this->load->library('email');
    }

    /**
    Index function called when forget_password controller
    will call and its load forget_view
    */
    public function index() {

        $this->load->view('forget_view');
    }
    
    /**
    Check Password function, first check email is exits or not on database
    if it exits then call send password link function and send success message 
    to forget_view if email not exits send fail message to forget_view
    */
    public function check_password() {
        $this->load->helper('url');
        $email = $this->input->post('email');
        $query = $this->password_model->get_data_by_email($email);

        if ($query->num_rows > 0) {
            $r = $query->result();
            $user = $r[0];
            $this->send_reset_password_link($user, $email);
            $data['info'] = "Password link has has been sent  <br> " . $email . "<br>Please check your email";
            //redirect('/index.php/login/forget?info=' . $info, 'refresh');
        } else {
            $data['error'] = "The email id you entered not found on our database ";
            //redirect('/index.php/login/forget?error=' . $error, 'refresh');
        }
        $this->load->view('forget_view', $data);
    }
    
    /**
    Send reset password link function create a token then insert it on db 
    if it is inserted then make a link by that token,creating email template and
    email subject header and pass that varibale to GlobalMail function
    */
    public function send_reset_password_link($user, $email) {
        $token = md5($email);
        $query = $this->password_model->insert_token($token, $email);

        if ($query == 1) {

            $to = $email;
            $link = $reset_url = base_url() . "forget_password/set_password/" . $token;

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
text-align:center;">For Reset your Password Please Click On Below Link</h2>
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
           " href="' . $link . '" class="fg-button">Reset Password</a></h1>
</div>
</body>
</html>';

            $sub = "FormGet : Loginapp Reset Password";

            $this->GlobalMail($to, $sub, $msg);
            //send email 
        }
    }
    /**
    GlobalMail function send email
    */
    public function GlobalMail($to, $sub = '', $msg = '', $header = '') {

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
    /**
    set password function call when user login their
    email account and click on reset password link
    */
    public function set_password() {
        $token = $this->uri->segment(3);
        $query = $this->password_model->get_id_by_token($token);
        if ($query->num_rows > 0) {
            $r = $query->result();
            $user = $r[0];
            $data['user_id'] = $user->user_id;
            $this->load->view('set_password', $data);
        } else {

            $this->load->view('notvalid');
        }
        
    }
    /**
    Update password function update the passowrd
    */
    public function update_password() {
        $user_password = $this->input->post('password');
        $user_id = $this->input->post('id');
        $result = $this->password_model->update_password($user_password, $user_id);
        if ($result == TRUE) {

            $data['updated_pass'] = "Password updated successfully";

            $this->load->view('forget_view', $data);
        } else {
            $this->load->view('login_view');
        }
    }

}

?>