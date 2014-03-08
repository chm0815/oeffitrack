<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Arrivelogs extends CI_Controller
{
  function index($routeid, $view = 'json', $datetime = '0')
  {
    $this->db->select('stopnr,name,lat,lon,stoptime,logtime');
    $this->db->order_by('logtime', 'desc');
    $datetime = getStdDateTime($datetime);
    $start = startTime($datetime);
    $query = $this->db->get_where('arrivelogs', array('routeid' => (int)$routeid, 'logtime <=' => $datetime, 'logtime >=' => $start));
    $rows = $query->result_array();
    if ($view == 'json')
    {
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($rows));
    }
    elseif ($view == 'kml')
    {
      $this->output->set_content_type('application/vnd.google-earth.kml+xml');
      $this->load->view('kmlarrivelogs', 
          array('rows' => $rows,
                'routeid' => $routeid, 
                'name' => 'Arrivelogs', 
                'desc' => "Arrivelogs $datetime $routeid", 
                'showbus' => true)
      );
    }
  }
}