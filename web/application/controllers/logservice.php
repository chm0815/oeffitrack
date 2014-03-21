<?php

class LogService extends CI_Controller {

  function index()
  {
    $this->load->library('xmlrpc');
    $this->load->library('xmlrpcs');
    $this->load->model('logger');
    $this->load->model('positionlogger');
    
    $config['functions']['log'] = array('function' => 'LogService.log');
    
    $this->xmlrpcs->initialize($config);
    $this->xmlrpcs->serve();
  }
  
  
  function log($request)
  {
    $rv = false;
    $loginok = true;
    $parameters = $request->output_parameters();
    if (count($parameters) != 6) 
    {
      return $this->xmlrpc->send_error_message('100', 'wrong number of parameters '.count($parameters));
    } 
    else 
    {
      $loggerid= $parameters[0];
      $pw = $parameters[1];
      $routeid = $parameters[2];
      $lat = $parameters[3];
      $lon = $parameters[4];
      $routepointid = $parameters[5];
    }

    $loginok = $this->logger->checkLogin($loggerid, $pw);
    if ($loginok == false) 
    {
      log_message('error','authentification failed (LogService loggerid='.$loggerid.' pw='.$pw.")\n");
      return $this->xmlrpc->send_error_message('101', 'authentification failed');
    }
    
    $rv = $this->positionlogger->logPosition($loggerid, $routeid, $lat, $lon, $routepointid);
    
    if (!$rv) 
    {
      return $this->xmlrpc->send_error_message('102', 'Database Error');
    } 
    $response = array('OK');
    
    return $this->xmlrpc->send_response($response);
  }
}
?>