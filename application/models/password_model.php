<?php

class password_model extends CI_Model {

    public function get_data_by_email($email) {

        $this->db->select('*');
        $where = "(user_email='$email')";
        $this->db->where($where);
        $query = $this->db->get('users');
        return $query;
    }

    public function insert_token($token, $email) {
        $this->db->where('user_email', $email);
        $query = $this->db->update('users', array('token' => $token));
        return $query;
    }

    public function check_token($user_id) {
        $this->db->select('password_token');
        $this->db->where('user_id', $user_id);
        $token = $this->db->get('users');
        return $token->result();
    }

    public function get_id_by_token($token) {
        $this->db->select('*');
        $where = "(token='$token')";
        $this->db->where($where);
        $query = $this->db->get('users');
        return $query;
    }
    
    public function update_password($user_password,$user_id){ 
        $this->db->where('user_id', $user_id);
        $this->db->update('users', array('user_password' => (md5($user_password)), 'token' => (1)));
        return TRUE;
        
    }

}

?>