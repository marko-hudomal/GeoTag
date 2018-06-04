<?php

/**
 * @author Dejan Ciric 570/15
 * @author Jakov Jezdic 0043/15
 * Super_user - class that handle all requests for super user 
 * and for more privileged users if they use the same actions
 */
class Super_user extends CI_Controller {
    
    // Creating new instance
    // @return void 
    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("destination_model");
        $this->load->model("request_model");
        $this->load->model("statistic_model");
        $this->load->model("review_model");
        
        // check if user is already logged in, or if unauthorized access through the link
        if (($this->session->userdata('user')) != NULL && $this->session->userdata('remember') == true) {
            switch ($this->session->userdata('user')->status) {
                case "user":
                    redirect("user");
                case "admin":
                    redirect("admin");
            }
        }
        $phpArray = $this->get_all_destinations();
        ?>
<script type="text/javascript">var jArray =<?php echo json_encode($phpArray); ?>;</script>
<?php
    }
    
    // default function, load default views
    // @return void
    function index(){
        $this->is_regular_user();
        $data['profile_pic'] = $this->get_img_name();
        $data['last_reviews_html'] = $this->review_model->get_html_last_n_reviews();
        $data['page'] = 'guest_home';
        
        $this->load->view("templates/super_user_header.php", $data);
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }
    
    // load different views for user, and messages for view
    // @param string $page, $message
    // @return void
    public function load($page, $message=null, $data=null) {
        $this->is_regular_user();
        $info['profile_pic'] = $this->get_img_name();
        $data['last_reviews_html'] = $this->review_model->get_html_last_n_reviews();
        
        $info['page'] = $page;
        if ($message != null){
            $info['message'] = $message;
            if($data != null)
                $data = $data + $info;
        }
            
        
        $this->load->view("templates/super_user_header.php", $info);
        $this->load->view($page.".php", $data);
        $this->load->view("templates/footer.php");
    }
    public function delete_review($destination_id, $review_id){
        $this->is_regular_user();
        //Brisanje reviewa
        $this->review_model->delete($review_id);      
        $this->load_dest($destination_id);
    }
    // get img name by its id if null return default avatar
    // @param string $id
    // @return string
     public function get_img_name(){
            $this->is_regular_user();
            $path = $this->User_model->get_img_name($this->session->userdata('user')->idImg);
            
            if ( $path == "avatar.png")
                return base_url()."img/avatar.png";
            else{
                return base_url()."uploads/".$path;
            } 
        }
        
        // add new pending destination if it is requested from superuser
        // or just enter new destination if it is requested from admin
        // @return void
        public function add_destination(){
           $this->is_regular_user();
                $this->form_validation->set_rules("destination", "Username", "trim|required|min_length[2]|max_length[40]");
                $this->form_validation->set_rules("country", "Password", "trim|required|min_length[2]|max_length[40]");
                if ($this->form_validation->run()) {
                    
                    $data['name'] = $this->input->post('destination');
                    $data['longitude'] = explode(":",$this->input->post('longitudeH'))[1];
                    $data['latitude'] = explode(":",$this->input->post('latitudeH'))[1];
                    $data['pending'] = 1;
                    $data['country'] = $this->input->post('country');

                    $idDest = $this->destination_model->insert_destination($data);
                    $this->request_model->insert("destination added", $idDest, $this->session->userdata('user')->username);

                    $this->load("super_user_add_destination","Request created");
                } else {
                    $this->load("super_user_add_destination");
                }
                
            
        }

    
      // logout function, breaks session
    // @return void
    public function logout() {
        $this->is_regular_user();
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        redirect("Guest");
    }
        public function getStatistics(){
        $this->is_regular_user();
        
        $statistics['userCount']=0;
        $statistics['reviewCount']=0;
        $statistics['destinationCount']=0;
        $statistics['positiveVoteCount']=0;
        $statistics['negativeVoteCount']=0;
        
        $statistics=$this->statistic_model->getStatistics();
        
        
        $data['date']=$statistics->date;;
        $data['userCount']=$statistics->userCount;;
        $data['reviewCount']=$statistics->reviewCount;
        $data['destinationCount']=$statistics->destinationCount;
        $data['positiveVoteCount']=$statistics->positiveVoteCount;
        $data['posReviews']=$statistics->posReviews;
        $this->load("guest_statistics",null,$data);
}
    // search destionations
    public function search(){
        $this->is_regular_user();
       $output = '';
		$query = '';
		
		if($this->input->post('query'))
		{
			$query = $this->input->post('query');
		}
		$data = $this->destination_model->search_data($query);
		$output .= '
		<div class="table-responsive">
					<table class="table bg-light">

		';
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '
						<tr>
							<td><a href="'.base_url().'index.php/super_user/load_dest/'.$row->idDest.'">'.$row->name.'</a></td>
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
    
    public function search_people(){
        $this->is_regular_user();
       $output = '';
		$query = '';
		
		if($this->input->post('query'))
		{
			$query = $this->input->post('query');
		}
		$data = $this->User_model->search_data($query);
		$output .= '
		<div class="table-responsive">
					<table class="table bg-light">

		';
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '
						<tr>
							<td><a href="'.base_url().'index.php/super_user/preview_other_user/'.$row->username.'">'.$row->firstname.'</a></td>
                                                        <td>'.$row->lastname.'</td>    
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
     public function load_dest($id,$message=null){
         $this->is_regular_user();
       $data['dest_name'] = $this->destination_model->get_name($id);
       $data['dest_country'] = $this->destination_model->get_country($id);
       $data['all_reviews_current_destination_html'] = $this->review_model->get_html_all_reviews($id);
       $data['dest_id']=$id;
       $data['message']=$message;
       $data['image']=null;
       $data['image']=$this->destination_model->get_image($id);
       
       $this->load("destination",null,$data);
    }
    
    public function get_all_destinations(){
        $this->is_regular_user();
        return $this->destination_model->get_all_destinations();
    }
    
        // form check and forward request to coresponding model
    // @return void
    public function change_username() {
        $this->is_regular_user();
        $this->form_validation->set_rules("usernameChange", "Username", "trim|required|min_length[4]|max_length[20]|is_unique[user.username]");
        if ($this->form_validation->run()) {
            $new_username = $this->input->post('usernameChange');

            $this->User_model->change_username($new_username);
            $this->preview_profile("Successfully changed username");
        } else {
            $this->load("profile");
        }
    }

    // form check and forward request to coresponding model
    // @return void
    public function change_password() {
        $this->is_regular_user();
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
        $this->is_regular_user();
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
            $this->preview_profile("Successfully changed username");
        }
    }
    
    public function add_review($id){
        $this->is_regular_user();
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
    
    // loads profile view with needed data
    public function preview_profile() {
        $this->is_regular_user();
        $data['review_count'] = $this->User_model->get_user_review_count($this->session->userdata('user')->username);
        $data['places_count'] = $this->User_model->get_user_added_places_count($this->session->userdata('user')->username);
        
        
        $up_down_count = $this->User_model->up_down_count($this->session->userdata('user')->username);
        $data['up_count'] = $up_down_count['upCount'];
        $data['down_count'] = $up_down_count['downCount'];
        
        $this->load('profile', null, $data);
    }
    
    // previews profile_other if user is trying to view someone elses profile
    public function preview_other_user($other) {
        $this->is_regular_user();
        if (strcmp($other,$this->session->userdata('user')->username) != 0){
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
            
            $this->load("profile_other", null, $data);
        }
        else
            $this->preview_profile();
    }
    
    public function vote_up($review_id, $destination_id=null) {
        $this->is_regular_user();
        $this->review_model->update_vote_count($review_id, "upCount", $this->session->userdata('user')->username);
        
        if ($destination_id==null)
        {
            $this->index();
        }else
            $this->load_dest($destination_id);
    }
    public function vote_down($review_id, $destination_id=null) {
        $this->is_regular_user();
        $this->review_model->update_vote_count($review_id, "downCount", $this->session->userdata('user')->username);
        
        if ($destination_id==null)
        {
            $this->index();
        }else
            $this->load_dest($destination_id);
    }  
     public function is_regular_user(){
        
        if ($this->session->userdata('user') != null){
            if ($this->session->userdata('user')->status != "super_user"){
                $this->session->sess_destroy();
                 redirect("My404");
            }
               
        }else{
            $this->session->sess_destroy();
            redirect("My404");
        }
    }
}
