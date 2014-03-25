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
  
  function log()
  {
    if (!$this->session->userdata('logged_in')) {
      die('not logged in');
    }
    $this->load->model('positionlogger');
    
    $logger =  $this->session->userdata('logger');
    $loggerid = $logger['id'];
    $routeid = $this->input->post('routeid', TRUE);
    $lat = $this->input->post('lat', TRUE);
    $lon = $this->input->post('lon', TRUE);
    $routepointid = $this->input->post('routepointid', TRUE);
    
    $rv = $this->positionlogger->logPosition($loggerid, $routeid, $lat, $lon, $routepointid);
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode(array('status' => 'OK')));
  }
  
}