<?php

/**
 * Description of UserModel
 *
 * @author Dejan
 */
class User_model extends CI_Model{
    
    public $user;
    
     public function __construct() {
        parent::__construct();
        //$this->autor=NULL;
    }
    
    public function insert_user($data){
        $this->db->insert('user',$data);
    }
    
    public function getUser($email){
        $result=$this->db->where('email',$email)->get('user');
        $user=$result->row();
        if ($user!=NULL) {
            $this->user=$user;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function check_password($password){
        if ($this->user->password == $password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}