<?php

/**
 * @author Dejan Ciric 570/15
 * 
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
        $this->load->model("statistic_model");
        // check if user is already logged in, or if unauthorized access through the link
        if (($this->session->userdata('user')) != NULL) {
            switch ($this->session->userdata('user')->status) {
                case "user":
                    redirect("User");
                    break;
                case "superuser":
                    redirect("SuperUser");
                    break;
                case "admin":
                    redirect("Admin");
                    break;
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
        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/super_user_header.php", $data);
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }
    
    // load different views for user, and messages for view
    // @param string $page, $message
    // @return void
    public function load($page, $message=null, $data=null) {
        $msg = [];
        if ($message != null)
            $msg['message'] = $message;
        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/super_user_header.php", $data);
        $this->load->view($page.".php", $msg, $data);
        $this->load->view("templates/footer.php");
    }
    
    // get img name by its id if null return default avatar
    // @param string $id
    // @return string
     public function get_img_name(){
            
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
            if ($this->session->userdata('user')->status == "superuser"){
                $this->form_validation->set_rules("destination", "Username", "trim|required|min_length[2]|max_length[40]");
                $this->form_validation->set_rules("country", "Password", "trim|required|min_length[2]|max_length[40]");
                if ($this->form_validation->run()) {
                    
                $data['name'] = $this->input->post('destination');
                $data['longitude'] = explode(":",$this->input->post('longitudeH'))[1];
                $data['latitude'] = explode(":",$this->input->post('latitudeH'))[1];
                $data['pending'] = 1;
                $data['country'] = $this->input->post('country');
                
                $this->Destination_model->insert_destination($data);

                $this->load("super_user_add_destination","Successfully added destination");
                } else {
                    $this->load("super_user_add_destination");
                }
                }
            else{ // if it's admin
                $this->form_validation->set_rules("destination", "Username", "trim|required|min_length[2]|max_length[40]");
                $this->form_validation->set_rules("country", "Password", "trim|required|min_length[2]|max_length[40]");
                if ($this->form_validation->run()) {
                    
                $data['name'] = $this->input->post('destination');
                $data['longitude'] = explode(":",$this->input->post('longitudeH'))[1];
                $data['latitude'] = explode(":",$this->input->post('latitudeH'))[1];
                $data['pending'] = 0;
                $data['country'] = $this->input->post('country');
                
                $this->destination_model->insert_destination($data);

                $this->load("super_user_add_destination","Successfully added destination");
                } else {
                    $this->load("super_user_add_destination");
                }
            }
        }

    
      // logout function, breaks session
    // @return void
    public function logout() {
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        redirect("Guest");
    }
        public function getStatistics(){
        
        
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
        $this->load("guest_statistics",$data);
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
     public function load_dest($id){
       $data = $this->destination_model->get_info($id);
      
       $this->load("destination",null,$data);
    }
    
    public function get_all_destinations(){
        return $this->destination_model->get_all_destinations();
    }
}
