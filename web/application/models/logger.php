<?php

class Logger extends CI_Model
{
  
  function checkLogin($loggerid, $pw)
  {
    $pwhash = sha1($pw); 
    $this->db->where(array('id' => $loggerid, 'pwhash' => $pwhash, 'active' => 'Y'));
    $count = $this->db->count_all_results('loggers');
    $rv = ($count > 0) ? true : false;
    return $rv;
  }
  
  function countLoggers()
  {
    $rv = $this->db->count_all('loggers');
    return $rv;
  }
  
  function getLoggers($limit=100 , $offset=0)
  {
    $this->db->select('id,name');
    $this->db->order_by('id,name');
    if ($offset < 0 || $limit < 0) {
      $query = $this->db->get('loggers');
    } else {
      $query = $this->db->get('loggers', $limit, $offset);
    }
    return $query->result_array();
  }
  
  function getLogger($loggerid) 
  {
    $query = $this->db->get_where('loggers', array('id' => $loggerid));
    if ($query->num_rows() == 1) 
    {
      return $query->row_array();
    } else 
    {
      return null;
    }
  }
}


?>