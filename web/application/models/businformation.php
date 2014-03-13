<?php

  class Businformation extends CI_Model
  {

    function getActualTarget($routeid, $datetime)
    {
      $sql = "select rs.stopnr as stopnr,rs.stoptime as stoptime,time(al.logtime) as logtime,rs.name as name,
          time_to_sec(subtime(time(al.logtime),rs.stoptime)) as diff,rs.lat as lat,rs.lon as lon
          from routestations rs
          left outer join arrivelogs al
          on rs.routeid=al.routeid and rs.stopnr=al.stopnr and date(al.logtime)=date( ? ) and al.logtime<= ?
          where rs.routeid= ?";
      $query = $this->db->query($sql, array($datetime, $datetime, (int)$routeid));
      $rows = $query->result_array();
      return $rows;
    }
    
    function getDiff($routeid, $datetime)
    {
      $rv = null;
      $sql = "select timediff(time(logtime),time( ? )) as diff,logtime,stoptime from arrivelogs 
          where routeid= ? and date(logtime)=date( ? ) 
          order by logtime desc limit 1";
      $query = $this->db->query($sql, array($datetime, (int)$routeid, $datetime));
      
      $row = $query->result_array();
      if (count($row) == 1) {
        $rv = $row[0];
      }
      return $rv;
    }
    
  }


?>