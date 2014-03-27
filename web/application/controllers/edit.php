<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends CI_Controller
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
    $this->load->view('editroutes', array('rows' => $rows));
    $this->load->view('stdfooter');
  }
  
}