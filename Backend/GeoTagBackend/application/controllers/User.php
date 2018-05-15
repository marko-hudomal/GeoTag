<?php

/**
 * Description of User
 *
 * @author Dejan
 */
class User extends CI_Controller{
    
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
    
    public function index(){
        $this->load->view("templates/user_header.php");
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }
    
    public function load($page){
        $this->load->view("templates/user_header.php");
        $this->load->view($page.".php");
        $this->load->view("templates/footer.php");
    }
    
    public function logout(){
        $this->session->unset_userdata("user");
        $this->session->sess_destroy(); 
        redirect("Guest");
    }
}
