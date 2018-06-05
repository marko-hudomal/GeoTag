<?php

/**
 * @author Jakov Jezdic 0043/2015
 * Review_model - handles all database manipulation regarding reviews
 */

// promotion requirement constants
define("UP_VOTE_PROMO", 10);
define("DOWN_VOTE_PROMO_PERCENT", 0.2);
define("NEG_REV_PER", 2);
define("NEG_REV_LIMIT", 15);

class Review_model  extends CI_Model{
    
    // @var object $user
    // used for tracking current session
    public $review;

    // Creating new instance
    // @return void 
    public function __construct() {
        parent::__construct();
        $this->load->model("destination_model");
        $this->load->model("request_model");
        $this->load->model("vote_model");
        $this->load->model("user_model");
    }

    // delete review by id
    // @param id $review_id
    // @return void
    public function delete($review_id)
    {
        $this->db->where('idRev', $review_id);
        $this->db->delete('review');
    }
    
    // get latetest reviews, which will be previewed on home page
    // @return string $ret HTML code of latest reviews
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
                //Vote disable----------------------------------------------------------------------------------------------------
                //**BITNO: SLEDECE VREDNOSTI KONTROLISU DA LI JE DUGME AKTIVIRANO ILI NE
                $disable_vote_pic_plus="";
                $disable_vote_plus="";
                $disable_vote_pic_minus="";
                $disable_vote_minus="";
                if (($this->session->userdata('user')->username==$row->username)) {$disable_vote_pic_plus="-dis";$disable_vote_plus="disabled";$disable_vote_pic_minus="-dis";$disable_vote_minus="disabled";}
                if ($this->vote_model->get_vote_status($this->session->userdata('user')->username,$row->idRev)==1){$disable_vote_pic_plus="-dis";$disable_vote_plus="disabled";}
                if ($this->vote_model->get_vote_status($this->session->userdata('user')->username,$row->idRev)==-1){$disable_vote_pic_minus="-dis";$disable_vote_minus="disabled";}
                //----------------------------------------------------------------------------------------------------------------
                $ret=$ret."<div class=\"card\" style=\"margin-top:20px\">
                   <div class=\"card-header\">
                      <table width=\"100%\">
                         <tr>
                            <td width=\"70%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a>, <a href='".base_url()."index.php/".$this->session->userdata('user')->status."/load_dest/".$row->idDest."'>".$dest_name."</a> </strong></td>
                            <td width=\"10%\" align=\"center\" style=\"text-align: right;\"  >
                                <form action=\"".base_url()."index.php/".$user1."/vote_up/".$row->idRev."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                    <input ".$disable_vote_plus." type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote".$disable_vote_pic_plus.".png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                </form>
                            </td>
                            <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px;\">
                                 ".$row->upCount."
                            </td>
                            <td width=\"10%\" align=\"center\" style=\"text-align: right\" >
                                <form action=\"".base_url()."index.php/".$user1."/vote_down/".$row->idRev."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                    <input ".$disable_vote_minus." type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote".$disable_vote_pic_minus.".png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
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
    
    // get all reviews for destination
    // @param int $destination_id
    // @return string $ret HTML code of destination reviews
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
                    //Vote disable----------------------------------------------------------------------------------------------------
                    //**BITNO: SLEDECE VREDNOSTI KONTROLISU DA LI JE DUGME AKTIVIRANO ILI NE
                    $disable_vote_pic_plus="";
                    $disable_vote_plus="";
                    $disable_vote_pic_minus="";
                    $disable_vote_minus="";
                    if (($this->session->userdata('user')->username==$row->username)) {$disable_vote_pic_plus="-dis";$disable_vote_plus="disabled";$disable_vote_pic_minus="-dis";$disable_vote_minus="disabled";}
                    if ($this->vote_model->get_vote_status($this->session->userdata('user')->username,$row->idRev)==1){$disable_vote_pic_plus="-dis";$disable_vote_plus="disabled";}
                    if ($this->vote_model->get_vote_status($this->session->userdata('user')->username,$row->idRev)==-1){$disable_vote_pic_minus="-dis";$disable_vote_minus="disabled";}
                    //----------------------------------------------------------------------------------------------------------------
                    $ret=$ret." <div class=\"card\" style=\"margin-top:20px;overflow:auto;\">
                            <div class=\"card-header\">
                               <table width=\"100%\">
                                  <tr>
                                    <td width=\"70%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a> </strong></td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: center;\"  >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_up/".$row->idRev."/".$destination_id."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input ".$disable_vote_plus." type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote".$disable_vote_pic_plus.".png\" width=\"40px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                        </form>
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px; text-align:left\">
                                         ".$row->upCount."
                                    </td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: center\" >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_down/".$row->idRev."/".$destination_id."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input ".$disable_vote_minus." type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote".$disable_vote_pic_minus.".png\" width=\"40px\" border=\"0\" alt=\"Submit\" style=\"\" />
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
    
    // get all reviews for destination, admin specific
    // @param int $destination_id
    // @return string $ret HTML code of destination reviews
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
            
            //Vote disable----------------------------------------------------------------------------------------------------
            //**BITNO: SLEDECE VREDNOSTI KONTROLISU DA LI JE DUGME AKTIVIRANO ILI NE
            $disable_vote_pic_plus="";
            $disable_vote_plus="";
            $disable_vote_pic_minus="";
            $disable_vote_minus="";
            if (($this->session->userdata('user')->username==$row->username)) {$disable_vote_pic_plus="-dis";$disable_vote_plus="disabled";$disable_vote_pic_minus="-dis";$disable_vote_minus="disabled";}
            if ($this->vote_model->get_vote_status($this->session->userdata('user')->username,$row->idRev)==1){$disable_vote_pic_plus="-dis";$disable_vote_plus="disabled";}
            if ($this->vote_model->get_vote_status($this->session->userdata('user')->username,$row->idRev)==-1){$disable_vote_pic_minus="-dis";$disable_vote_minus="disabled";}
            //----------------------------------------------------------------------------------------------------------------
            $ret=$ret." <div class=\"card\" style=\"margin-top:20px\">
                            <div class=\"card-header\" style=\"overflow:auto\">
                               <table width=\"100%\">
                                  <tr>
                                    <td width=\"60%\"><strong><a href='".base_url()."index.php/".$this->session->userdata('user')->status."/preview_other_user/".$row->username."'>".$row->username."</a> </strong></td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: right;\"  >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_up/".$row->idRev."/".$destination_id."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input ".$disable_vote_plus." type=\"image\" name=\"submit\" src=\"".base_url()."img/plus-vote".$disable_vote_pic_plus.".png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
                                        </form>
                                    </td>
                                    <td width=\"5%\" align=\"center\" style=\"padding-bottom: 15px;\">
                                         ".$row->upCount."
                                    </td>
                                    <td width=\"10%\" align=\"center\" style=\"text-align: right\" >
                                        <form action=\"".base_url()."index.php/".$user1."/vote_down/".$row->idRev."/".$destination_id."\" method=\"PUT\" style=\"padding-top: 0px;\">
                                            <input ".$disable_vote_minus." type=\"image\" name=\"submit\" src=\"".base_url()."img/minus-vote".$disable_vote_pic_minus.".png\" width=\"30px\" border=\"0\" alt=\"Submit\" style=\"\" />
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
    
    // get image name by its id
    // @param int $id Image id
    // @return string
    public function get_img_name($id) {
        $this->db->where('idImg', $id);
        $row = $this->db->get('image')->row();

        if ($row != null)
            return $row->img;
        else {
            return "";
        }
    }
    
    // get review by it's id
    // @param int $id 
    // @return review as array
    public function get_review($id){
        $query = $this->db->query("select * from review where idRev=".$id);
        return $query->result()[0];
    }
    
    // insert review
    // @param array $data Array containing all fields from Review table
    // @return void
    public function insert_review($data){
        $this->db->insert('review', $data);
    }  
    
    
    // add image
    // @param string $name Image name
    // @return int $insert_id Id of added image
    public function add_photo($name){
        $data = array(
            'idImg' => '',
            'img' => $name
        );

        $this->db->insert('image', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    // update vote count on a review and possibly generate requests
    // @param int $id Review id, string $field Field in review table to be updated ['upCount'/'downCount'], string $username Username of user who voted
    // @return void
    public function update_vote_count($id, $field, $username) {
        
        
        if ($field == 'upCount'){
            $opposite_field = 'downCount';
            $type = 1;
        }
        else {
            $opposite_field = 'upCount';
            $type = -1;
        }
        
        $this->db->where('username', $username);
        $this->db->where('idRev', $id);
        $this->db->from('vote');
        $result = $this->db->get()->row_array();
        
        if ($result == NULL || $result['type'] == $type*(-1)) {
            
            // user hasn't voted on this review OR has voted differently
            // update voteCount
            $this->db->set($field, $field."+1", FALSE);
            $this->db->where('idRev', $id);
            $this->db->update('review');
            
            if ($result['type'] == $type*(-1)) {
                // update oppositeVoteCount
                $this->db->set($opposite_field, $opposite_field."-1", FALSE);
                $this->db->where('idRev', $id);
                $this->db->update('review');
                
                // change vote type in vote table
                $this->db->set('type', $type);
                $this->db->where('idRev', $id);
                $this->db->where('username', $username);
                $this->db->update('vote');
                
                // possibly generate request for 'user promotion' OR 'negative review'
                $this->generate_requests($id, $type);
            }
            else {
                //insert new vote table
                $newvote['username'] = $username;
                $newvote['idRev'] = $id;
                $newvote['type'] = $type;
                $this->db->insert('vote', $newvote);
                
                // possibly generate request for 'user promotion' OR 'negative review'
                $this->generate_requests($id, $type, $username);
            }
            
        }
        else {
            //user voted on this review
            
        }
    }
    
    // generate 'user promotion' request when upVoteCount for user is > 10 AND downVoteCount is less than 20% of upVoteCount
    // generate 'negative review' request when downVoteCount for request is 2 * upVoteCount AND totalVoteCount > 15
    // @param int $id Review id, int $type 1 when upVoted, -1 when downVoted
    // @return void
    public function generate_requests($id, $type) {
        
        // get review author
        $this->db->where('idRev', $id);
        $this->db->select('username');
        $this->db->from('review');
        $result = $this->db->get()->row_array();

        $username = $result['username'];
        
        if ($type == 1) {
        // USER_PROMO
        
            // PROMO only available for regular users
            if ($this->user_model->get_status($username) == 'user') {
                $this->db->where('username', $username);
                $this->db->select_sum('upCount');
                $this->db->select_sum('downCount');
                $result = $this->db->get('review')->row_array();

                if ($result['upCount'] > UP_VOTE_PROMO && $result['downCount'] < (DOWN_VOTE_PROMO_PERCENT * $result['upCount'])) {
                    // create request if it doesn't already exist

                    $this->db->where('username', $username);
                    $this->db->where('type', 'user promotion');
                    $this->db->from('request');
                    if ($this->db->count_all_results() == 0) {
                        $this->request_model->insert('user promotion', NULL, $username);
                    }
                }
            }
        }
        else {
        // NEG_REVIEW
            // get votes for review
            $this->db->where('idRev', $id);
            $this->db->select('upCount');
            $this->db->select('downCount');
            $this->db->from('review');
            $result = $this->db->get()->row_array();
            
            if ($result['downCount'] >= ($result['upCount'] * NEG_REV_PER) && ($result['downCount'] + $result['upCount']) > NEG_REV_LIMIT) {
                // create request if it doesn't already exist
                
                $this->db->where('idRev', $id);
                $this->db->where('username', $username);
                $this->db->where('type', 'negative review');
                $this->db->from('request');
                if ($this->db->count_all_results() == 0) {
                    $this->request_model->insert('negative review', $id, $username);
                }
            }
        } 
    }
}
