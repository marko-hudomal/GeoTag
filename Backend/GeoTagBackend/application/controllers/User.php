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
        // check if user is already logged in, or if unauthorized access through the link
        if (($this->session->userdata('user_type')) != NULL) {
            switch ($this->session->userdata('autor')->status) {
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

    // default function, load default views
    // @return void
    public function index() {
        $this->load->view("templates/user_header.php");
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }

    // load different views for user
    // @param string $page
    // @return void
    public function load($page) {
        $this->load->view("templates/user_header.php");
        $this->load->view($page . ".php");
        $this->load->view("templates/footer.php");
    }

    // logout function, breaks session
    // @return void
    public function logout() {
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        redirect("Guest");
    }

}
