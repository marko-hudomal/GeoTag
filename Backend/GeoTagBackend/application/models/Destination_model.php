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
        
        
         public function get_info($id){
            $query = $this->db->query("select name, country, longitude, latitude from destination where idDest=".$id);

        return $query->result_array()[0];
    
        }
}