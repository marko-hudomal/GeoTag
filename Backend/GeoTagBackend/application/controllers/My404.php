<?php


/** 
 * @author Marko Hudomal
 * My404 - controller used to handle error 404 Page Not Found
 */
class My404 extends CI_Controller{
    public function __construct() 
    {
       parent::__construct(); 
    } 
    
    // Loading err404.php from views
    // @return void
    public function index() 
    { 
       $this->output->set_status_header('404'); 
       $this->load->view('err404');//loading in custom error view
    } 
}
