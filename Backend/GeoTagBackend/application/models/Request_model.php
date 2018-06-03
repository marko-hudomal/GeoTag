<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request_model
 *
 * @author User
 */
class Request_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->model("destination_model");
        $this->load->model("review_model");
        $this->load->model("user_model");
    }
    
    public function insert($type, $id)
    {   
        
        $new_request['idRev'] = NULL;
        $new_request['idDest'] = NULL;
        $new_request['username'] = NULL;
        switch($type){
            case "destination added":
                $new_request['type'] = $type;
                $new_request['idDest'] = $id;
                //$new_request['username'] = $username; //Hudi odkomentarisao
                break;
            case "negative review":
                $new_request['type'] = $type;
                $new_request['idRev'] = $id;
                //$new_request['username'] = $username; //Hudi odkomentarisao
                break;
            case "user promotion":
                $new_request['username'] = $id;
                $new_request['type'] = $type;
                break;
        }
        
        $this->db->insert('request', $new_request); 
        
    }
    
    public function delete($request_id)
    {
        $this->db->where('idReq', $request_id);
        $this->db->delete('request');
    }
    
    public function get_request($id){
        $query = $this->db->query("select * from request where idReq=".$id);
        return $query->result()[0];
    }
    
    public function get_html_all_requests()
    {
        $ret = "";  
        $query = $this->db->query("SELECT * from request ORDER BY idReq DESC");
        
        foreach ($query->result() as $row)
        {
            $dest_name="";
            switch ($row->type) {
            case "destination added":
                $dest=$this->destination_model->get_destination($row->idDest);
                
                $req_content="<strong>Destination: </strong>".$dest->name.", ".$dest->country."<hr>"."(Long: ".$dest->longitude.", Lat: ".$dest->latitude.")";
                $button_func="<i>Add destination?</i>";
                break;
            case "negative review":
                $rev = $this->review_model->get_review($row->idRev);
                $dest= $this->destination_model->get_destination($rev->idDest);
                
                $req_content="<strong>Destination: </strong>".$dest->name.", ".$dest->country."<hr>"."<Strong>Up/Down vote: </strong>".$rev->upCount."/".$rev->downCount."<hr><strong>Text: </strong><br>".$rev->content;
                $button_func="<i>Delete review?</i>";
                break;
            case "user promotion":
                $status=$this->user_model->get_status($row->username);
                $req_content="<strong>Username: </strong>".$row->username."<hr> <strong>Status: </strong>".$status; 
                $button_func="<i>Promote to SuperUser?</i>";
                break;
            default:
                $req_content="Request type unknown..";
                $button_func="";
                break;
            }
            //User validation
            if (($this->session->userdata('user')) != NULL) {
            $user1 = $this->session->userdata('user')->status;
            }
            else
                $user1 = "guest";
            
            $ret=$ret."<div class=\"card\" style=\"margin-top:20px\">
                                <div class=\"card-header\">
                                    <table style=\"width:100%;\">
                                        <tr>
                                            <td rowspan=\"2\"><strong>$row->username</strong></td>
                                            <td rowspan=\"2\" style=\"text-align:right\">$button_func</td>
                                            <form action=\"".base_url()."index.php/".$user1."/approve_request/".$row->idReq."\" method=\"PUT\" >
                                                <td style=\"text-align: right;\"><button type=\"submit\" class=\"btn btn-success btn-sm\">Approve</button> </td>
                                            </form>
                                         </tr>
                                         <tr>
                                            <form action=\"".base_url()."index.php/".$user1."/dismiss_request/".$row->idReq."\" method=\"PUT\" >
                                                <td style=\"text-align: right;\"><button type=\"submit\" class=\"btn btn-danger btn-sm\">Dismiss</button> </td>
                                            </form>
                                        </tr>
                                    </table>
                                </div>
                                <div class=\"card-body\">
                                    <p><strong>Type: </strong>".$row->type."</p><hr>
                                    <p>".$req_content."</p>
                                </div>
                       </div>";        
        }
        
        return $ret;
    }
    
}
