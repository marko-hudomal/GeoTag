<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Review_model
 *
 * @author User
 */
class Review_model  extends CI_Model{
    
    // @var object $user
    // used for tracking current session
    public $review;

    // Creating new instance
    // @return void 
    public function __construct() {
        parent::__construct();
        $this->user = NULL;
    }

    public static function get_html_last_n_reviews()
    {
        $ret = "daa";  
//        $query = $this->db->query("SELECT * from review ORDER BY idRev DESC LIMIT 10");
//
//        foreach ($query->result() as $row)
//        {
//            $ret+="<p>.$row->idRev.</p>";
//        }
        
        return ret;
    }
}
