<?php


/**
 * Description of My404
 *
 * @author User
 */
class My404 extends CI_Controller{
    public function __construct() 
    {
       parent::__construct(); 
    } 

    public function index() 
    { 
       $this->output->set_status_header('404'); 
       $this->load->view('err404');//loading in custom error view
    } 
}
