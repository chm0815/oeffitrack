<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drivelogs extends CI_Controller
{
  function index($routeid, $view = 'json', $datetime = '0')
  {
    $this->db->select('lat,lon,logtime');
    $this->db->order_by('logtime', 'desc');
    $datetime = getStdDateTime($datetime);
    $start = startTime($datetime);
    $query = $this->db->get_where('drivelogs', array('routeid' => (int)$routeid, 'logtime <=' => $datetime, 'logtime >=' => $start));
    $rows = $query->result_array();
    if ($view == 'json')
    {
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($rows));
    }
  }
}