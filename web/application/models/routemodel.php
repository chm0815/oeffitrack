<?php

  class Routemodel extends CI_Model
  {

    function deleteRoute($routeid) 
    {
      $rv = true;
      $this->db->query('delete from routelogs where  exists(select 1 from routepoints rp where rp.routeid=? and rp.id=routelogs.routepointid)', array($routeid));
      $this->db->delete('drivelogs', array('routeid' => $routeid));
      $this->db->delete('routepoints', array('routeid' => $routeid));
      $this->db->delete('routes', array('id' => $routeid));
      
      return $rv;
    }
    
    function deleteRoutepoint($routeid, $stopnr, $deleteRoutelogs=true)
    {
      $rv = false;
      $query = $this->db->get_where('routepoints', array('routeid'=>$routeid, 'stopnr'=>$stopnr));
      if ($query->num_rows() > 0) {
        $routepoint = $query->row_array();
        
        if ($deleteRoutelogs == true) {
          $this->db->delete('routelogs', array('routepointid' => $routepoint['id'])); 
        }
        
        $this->db->delete('routepoints', array('id' => $routepoint['id']));
        $rv = true;
      }
      return $rv;
    }
    
    function createRoutepoint($routeid, $stopnr, $stoptime, $bsname, $lat, $lon, $update=true)
    {
      $rv = false;
      
      $query = $this->db->get_where('routes', array('id'=>$routeid));
      if ($query->num_rows() == 1) {
        // route exists 
        
        $query = $this->db->get_where('routepoints',
            array ('routeid'=>$routeid, 'stopnr'=>$stopnr));
            
        if ($query->num_rows() == 1) {
          // routepoint exists 
          $oldroutepoint = $query->row_array();
          
          $query = $this->db->get_where('busstops',array('id'=>$oldroutepoint['busstopid']));
          if ($query->num_rows()==1) {
            $oldbusstop = $query->row_array();
            
            if ($oldbusstop['name'] != $bsname || $oldbusstop['lat'] !=$lat || $oldbusstop['lon'] !=$lon 
              || $oldroutepoint['stoptime'] !=$stoptime) {
              // busstop data has changed
              $query = $this->db->get_where('busstops', array('name' => $bsname, 'lat' => $lat, 'lon'=>$lon));
              if ($query->num_rows() > 0) {
                // busstop already exists
                $busstop = $query->row_array();
                $this->db->where('id', $oldroutepoint['id']);
                $data = array(
                  'stoptime' =>$stoptime,
                  'busstopid'=>$busstop['id']
                );
                $this->db->update('routepoints', $data);
                $rv = true;
              } else {
                // new busstop has to be created first
                $data = array(
                  'name'=>$bsname,
                  'lat'=>$lat,
                  'lon'=>$lon
                );
                $this->db->insert('busstops', $data);
                $newbusstopid = $this->db->insert_id();
                
                $this->db->where('id', $oldroutepoint['id']);
                $data = array(
                  'stoptime' =>$stoptime,
                  'busstopid'=>$newbusstopid
                );
                $this->db->update('routepoints',$data);
                $rv = true;
              }
            }
          }
        } else {
          // new routepoint
          $query = $this->db->get_where('busstops', array('name' => $bsname, 'lat' => $lat, 'lon' => $lon));
          if ($query->num_rows() > 0) {
            $busstop = $query->row_array();
            $data = array(
              'routeid' => $routeid,
              'busstopid' => $busstop['id'],
              'stopnr' => $stopnr,
              'stoptime' => $stoptime
            );
            $this->db->insert('routepoints', $data);
            $rv = true;
          } else {
            // new busstop has to be created first
            $data = array(
              'name'=>$bsname,
              'lat'=>$lat,
              'lon'=>$lon
            );
            $this->db->insert('busstops',$data);
            $newbusstopid = $this->db->insert_id();
            $data = array(
              'routeid' =>$routeid,
              'busstopid' => $newbusstopid,
              'stopnr' =>$stopnr,
              'stoptime' =>$stoptime
            );
            $this->db->insert('routepoints',$data);
            $rv = true;
          }
        }
      }
      
      return $rv;
    }
    
    function createRoute($routeid, $name, $update=true)
    {
      $rv = false;
      $query = $this->db->get_where('routes', array('id' => $routeid));
      if ($query->num_rows() == 1) {
        if ($update == true) {
          $this->db->where('id', $routeid);
          $data = array('name' => $name);
          $this->db->update('routes', $data);
          $rv = true;
        }
      } else {
        $data = array(
            'id' =>$routeid,
            'name' =>$name
          );
        $this->db->insert('routes',$data);
        $rv = true;
      }
      return $rv;
    }
  }
?>