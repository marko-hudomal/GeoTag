<?php

/**
 * @author User
 * Vote_model - handles all database manipulation regarding votes
 */
class Vote_model extends CI_Model {
     public function __construct() {
        parent::__construct();
    }
    
    // get vote type for user on a specific review if it exists
    // @param string $username, int $review_id
    // @return int Vote type [-1,0,1]
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
