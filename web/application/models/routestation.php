<?php

	class RouteStation extends CI_Model
	{		
		function loadRouteStations($routeid)
		{
			$this->db->order_by('stopnr', 'asc'); 
			$this->db->select('routepointid,name,stopnr,stoptime,lat,lon');
			$query = $this->db->get_where('routestations', array('routeid' => $routeid));
			return $query->result_array();
		}
	}

?>