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
    public function check_password($password) {
        if ($this->user->password == $password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
