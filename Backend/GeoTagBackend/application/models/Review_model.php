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
        //User validation
            if (($this->session->userdata('user')) != NULL) {
            $user1 = $this->session->userdata('user')->status;
            }
            else
                $user1 = "guest";
            
        foreach ($query->result() as $row)
        {
            $dest_name=$this->destination_model->get_name($row->idDest);
            
            // u slucaju kada je guest
            if ($this->session->userdata('user') == NULL) {
                $ret=$ret."<div class=\"card\" style=\"margin-top:20px\">
               <div class=\"card-header\">
                  <table width=\"100%\">
                    <tr>
                        <td width=\"70%\"><strong>".$row->username.", ".$dest_name." </strong></td>
                        <td width=\"10%\" align=\"center\" style=\"text-align: right;\"  >

                                <input disabled type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote-dis.png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />

                        </td>
                        <td width=\"5%\" align=\"center\" style=\"padding-bottom: 0px;\">
                             ".$row->upCount."
                        </td>
                        <td width=\"10%\" align=\"center\" style=\"text-align: right\" >

                                <input disabled type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote-dis.png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />

                        </td>
                        <td width=\"5%\" align=\"center\" style=\"padding-bottom: 0px;\">
                            ".$row->downCount."
                        </td>
                    </tr>
                  </table>
               </div>
               <div class=\"card-body\">
                  <i>".$row->content."</i>
               </div>
            </div>";
            }
            
            else {
            
                $ret=$ret."<div class=\"card\" style=\"margin-top:20px\">
                   <div class=\"card-header\">
                      <table width=\"100%\">
                         <tr>
                            <td width=\"70%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a>, ".$dest_name." </strong></td>
                            <td width=\"10%\" align=\"center\" style=\"text-align: right;\"  >
                                <form action=\"".base_url()."index.php/".$user1."/vote_up/".$row->idRev."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                    <input type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote.png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                </form>
                            </td>
                            <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px;\">
                                 ".$row->upCount."
                            </td>
                            <td width=\"10%\" align=\"center\" style=\"text-align: right\" >
                                <form action=\"".base_url()."index.php/".$user1."/vote_down/".$row->idRev."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                    <input type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote.png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                </form>  
                            </td>
                            <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px;\">
                                ".$row->downCount."
                            </td>
                         </tr>
                      </table>
                   </div>
                   <div class=\"card-body\">
                      <i>".$row->content."</i>
                   </div>
                </div>";
            }
        }
        
        return $ret;
    }
    public function get_html_all_reviews($destination_id){
        $ret = "";  
        $query = $this->db->query("SELECT * from review where idDest=".$destination_id." ORDER BY idRev DESC");
        //User validation
        if (($this->session->userdata('user')) != NULL) {
            $user1 = $this->session->userdata('user')->status;
        }
        else
            $user1 = "guest";
            
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
            if ($this->session->userdata('user') == NULL) {
                $ret=$ret." <div class=\"card\" style=\"margin-top:20px;overflow:auto;\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                    <td width=\"70%\"><strong>$row->username</a> </strong></td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: center;\"  >
                                         
                                            <input disabled  type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote-dis.png\" width=\"40px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                         
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 0px; text-align:left\">
                                         ".$row->upCount."
                                    </td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: center\" >
                                         
                                            <input disabled  type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote-dis.png\" width=\"40px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                          
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 0px; text-align:left\">
                                        ".$row->downCount."
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
            else{
                if (($this->session->userdata('user')->username==$row->username))
                {
                    $ret=$ret." <div class=\"card\" style=\"margin-top:20px\">
                            <div class=\"card-header\" style=\"overflow:auto\">
                               <table width=\"100%\">
                                  <tr>
                                    <td width=\"60%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a> </strong></td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: right;\"  >
                                         
                                            <input disable type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote-dis.png\" width=\"35px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                       
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 0px;\">
                                         ".$row->upCount."
                                    </td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: right\" >
                                        
                                            <input disable type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote-dis.png\" width=\"35px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                          
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 0px;\">
                                        ".$row->downCount."
                                    </td>
                                     <td width=\"10\" style=\"padding-bottom: 0px;\">
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
                }else
                {
                    $ret=$ret." <div class=\"card\" style=\"margin-top:20px;overflow:auto;\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                    <td width=\"70%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a> </strong></td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: center;\"  >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_up/".$row->idRev."/".$destination_id."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote.png\" width=\"40px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                        </form>
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px; text-align:left\">
                                         ".$row->upCount."
                                    </td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: center\" >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_down/".$row->idRev."/".$destination_id."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote.png\" width=\"40px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                        </form>  
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px; text-align:left\">
                                        ".$row->downCount."
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
 
            }
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
                            <div class=\"card-header\" style=\"overflow:auto\">
                               <table width=\"100%\">
                                  <tr>
                                    <td width=\"60%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a> </strong></td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: right;\"  >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_up/".$row->idRev."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote.png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                        </form>
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px;\">
                                         ".$row->upCount."
                                    </td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: right\" >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_down/".$row->idRev."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote.png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                        </form>  
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px;\">
                                        ".$row->downCount."
                                    </td>
                                     <td width=\"10\" style=\"padding-bottom: 15px;\">
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
