<?php

  class RouteInfo extends CI_Model
  {    
    function get($routeid)
    {
      $this->db->select('id,name');
      $query = $this->db->get_where('routes', array('id' => $routeid));
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