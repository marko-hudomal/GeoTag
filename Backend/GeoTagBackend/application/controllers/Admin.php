<?php

/**
 * @author Dejan Ciric 570/15
 * 
 * Admin - class that handle all requests for admin
 */
class Admin extends CI_Controller{
    
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
}
