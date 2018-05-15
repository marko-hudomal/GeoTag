<?php

/**
 * Description of Guest
 *
 * @author Dejan
 */
class Guest extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        // check if user is already logged in, or if unauthorized access through the link
         if (($this->session->userdata('user_type')) != NULL) {
           switch($this->session->userdata('autor')->status) {
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
    }
    
    function index($message = null){
      
        $data = [];
        if ($message)
            $data['message']=$message;
        
            $this->load->view("index.php", $data);   
    }
    
    function register(){
        $this->form_validation->set_rules("username", "Username", "trim|required|min_length[4]|max_length[20]|is_unique[user.username]");
        $this->form_validation->set_rules("pwd_signup", "Password", "trim|required|min_length[4]|max_length[20]");
        $this->form_validation->set_rules("email", "Email", "required|valid_email|max_length[40]|is_unique[user.email]");
        $this->form_validation->set_rules("first_name", "Firstname", "required|max_length[20]");
        $this->form_validation->set_rules("last_name", "Lastname", "required|max_length[20]");
        $this->form_validation->set_rules("gender", "Gender", "required");
       $data['gender'] = $this->input->post('gender'); 
       
        if ($this->form_validation->run()) {
        $data['username'] = $this->input->post('username');
        $data['email'] = $this->input->post('email');
        $data['status'] = "user";
        $data['password'] = $this->input->post('pwd_signup');
        $data['firstname'] = $this->input->post('first_name');
        $data['lastname'] = $this->input->post('last_name');
        
        
        if ($data['gender'] == "0")
            $this->index("Please select gender");
        else
         $this->User_model->insert_user($data);
        
        $this->index("Successfully registred, you can login");
        
        } else {
            if ($data['gender'] == "0")
                $this->index("Please select gender");
            else
                $this->index();
        }
       
    }
    
    function login(){
        $this->form_validation->set_rules("emailSignin", "Email address", "required");
        $this->form_validation->set_rules("pwd_signin", "Password", "required");
        if ($this->form_validation->run()) {
            if (!$this->User_model->getUser($this->input->post('emailSignin'))) {
                $this->index("Wrong email");
            } else if (!$this->User_model->check_password($this->input->post('pwd_signin'))) {
                $this->index("Wrong password!");
            } else {
                $user=$this->User_model->user;
                $this->session->set_userdata('user',$user);
                 switch($this->session->userdata('user')->status) {
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
        $data['email'] = $this->input->post('emailSignin');
        $data['password'] = $this->input->post('pwd_signin');

        } else {
            $this->index();
        }
        
        
    }
    
    public function load($page){
        $this->load->view("templates/guest_header.php");
        $this->load->view($page.".php");
        $this->load->view("templates/footer.php");
    }
   
}
