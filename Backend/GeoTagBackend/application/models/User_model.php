<?php

/**
 * @author Dejan Ciric 570/15
 * @author Jakov Jezdic 570/15
 * @author Milos Matijasevic 0440/15
 * 
 * User_model - handles all database manipulation regarding statistics
 */
class User_model extends CI_Model {

    // @var object $user
    // used for tracking current session
    public $user;

    // Creating new instance
    // @return void 
    public function __construct() {
        parent::__construct();
        $this->user = NULL;
    }

    // insert new user (new row) in table user
    // @param array $data (represents one row in table user)
    // @return void
    public function insert_user($data) {
        $data['password'] =  password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->insert('user', $data);
    }
    
    // change user status from user to superuser
    // @param string $username
    // @return void
    public function promote_user($username) {   
        
        if ($this->get_status($username)!="user") {return;}
        
        $this->db->set('status', "super_user");
        $this->db->where('username', $username);
        $this->db->update('user');
    }
    
    // get user acording to his username and store it in variable $user
    // return bool is user with that username found or not
    // @param string $username
    // @return boolean
    public function getUser($username) {
        $result = $this->db->where('username', $username)->get('user');
        $user = $result->row();
        if ($user != NULL) {
            $this->user = $user;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    // check if password is valid for current user 
    // return bool is password valid or not
    // @param string $password
    // @return boolean
    public function check_password($password, $username) {
        $this->db->where('username', $username);
        $row = $this->db->get('user')->row();
        if (password_verify($password, $row->password)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // change username in table and in current session
    // @param string $new_username
    // @return void
    public function change_username($new_username) {

        $this->db->set('username', $new_username);
        $this->db->where('username', $this->session->userdata('user')->username);
        $this->db->update('user');
        $this->session->userdata('user')->username = $new_username;
    }

    // change password in table and in current session
    // @param string $new_password
    // @return void
    public function change_password($new_password) {

        $this->db->set('password', password_hash($new_password, PASSWORD_DEFAULT));
        $this->db->where('username', $this->session->userdata('user')->username);
        $this->db->update('user');
        $this->session->userdata('user')->password = $new_password;
    }

    // change profile picture in table and in current session
    // @param string $name
    // @return void
    public function change_photo($name) {

        $data = array(
            'idImg' => '',
            'img' => $name
        );

        $this->db->insert('image', $data);
        $insert_id = $this->db->insert_id();
        $this->db->set('idImg', $this->db->insert_id('image'));
        $this->db->where('username', $this->session->userdata('user')->username);
        $this->db->update('user');
        $this->session->userdata('user')->idImg = $insert_id;
    }

    // get img name by its id if null return default avatar
    // @param string $id
    // @return string
    public function get_img_name($id) {
        $this->db->where('idImg', $id);
        $row = $this->db->get('image')->row();

        if ($row != null)
            return $row->img;
        else {
            return "avatar.png";
        }
    }
    
    // get user img name by username
    // @param string $username
    // @return string
    public function get_img_id($username) {
        $this->db->where('username', $username);
        $this->db->select('idImg');
        $this->db->from('user');
        $result = $this->db->get()->row_array();
        
        return $result['idImg'];
    }
    
    
    // get number of reviews made by user, for user-profile page
    // @param string $username
    // @return int
    public function get_user_review_count($username) {
        $this->db->where('username', $username);
        $this->db->from('review');
        return $this->db->count_all_results();
    }
    
    // get number of places added (and approved) by user, for user-profile page
    // @param string $username
    // @return int
    public function get_user_added_places_count($username) {
        $this->db->where('username', $username);
        $this->db->where('type', 'destination confirm');
        $this->db->from('request');
        return $this->db->count_all_results();
    }
    
    // get sum of all up/down votes on all of the users reviews, for user-profile page
    // @param string $username
    // @return array
    public function up_down_count($username) {
        $this->db->where('username', $username);
        $this->db->select_sum('upCount');
        $this->db->select_sum('downCount');
        $this->db->from('review');
        $result = $this->db->get()->row_array();
        if ($result['upCount'] == NULL) {
            $result['upCount'] = 0;
        }
        if ($result['downCount'] == NULL) {
            $result['downCount'] = 0;
        }
                
        return $result;
    }
    
    // get first and last name of a user, for other-user-profile page
    // @param string $username
    // @return array
    public function get_full_name($username) {
        
        $this->db->where('username', $username);
        $this->db->select('firstname, lastname');
        $this->db->from('user');
        $result = $this->db->get()->row_array();
        
        return $result;
    }
    
    // get gender of a user, for other-user-profile page
    // @param string $username
    // @return string
    public function get_gender($username) {
        $this->db->where('username', $username);
        $this->db->select('gender');
        $this->db->from('user');
        $result = $this->db->get()->row_array();
        
        return $result['gender'];
    }
    
    // get status of a user, for other-user-profile page
    // @param string $username
    // @return string
    public function get_status($username){
        $this->db->where('username', $username);
        $this->db->select('status');
        $this->db->from('user');
        $result = $this->db->get()->row_array();
        
        return $result['status'];
    }
    
    // ??????????
    function search_data($query)
    {
        $this->db->select("*");
        $this->db->from("user");
        if($query != '')
        {
            $this->db->like('username', $query);
            $this->db->or_like('firstname', $query);
            $this->db->or_like('lastname', $query);
            return $this->db->get();

        }

            $this->db->or_like('gender', 123);
            return $this->db->get();
    }
    
    // delete user
    // @param int $user Id of user to be deleted
    // @return void
    public function delete_user($user){
        $this->db->where('username', $user);
        $this->db->delete('user');    
    }
    
}
