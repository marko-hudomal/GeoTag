<?php

/**
 * @author Dejan Ciric 570/15
 * 
 * Destination_model - class that handle all requests for destination table
 */
class Destination_model extends CI_Model{
    
    // Creating new instance
    // @return void 
    public function __construct() {
        parent::__construct();
    }
    
    // insert new destination (new row) in table destination
    // @param array $data (represents one row in table destination)
    // @return void
    public function insert_destination($data){
        
        $this->db->insert('destination', $data);
    }  
    
    
   function search_data($query)
	{
		$this->db->select("*");
		$this->db->from("destination");
		if($query != '')
		{
			$this->db->like('name', $query);
			$this->db->or_like('country', $query);
                        return $this->db->get();

		}
                
			$this->db->or_like('country', 123);
                        return $this->db->get();
	}
        
        //Mislim da ne radi ova funkcija, ja sam sa get_name radio, #Hudi
        public function get_info($id){
            $query = $this->db->query("select name, country, longitude, latitude from destination where idDest=".$id." and pending=0");
            return $query->result_array()[0];  
        }
        
        
        public function get_name($id){
            $query = $this->db->query("select * from destination where idDest=".$id);
            return $query->result()[0]->name;
        }
        public function get_country($id){
            $query = $this->db->query("select * from destination where idDest=".$id);
            return $query->result()[0]->country;
        }
        public function get_longitude($id){
            $query = $this->db->query("select * from destination where idDest=".$id);
            return $query->result()[0]->longitude;
        }
        public function get_latitude($id){
            $query = $this->db->query("select * from destination where idDest=".$id);
            return $query->result()[0]->latitude;
        }

        public function get_destination($id){
            $query = $this->db->query("select * from destination where idDest=".$id);
            return $query->result()[0];
        }
        public function get_all_destinations(){
           $query = $this->db->query("select name, country, longitude, latitude, idDest from destination where pending=0");
           return $query->result_array();  
       }
}