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

    
    public function delete($review_id)
    {
        $this->db->where('idRev', $review_id);
        $this->db->delete('review');
    }
    public function get_html_last_n_reviews()
    {
        $N=10;
        $ret = "";  
        $query = $this->db->query("SELECT * from review ORDER BY idRev DESC LIMIT ".$N);

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
            $image_src=$this->get_img_name($row->idImg);
            if ($image_src!="")
            {
                $rew_img="<img src=\"".base_url()."uploads/".$image_src."\" alt=\"Destination image\" style=\" border-radius:5px;width:100px; margin-left:20px;margin-right:10px\">";
            }else
            {
                $rew_img="";
            }
            $ret=$ret." <div class=\"card\" style=\"margin-top:20px;\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                     <td width=\"76%\"><strong>".$row->username." </strong></td>
                                     <td width=\"12%\"><a href=\"#\"><img src=\"".base_url()."img/plus-vote.png\" width=\"30px\"></a>&nbsp;".$row->upCount."
                                     <td width=\"12%\"><a href=\"#\"><img src=\"".base_url()."img/minus-vote.png\" width=\"30px\"></a>&nbsp;".$row->downCount."
                                  </tr>
                               </table>
                            </div>
                            <div class=\"card-body\" >
                                <div class=\"media\" >
                                    ".$rew_img."
                                    <div class=\"media-body\" style=\"overflow:auto;\">
                                      <i>".$row->content."</i>
                                    </div>
                                </div>
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
            $image_src=$this->get_img_name($row->idImg);
            if ($image_src!="")
            {
                $rew_img="<img src=\"".base_url()."uploads/".$image_src."\" alt=\"Destination image\" style=\" border-radius:5px;width:100px; margin-left:20px;margin-right:10px\">";
            }else
            {
                $rew_img="";
            }
            
            
            //User validation
            if (($this->session->userdata('user')) != NULL) {
            $user1 = $this->session->userdata('user')->status;
            }
            else
                $user1 = "guest";
            
            $ret=$ret." <div class=\"card\" style=\"margin-top:20px\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                     <td width=\"70%\"><strong>".$row->username." </strong></td>
                                     <td width=\"10%\"><a href=\"#\"><img src=\"".base_url()."img/plus-vote.png\" width=\"30px\"></a>&nbsp;".$row->upCount."</td>
                                     <td width=\"10%\"><a href=\"#\"><img src=\"".base_url()."img/minus-vote.png\" width=\"30px\"></a>&nbsp;".$row->downCount."</td>
                                     <td width=\"10\">
                                        <form action=\"".base_url()."index.php/".$user1."/delete_review/".$destination_id."/".$row->idRev."\" method=\"PUT\" >
                                            <input type=\"submit\" value=\"Delete Review\" class=\"float-right btn btn-outline-danger\">
                                        </form>
                                     </td>
                                    </tr>
                               </table>
                            </div>
                           <div class=\"card-body\" >
                                <div class=\"media\" >
                                    ".$rew_img."
                                    <div class=\"media-body\" style=\"overflow:auto;\">
                                      <i>".$row->content."</i>
                                    </div>
                                </div>
                            </div>
                        </div>";
        }
        
        return $ret;
    }
    public function get_img_name($id) {
        $this->db->where('idImg', $id);
        $row = $this->db->get('image')->row();

        if ($row != null)
            return $row->img;
        else {
            return "";
        }
    }
    public function get_review($id){
        $query = $this->db->query("select * from review where idRev=".$id);
        return $query->result()[0];
    }
    public function insert_review($data){
        
        $this->db->insert('review', $data);
    }  
    
    
    //dodaje novu sliku i vraca njen id
    public function add_photo($name){
        $data = array(
            'idImg' => '',
            'img' => $name
        );

        $this->db->insert('image', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    

}
