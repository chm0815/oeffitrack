<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logging extends CI_Controller
{
  function index()
  {
    if (!$this->session->userdata('logged_in')) {
      die('not logged in');
    }
    $this->db->select('id,name');
    $this->db->order_by('name', 'asc'); 
    $query = $this->db->get('routes');
    $rows = $query->result_array();
    $this->load->view('stdheader');
    $this->load->view('loggingroutes', array('rows' => $rows));
    $this->load->view('stdfooter');
  }
  
  
  function logtool($routeid)
  {
    if (!$this->session->userdata('logged_in')) {
      die('not logged in');
    }
    $this->load->model('routeinfo');
    $route = $this->routeinfo->get($routeid);
    $this->load->view('stdheader');
    $this->load->view('logtool', array('route' => $route));
    $this->load->view('stdfooter');
  }
  
}