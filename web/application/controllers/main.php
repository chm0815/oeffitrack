<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
  function index()
  {
    $this->load->view("stdheader");
    
    $this->load->view("stdfooter");
  }
}