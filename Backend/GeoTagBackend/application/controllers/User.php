<?php

/**
 * @author Dejan Ciric 570/15
 * @author Jakov Jezdic 0043/15
 * @author Milos Matijasevic 0440/15
 * 
 * User - handles all requests for classic registered user 
 * 
 */
class User extends CI_Controller {
    
    // Creating new instance
    // @return void 
    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("destination_model");
        $this->load->model("statistic_model");
        $this->load->model("review_model");
        // check if user is already logged in, or if unauthorized access through the link
        if (($this->session->userdata('user')) != NULL  && $this->session->userdata('remember') == true) {
            switch ($this->session->userdata('user')->status ) {
              
               
                case "super_user":
                    redirect("super_user");
                case "admin":
                    redirect("admin");
            }
        }
        $phpArray = $this->destination_model->get_all_destinations();
        ?>
<script type="text/javascript">var jArray =<?php echo json_encode($phpArray); ?>;</script>
<?php
    }

    // default function, load default views
    // and add all information reading from database on load here
    // @return void
    public function index() {
        
        $data['profile_pic'] = $this->get_img_name();
        $data['last_reviews_html'] = $this->review_model->get_html_last_n_reviews();
        $data['page'] = 'guest_home';
        $this->load->view("templates/user_header.php", $data);
        $this->load->view("guest_home.php", $data);
        $this->load->view("templates/footer.php");
    }

    // delete review for specific destination
    // @param int $destination_id, int $review_id
    // @return void
    public function delete_review($destination_id, $review_id){
        
        //Brisanje reviewa
        $this->review_model->delete($review_id);      
        $this->load_dest($destination_id);
    }
    
    // load different views for user and can pass different messages to the view
    // and add all information reading from database on load here
    // @param string $page, string $message, array $data
    // @return void
    public function load($page, $message = null,$data=null) {
        
        $info['profile_pic'] = $this->get_img_name();
        $data['last_reviews_html'] = $this->review_model->get_html_last_n_reviews();
        
        $info['page'] = $page;
        
        if ($message){
            $info['message'] = $message;
            if ($data!=null)
                $data = $data + $info;
        }
            
        
        //print_r($data);
        $this->load->view("templates/user_header.php", $info);
        $this->load->view($page . ".php", $data);
        $this->load->view("templates/footer.php");
    }

    // logout function, breaks session
    // @return void
    public function logout() {
        
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        redirect("Guest");
    }

    // form check and forward request to coresponding model
    // @return void
    public function change_username() {
        
        $this->form_validation->set_rules("usernameChange", "Username", "trim|required|min_length[4]|max_length[20]|is_unique[user.username]");
        $this->form_validation->set_rules("oldPass1", "Old password", "trim|required|min_length[4]|max_length[20]");
        if ($this->form_validation->run()) {
            $new_username = $this->input->post('usernameChange');
 if (!$this->User_model->check_password($this->input->post('oldPass1'),$this->session->userdata('user')->username)) {
                $this->preview_profile("Wrong old password!");
            } else {
            $this->User_model->change_username($new_username);
            
            $this->preview_profile("Successfully changed username");
            }
        } else {
            $this->preview_profile();
        }
    }

    // form check and forward request to coresponding model
    // @return void
    public function change_password() {
       
        $this->form_validation->set_rules("oldPass", "Old password", "trim|required|min_length[4]|max_length[20]");
        $this->form_validation->set_rules("newPass1", "New password", "trim|required|min_length[4]|max_length[20]");
        $this->form_validation->set_rules("newPass2", "Confirm new password", "trim|required|min_length[4]|max_length[20]|matches[newPass1]");
        if ($this->form_validation->run()) {
            $new_password = $this->input->post('newPass1');

            if (!$this->User_model->check_password($this->input->post('oldPass'),$this->session->userdata('user')->username)) {
                $this->preview_profile("Wrong old password");
            } else {
                $this->User_model->change_password($new_password);
                $this->preview_profile("Successfully changed password");
            }
        } else {
            $this->preview_profile();
        }
    }

    // upload new photo to uploads folder in GeoTag, persist it's name to table
    // and later use path for display
    // @return void
    public function do_upload() {
       
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('pic')) {
            $message = $this->upload->display_errors();
            
            $this->preview_profile($message);
        } else {
            $this->User_model->change_photo($this->upload->data()['file_name']);
            $this->preview_profile("Successfully changed photo");
        }
    }

    // get img name by its id if null return default avatar
    // @return string
    public function get_img_name() {

        $path = $this->User_model->get_img_name($this->session->userdata('user')->idImg);

        if ($path == "avatar.png")
            return base_url() . "img/avatar.png";
        else {
            return base_url() . "uploads/" . $path;
        }
    }
    
    // loading statistics view by wrapping statistic model call to acces data
    // @return void
    public function getStatistics(){

        
        $statistics['userCount']=0;
        $statistics['reviewCount']=0;
        $statistics['destinationCount']=0;
        $statistics['positiveVoteCount']=0;
        $statistics['negativeVoteCount']=0;

        $statistics=$this->statistic_model->getStatistics();


        $data['date']=$statistics->date;
        $data['userCount']=$statistics->userCount;
        $data['reviewCount']=$statistics->reviewCount;
        $data['destinationCount']=$statistics->destinationCount;
        $data['positiveVoteCount']=$statistics->positiveVoteCount;
        $data['posReviews']=$statistics->posReviews;
        $this->load("guest_statistics",null,$data);
    }
    
    // search destinations
    // @return void
    public function search(){
        
        $output = '';
        $query = '';
		
        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
        $data = $this->destination_model->search_data($query);
        $output .= '
        <div class="table-responsive">
            <table class="table bg-light">';
        if($data->num_rows() > 0)
        {
            foreach($data->result() as $row)
            {
                $output .= '
                    <tr>
                        <td><a href="'.base_url().'index.php/user/load_dest/'.$row->idDest.'">'.$row->name.'</a></td>
                        <td>'.$row->country.'</td>    
                    </tr>
                ';
            }
        }
        else
        {
            $output .= '<tr>

                                    </tr>';
        }
        $output .= '</table>';
        echo $output;
    }
    
    // search users
    // @return void
    public function search_people(){
        
        $output = '';
        $query = '';

        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
        $data = $this->User_model->search_data($query);
        $output .= '
        <div class="table-responsive">
            <table class="table bg-light">';
        if($data->num_rows() > 0)
        {
            foreach($data->result() as $row)
            {
                $output .= '
                    <tr>
                            <td><a href="'.base_url().'index.php/user/preview_other_user/'.$row->username.'">'.$row->firstname.'</a></td>
                            <td>'.$row->lastname.'</td>    
                    </tr>';
            }
        }
        else
        {
            $output .= '<tr>

                                    </tr>';
        }
        $output .= '</table>';
        echo $output;
    }
    
    // load destination view, wraps destination model and default user load calls
    // in order to preview destination page with neccessary data
    // @param int $id, string $message
    // @return void
    public function load_dest($id, $message=null){
         
       $data['dest_name'] = $this->destination_model->get_name($id);
       $data['dest_country'] = $this->destination_model->get_country($id);
       $data['all_reviews_current_destination_html'] = $this->review_model->get_html_all_reviews($id);
       $data['dest_id']=$id;
       $data['message']=$message;
       $data['image']=null;
       $data['image']=$this->destination_model->get_image($id);
       
       $this->load("destination",null,$data);
    }
    
    
    // add review for specific destination and reload destination page
    // @param int $id Destination id
    // @return void
    public function add_review($id){
        
        $this->form_validation->set_rules("comment", "Comment", "trim|required|min_length[2]|max_length[255]");
        
        $data['content']="";
        if ($this->form_validation->run()) {
            $data['content'] = $this->input->post('comment');  
            
            $data['upCount']=0;
            $data['downCount']=0;

            date_default_timezone_set("Europe/Belgrade");
            $now = new DateTime();
            $date=$now->format('Y-m-d');

            $data['date']=$date;
            $data['username']=$this->session->userdata('user')->username;
            $data['idImg']=null;
            $data['idDest']=$id;
            
            
            
            if (isset($_FILES['pic']) && $_FILES['pic']['error'] != UPLOAD_ERR_NO_FILE) {
                
            
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1000;
                $config['max_width'] = 2048;
                $config['max_height'] = 1024;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('pic')) {
                    $message = (string)$this->upload->display_errors();
                   
                    $this->load_dest($id,$message);
                    return;
                } else {
                    $data['idImg']=$this->review_model->add_photo($this->upload->data()['file_name']);
                }
            
            }
            
            $this->statistic_model->updateStatistics('reviewCount');

            $this->review_model->insert_review($data);
             
            $this->load_dest($id);
        } else {
            $this->load_dest($id);
        }
        
    }
    
    // loads user profile view with needed data
    // @param string $message
    // @return void
    public function preview_profile($message = "") {
        
        $data['review_count'] = $this->User_model->get_user_review_count($this->session->userdata('user')->username);
        $data['places_count'] = $this->User_model->get_user_added_places_count($this->session->userdata('user')->username);
        
        
        $up_down_count = $this->User_model->up_down_count($this->session->userdata('user')->username);
        $data['up_count'] = $up_down_count['upCount'];
        $data['down_count'] = $up_down_count['downCount'];
        
        $this->load('profile', $message, $data);
    }
    
    // loads other users profile with needed data
    // @param int $other Other user id
    // @return void
    public function preview_other_user($other) {
        
        if ($other != $this->session->userdata('user')->username){
            $data['review_count'] = $this->User_model->get_user_review_count($other);
            $data['places_count'] = $this->User_model->get_user_added_places_count($other);


            $up_down_count = $this->User_model->up_down_count($other);
            $data['up_count'] = $up_down_count['upCount'];
            $data['down_count'] = $up_down_count['downCount'];
            
            $full_name = $this->User_model->get_full_name($other);
            $data['firstname'] = $full_name['firstname'];
            $data['lastname'] = $full_name['lastname'];
            $data['username'] = $other;
            
            $gender = $this->User_model->get_gender($other);
            $data['gender'] = $gender;
            
            $img_id = $this->User_model->get_img_id($other);
            $img_name = $this->User_model->get_img_name($img_id);
            
            
            if ($img_name == "avatar.png")
                $profile_pic = base_url() . "img/avatar.png";
            else {
                $profile_pic =  base_url() . "uploads/" . $img_name;
            }
            $data['profile_pic'] = $profile_pic;
            
            $status = $this->User_model->get_status($other);
            $data['status'] = $status;
            
            $this->load("profile_other", null, $data);
        }
        else
            $this->preview_profile();
    }
    
    // register vote up on a specific review
    // reload destination view
    // @param int $review_id, int $destination_id
    // @return void
    public function vote_up($review_id, $destination_id=null) {
        
        $this->review_model->update_vote_count($review_id, "upCount", $this->session->userdata('user')->username);
        
        if ($destination_id==null)
        {
            $this->index();
        }else
            $this->load_dest($destination_id);
    }
    
    // register vote down on a specific review
    // reload destination view
    // @param int $review_id, int $destination_id
    // @return void
    public function vote_down($review_id, $destination_id=null) {
        
        $this->review_model->update_vote_count($review_id, "downCount", $this->session->userdata('user')->username);
        
        if ($destination_id==null)
        {
            $this->index();
        }else
            $this->load_dest($destination_id);
    }
}
