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
    }
    
    // default function, load default views
    // @return void
    function index(){
        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/super_user_header.php", $data);
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }
    
    // load different views for user
    // @param string $page
    // @return void
    public function load($page) {
        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/super_user_header.php", $data);
        $this->load->view($page.".php");
        $this->load->view("templates/footer.php");
    }
    
     public function get_img_name(){
            
            $path = $this->User_model->get_img_name($this->session->userdata('user')->idImg);
            
            if ( $path == "avatar.png")
                return base_url()."img/avatar.png";
            else{
                return base_url()."uploads/".$path;
            }
            
        }
}
