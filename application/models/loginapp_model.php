<?php

class loginapp_model extends CI_Model {

    //check reg email id on db or not
    public function user_email_check($uemail) {
        $this->db->select('user_email');
        $this->db->where('user_email', $uemail);
        $query = $this->db->get('users');
        $data = $query->result();
        return $data;
    }

    //Insert New User Registration Data
    public function new_user_registration($user_reg_data) {
        $this->db->insert('users', $user_reg_data);
        return TRUE;
    }

    //set the email id is valid.
    public function set_is_active($user_email) {
        $this->db->where('user_email', $user_email);
        $query = $this->db->update('users', array('is_active' => 1));
        return TRUE;
    }

    public function login_get($email, $password) {
        $this->db->select('user_id,user_name,is_active,user_email');
        $this->db->where('user_email', $email);
        $this->db->where('user_password', $password);
        $query = $this->db->get('users');
        $data = $query->result();
        return $data;
    }

    //geting new added user id 
    public function get_new_user_id() {
        $this->db->select_max('user_id');
        $u_id = $this->db->get('users');
        return $u_id->result();
    }

    //update the password by account settings
    public function updatepassword($user_email, $oldpassword, $newpassword, $confirmpassword) {
        $this->db->select('user_password');
        $this->db->where('user_email', $user_email);
        $res = $this->db->get('users');
        $res = $res->result();
        $data = '';
        if (isset($res[0]->user_password)) {
            $oldp = $mark_as = $res[0]->user_password;
            // echo md5($oldpassword);
            //echo"<br>";
            // echo $res[0]->user_password;
            if (md5($oldpassword) != $oldp) {
                $data = "not";
            } elseif ($newpassword != $confirmpassword) {
                $data = "notconfirm";
            } else {
                $this->db->where('user_email', $user_email);
                $this->db->update('users', array('user_password' => (md5($newpassword))));
                $data = "updated";
            }
            return $data;
        }
    }

    public function get_name_id_for_cookies($email, $password) {
        $this->db->select('user_id,user_name');
        $where = "(user_email='$email')and(user_password='$password')";
        $this->db->where($where);
        $query = $this->db->get('users');
        $login_res = $query->result();
        if ((isset($login_res[0]->user_id) && $login_res[0]->user_id != '')) {
            $userid_send = $login_res[0]->user_id;
            $send_arr = array(
                'user_id' => $userid_send,
                'user_email' => $email
            );
            // $this->insert_active_login($send_arr, $userid_send);
        }
        return $login_res;
    }

    //update the Details by account settings
    public function update_details_db($user_email, $data) {
        $this->db->where('user_email', $user_email);
        $result = $this->db->update('users', $data);
        if ($result == 1) {
            return 'true';
        } else {
            return 'false';
        }
    }

    // Get user name from database using email id.

    public function get_user_name($email_id) {
        $this->db->select('*');
        $where = "(user_email='$email_id')";
        $this->db->where($where);
        $query = $this->db->get('users');
        $data = $query->result();

        return $data;
    }

    public function send_mail_for_new_password_model($f_email) {
        $this->db->select('user_id,user_name,user_email,user_verification');
        $this->db->where('user_email', $f_email);
        $mail_data = $this->db->get('users');
        return $mail_data->result();
    }
     
    function update_client_ip($user_email) {
       $ip_address = $this->get_client_ip();
       $this->db->where('user_email', $user_email);
       $query = $this->db->update('users', array('ip_address' => $ip_address));
       return TRUE;
   }

   function get_client_ip() {
       $ipaddress = '';
       if (getenv('HTTP_CLIENT_IP'))
           $ipaddress = getenv('HTTP_CLIENT_IP');
       else if (getenv('HTTP_X_FORWARDED_FOR'))
           $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
       else if (getenv('HTTP_X_FORWARDED'))
           $ipaddress = getenv('HTTP_X_FORWARDED');
       else if (getenv('HTTP_FORWARDED_FOR'))
           $ipaddress = getenv('HTTP_FORWARDED_FOR');
       else if (getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
       else if (getenv('REMOTE_ADDR'))
           $ipaddress = getenv('REMOTE_ADDR');
       else
           $ipaddress = 'UNKNOWN';
       return $ipaddress;
   }

}


?>