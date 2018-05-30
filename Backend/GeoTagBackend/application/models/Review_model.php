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
        $this->load->model("destination_model");
    }

    public function get_html_last_n_reviews()
    {
        $ret = "";  
        $query = $this->db->query("SELECT * from review ORDER BY idRev DESC LIMIT 10");

        foreach ($query->result() as $row)
        {
            $dest_name=$this->destination_model->get_name($row->idDest);
            $ret=$ret."<div class=\"card\" style=\"margin-top:20px\">
               <div class=\"card-header\">
                  <table width=\"100%\">
                     <tr>
                        <td width=\"74%\"><strong>".$row->username.", ".$dest_name." </strong></td>
                        <td width=\"13%\" align=\"center\"><a href=\"#\"><img src=\"".base_url()."img/plus-vote.png\" width=\"20px\"></a>&nbsp;".$row->upCount."
                        <td width=\"13%\" align=\"center\"><a href=\"#\"><img src=\"".base_url()."img/minus-vote.png\" width=\"20px\"></a>&nbsp;".$row->downCount."
                     </tr>
                  </table>
               </div>
               <div class=\"card-body\">
                  <i>".$row->content."</i>
               </div>
            </div>";
        }
        
        return $ret;
    }
    public function get_html_all_reviews($destination_id){
        $ret = "";  
        $query = $this->db->query("SELECT * from review where idDest=".$destination_id." ORDER BY idRev DESC");
        foreach ($query->result() as $row)
        {            
           
            $ret=$ret." <div class=\"card\" style=\"margin-top:20px\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                     <td width=\"76%\"><strong>".$row->username." </strong></td>
                                     <td width=\"12%\"><a href=\"#\"><img src=\"".base_url()."img/plus-vote.png\" width=\"30px\"></a>&nbsp;".$row->upCount."
                                     <td width=\"12%\"><a href=\"#\"><img src=\"".base_url()."img/minus-vote.png\" width=\"30px\"></a>&nbsp;".$row->downCount."
                                  </tr>
                               </table>
                            </div>
                            <div class=\"card-body\">
                               <i>".$row->content."</i>
                            </div>
                        </div>";
        }
        
        return $ret;
    }
    public function get_html_all_reviews_admin($destination_id){
        $ret = "";  
        $query = $this->db->query("SELECT * from review where idDest=".$destination_id." ORDER BY idRev DESC");
        foreach ($query->result() as $row)
        {            
           
            $ret=$ret." <div class=\"card\" style=\"margin-top:20px\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                     <td width=\"70%\"><strong>".$row->username." </strong></td>
                                     <td width=\"10%\"><a href=\"#\"><img src=\"".base_url()."img/plus-vote.png\" width=\"30px\"></a>&nbsp;".$row->upCount."
                                     <td width=\"10%\"><a href=\"#\"><img src=\"".base_url()."img/minus-vote.png\" width=\"30px\"></a>&nbsp;".$row->downCount."
                                     <td width=\"10\"><input type=\"button\" value=\"Delete Review\" class=\"float-right btn btn-outline-danger\">
                                  </tr>
                               </table>
                            </div>
                            <div class=\"card-body\">
                               <i>".$row->content."</i>
                            </div>
                        </div>";
        }
        
        return $ret;
    }

}
