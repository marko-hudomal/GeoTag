<?php

/**
 * @author Dejan Ciric 570/15
 * 
 * Admin - class that handle all requests for admin
 */
class Admin extends CI_Controller {

    // Creating new instance
    // @return void 
    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("statistic_model");
    }

    // default function, load default views
    // and add all information reading from database on load here
    // @return void
    function index() {
        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/admin_header.php", $data);
        $this->load->view("guest_home.php");
        $this->load->view("templates/footer.php");
    }

    // load different views for user
    // and add all information reading from database on load here
    // @param string $page
    // @return void
    public function load($page) {
        $data['profile_pic'] = $this->get_img_name();
        $this->load->view("templates/admin_header.php", $data);
        $this->load->view($page . ".php");
        $this->load->view("templates/footer.php");
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

}
