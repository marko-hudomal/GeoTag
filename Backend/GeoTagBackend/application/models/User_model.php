<?php

/**
 * @author Dejan Ciric 570/15
 * 
 * UserModel - class that handle all requests for User table
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
        $this->db->insert('user', $data);
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
        if ($row->password == $password) {
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

        $this->db->set('password', $new_password);
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

}
