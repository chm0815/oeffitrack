<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Route extends CI_Controller
{
  function index($routeid, $datetime = null)
  {
    $datetime = getStdDateTime();
    $this->load->model('routeinfo');
    $route = $this->routeinfo->get($routeid);
    $this->load->view('stdheader');
    $this->load->view('route', array('route' => $route));
    $this->load->view('stdfooter');
  }
  
  
  function data($routeid, $datetime = null)
  {
    $datetime = getStdDateTime();
    $this->load->model('businformation');
    $rows = $this->businformation->getActualTarget($routeid, $datetime);
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($rows));
  }
  
  function diff($routeid, $datetime = null)
  {
    $datetime = getStdDateTime();
    $this->load->model('businformation');
    $diff = $this->businformation->getDiff($routeid, $datetime);
    $this->output->set_content_type('application/json'); 
    $this->output->set_output(json_encode(array('diff' => $diff)));
  }
  
  function routestations($routeid)
  {
    $this->load->model('routestation');
    $rows = $this->routestation->loadRouteStations($routeid);
    $this->output->set_content_type('application/json'); 
    $this->output->set_output(json_encode($rows));
  }
  
}