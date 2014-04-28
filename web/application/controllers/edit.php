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
  
  function delete($routeid=-1) 
  {
    if (!$this->session->userdata('logged_in')) {
      die('not logged in');
    }
    if ($routeid > -1) {
      $this->load->model('routemodel');
      $this->routemodel->deleteRoute($routeid);
    }
    $this->index();
  }
  
  function newedit($routeid=-1)
	{
		$this->load->helper('form');
		$this->load->model(array('routeinfo', 'routestation'));
		if (!$this->session->userdata('logged_in')) {
			die('not logged in');
		}
		$this->load->view('stdheader');
		if ($routeid > -1) {
			$rows = $this->routestation->loadRouteStations($routeid);	
      $routeinfo = $this->routeinfo->get($routeid);
      
			$data = array('rows' => $rows, 'routeinfo' => $routeinfo, 'routeid'=> $routeid);
			$this->load->view('edit', $data);
		} else {
			$this->load->view('edit');
		}
		$this->load->view('stdfooter');
	}
  
  function create($routeid = -1)
  {
    //$this->load->library('session');
    if (!$this->session->userdata('logged_in')) {
      die('not logged in');
    }
    $this->load->model('routemodel');
    $this->load->library('form_validation');
    $this->load->helper(array('form', 'url'));
    
    $this->form_validation->set_rules('routeid', 'Routeid', 'required|is_natural');
    $this->form_validation->set_rules('routename', 'Routename', 'required');
    
    $new = false;
    $existing = false;

    if ($this->input->post('bsname', TRUE)==TRUE) {
      $existing = true;
      $this->form_validation->set_rules('bsname[]', 'Busstop', 'required');
      $this->form_validation->set_rules('stopnr[]', 'Stopnr', 'required|is_natural');
      $this->form_validation->set_rules('stoptime[]', 'Time', 'required');
      $this->form_validation->set_rules('lat[]', 'Lat', 'required|numeric');
      $this->form_validation->set_rules('lon[]', 'Lon', 'required|numeric');
    }

    if ($this->input->post('bsname_new', TRUE)==TRUE) {
      $new = true;
      $this->form_validation->set_rules('bsname_new', 'Busstop', 'required');
      $this->form_validation->set_rules('stopnr_new', 'Stopnr', 'required|is_natural');
      $this->form_validation->set_rules('stoptime_new', 'Time', 'required');
      $this->form_validation->set_rules('lat_new', 'Lat', 'required|numeric');
      $this->form_validation->set_rules('lon_new', 'Lon', 'required|numeric');
    }
    
    
    if ($this->form_validation->run() == TRUE) {
      $routename = $this->input->post('routename', TRUE);
      $routeid = $this->input->post('routeid', TRUE);
      $this->routemodel->createRoute($routeid, $routename);
      
      
      $cnterr = false;
      if ($existing == true) {
        $bsnames = $this->input->post('bsname',TRUE);
        $bsnamescnt = count($bsnames);
        $stopnrs = $this->input->post('stopnr',TRUE);
        $stopnrscnt = count($stopnrs);
        if ($stopnrscnt != $bsnamescnt)
          $cnterr=true;
        $stoptimes = $this->input->post('stoptime',TRUE);
        $stoptimescnt = count($stoptimes);
        if ($stopnrscnt != $stoptimescnt)
          $cnterr=true;
        $lats = $this->input->post('lat',TRUE);
        $latscnt = count($lats);
        if ($stopnrscnt != $latscnt)
          $cnterr=true;
        $lons = $this->input->post('lon',TRUE);
        $lonscnt = count($lons);
        if ($stopnrscnt != $lonscnt)
          $cnterr=true;
        
        if ($cnterr == false) {
        
          for ($i=0; $i < $bsnamescnt; $i++) {
            if ($this->input->post('del_'.$i, TRUE)==FALSE) {
              $this->routemodel->createRoutepoint($routeid, $stopnrs[$i], $stoptimes[$i], $bsnames[$i], $lats[$i], $lons[$i]);
            } else {
              $this->routemodel->deleteRoutepoint($routeid, $stopnrs[$i]);
            }
          }
          
        } else {
          echo "invalid form data\n";
        }
      }
      
      if ($new == true) {
        $bsname_new = $this->input->post('bsname_new',TRUE);
        $stopnr_new = $this->input->post('stopnr_new',TRUE);
        $stoptime_new = $this->input->post('stoptime_new',TRUE);
        $lat_new = $this->input->post('lat_new',TRUE);
        $lon_new = $this->input->post('lon_new',TRUE);
        $this->routemodel->createRoutepoint($routeid, $stopnr_new, $stoptime_new, $bsname_new, $lat_new, $lon_new);
      }
    }
    $this->newedit($routeid);
    
  }
  
}