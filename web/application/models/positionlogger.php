<?php

  class PositionLogger extends Model 
  {    
    function logPosition($loggerid,$routeid,$lat,$lon,$routepointid=-1)
    {
      $rv = true;
      log_message('debug','trying logPosition()');
      $logtime = date('Y-m-d H:i:s');
      $data = array(
            'loggerid'=>$loggerid,
            'routeid'=>$routeid,
            'lat'=>$lat,
            'lon'=>$lon,
            'logtime'=>$logtime
          );
      
      $rv = $this->db->insert('drivelogs',$data);
      
      if  (!$rv) {
        $logdata = var_export($data,true);
        log_message('error','Insert into drivelogs failed: '.$logdata."\n");
      }
      
      if ($routepointid !=-1 && $rv) {
        $sdate = date('Y-m-d').' 00:00';
        $edate = date('Y-m-d H:i:s');//' 23:59:59';
        $this->db->where(array('routeid'=>$routeid,'routepointid'=>$routepointid,'logtime >='=>$sdate,'logtime <='=>$edate));
        $count = $this->db->count_all_results('arrivelogs');
        if  ($count==0) {
          $data = array(
            'routepointid'=>$routepointid,
            'logtime'=>$logtime,
            'lat'=>$lat,
            'lon'=>$lon,
            'loggerid'=>$loggerid,
          );
          $rv = $this->db->insert('routelogs',$data);
          if (!$rv) {
            $logdata = var_export($data,true);
            log_message('error','Insert into routelogs failed: '.$logdata."\n");
          }
        } else {
          log_message('warn','Routelog for routepointid '.$routepointid." already exists\n");
        }
      }
      return $rv;
    }
    
  }


?>