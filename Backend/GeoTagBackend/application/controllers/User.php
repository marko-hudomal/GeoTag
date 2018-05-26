<?php

/**
 * @author Dejan Ciric 570/15
 * 
 * User - class that handle all requests for classic registered user 
 * and for more privileged users if they use the same actions
 */
class User extends CI_Controller {

    // Creating new instance
    // @return void 
    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
       $this->load->model("destination_model");
        $this->load->model("statistic_model");
        // check if user is already logged in, or if unauthorized access through the link
        if (($this->session->userdata('user')) != NULL) {
            switch ($this->session->userdata('user')->status) {
              
               
                case "super_user":
                    redirect("super_user");
                    break;
                case "admin":
                    redirect("admin");
                    break;
            }
        }
        $phpArray = $this->get_all_destinations();
        ?>
<script type="text/javascript">var jArray =<?php echo json_encode($phpArray); ?>;</script>
<?php
    }

    // default function, load default views
    // and add all information reading from database on load here
    // @return void
    public function index() {

        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/user_header.php", $data);
        $this->load->view("guest_home.php", $data);
        $this->load->view("templates/footer.php");
    }

    // load different views for user and can pass different messages to the view
    // and add all information reading from database on load here
    // @param string $page, string $message
    // @return void
    public function load($page, $message = null,$data=null) {

        $info['profile_pic'] = $this->get_img_name();
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
        if ($this->form_validation->run()) {
            $new_username = $this->input->post('usernameChange');

            $this->User_model->change_username($new_username);
            $this->load("profile", "Successfully changed username");
        } else {
            $this->load("profile");
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
                $this->load("profile", "Wrong old password");
            } else {
                $this->User_model->change_password($new_password);
                $this->load("profile", "Successfully changed password");
            }
        } else {
            $this->load("profile");
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
            $this->load("profile", $message);
        } else {
            $this->User_model->change_photo($this->upload->data()['file_name']);
            $this->load("profile", "Successfully changed username");
        }
    }

    // get img name by its id if null return default avatar
    // @param string $id
    // @return string
    public function get_img_name() {

        $path = $this->User_model->get_img_name($this->session->userdata('user')->idImg);

        if ($path == "avatar.png")
            return base_url() . "img/avatar.png";
        else {
            return base_url() . "uploads/" . $path;
        }
    }

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
					<table class="table bg-light">

		';
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
     public function load_dest($id){
       $data = $this->destination_model->get_info($id);
      
       $this->load("destination",null,$data);
    }
    
    public function get_all_destinations(){
        return $this->destination_model->get_all_destinations();
    }
}
