<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
  function index()
  {
    $this->load->view("stdheader");
    $this->load->view("overview");
    $this->load->view("stdfooter");
  }
  
  function login()
  {
    $this->load->helper('form', 'form_validation');
    $this->load->view("stdheader");
    $this->load->view("login");
    $this->load->view("stdfooter");
  }
  
  function logout()
  {
    $this->session->sess_destroy();
    redirect('/');
  }
  
  function loginAction()
  {
    $this->load->model('logger');
    $this->load->library(array('form_validation'));
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == TRUE) {
      $name = $this->input->post('name', TRUE);
      $pw = $this->input->post('password', TRUE);
      $logger = $this->logger->checkLoginByName($name, $pw);
      if ($logger != null) {
        $this->session->set_userdata('logged_in',TRUE);
        $this->session->set_userdata('name', $name);
        $this->session->set_userdata('logger', $logger);
        redirect('main/logger');
      }
    }
    $this->login();
  }
  
  function logger()
  {
    if (!$this->session->userdata('logged_in')) {
      die('not logged in');
    }
    $this->load->view("stdheader");
    $this->load->view("overview");
    $this->load->view("stdfooter");
  }
  
}