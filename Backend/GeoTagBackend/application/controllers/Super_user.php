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
        
    }
    
    // default function, load default views
    // @return void
    function index(){
        $this->load->view("templates/super_user_header.php");
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }
    
    // load different views for user
    // @param string $page
    // @return void
    public function load($page) {
        $this->load->view("templates/super_user_header.php");
        $this->load->view($page.".php");
        $this->load->view("templates/footer.php");
    }
}
