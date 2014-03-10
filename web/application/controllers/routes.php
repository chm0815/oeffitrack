<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends CI_Controller
{
  function index($view = 'html', $offest = -1, $limit = -1)
  {
    $this->db->select('id,name');
    $this->db->order_by('name', 'asc');
    if ($offest != -1 && $limt != -1)
    {
      $this->db->limit($offest, $limit);
    }
    $query = $this->db->get('routes');
    $rows = $query->result_array();
    if ($view == 'json')
    {
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($rows));
    }
    elseif ($view == 'html')
    {
      $this->load->view('stdheader');
      $this->load->view('routes', array('rows' => $rows));
      $this->load->view('stdfooter');
    }
  }
}