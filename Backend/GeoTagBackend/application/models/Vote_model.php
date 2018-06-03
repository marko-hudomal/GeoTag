<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vote_model
 *
 * @author User
 */
class Vote_model extends CI_Model {
     public function __construct() {
        parent::__construct();
    }
    
    public function get_vote_status($username,$review_id)
    {
        $this->db->where('username', $username);
        $this->db->where('idRev', $review_id);
        $this->db->from('vote');
        $result = $this->db->get()->row_array();
        if ($result==NULL) {return 0;}
        return $result['type'];     
    }
}
