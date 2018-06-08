<?php

/**
 * @author Dejan Ciric 570/15
 * @author Marko Hudomal 0112/15
 * Destination_model - handles all database manipulation regarding destinations
 */
class Destination_model extends CI_Model{
    
    // Creating new instance
    // @return void 
    public function __construct() {
        parent::__construct();
    }
    
    // insert new destination (new row) in table destination
    // @param array $data (represents one row in table destination)
    // @return int
    public function insert_destination($data){
        
        $this->db->insert('destination', $data);
        return $insert_id = $this->db->insert_id();
    }  
    
    // delete desination
    // @param int $destination_id
    // @return void
    public function delete($destination_id)
    {
        $this->db->where('idDest', $destination_id);
        $this->db->delete('destination');
    }
    
    // approve destination request, change its status to not pending
    // @param int $destination_id
    // @return void
    public function approve_destination($destination_id){
        $this->db->set('pending', 0);
        $this->db->where('idDest', $destination_id);
        $this->db->update('destination');
    }
    
    // search for destination
    // @param string $query
    // @return array of all destinations that meets the conditions
    function search_data($query) {
        $this->db->select("*");
        $this->db->from("destination");
        if($query != '') {
            $this->db->where('pending', false);
            $this->db->like('name', $query);
            $this->db->or_like('country', $query);
            $this->db->where('pending', false);
            return $this->db->get();
        }
        $this->db->like('country', 123);
        return $this->db->get();
    }
        
    // get destination by id
    // @param int $id
    // @return destination object
    public function get_info($id){
        $query = $this->db->query("select name, country, longitude, latitude from destination where idDest=".$id." and pending=0");
        return $query->result_array()[0];  
    }
        
    // get destination name by id
    // @param int $id
    // @return string
    public function get_name($id){
        $query = $this->db->query("select * from destination where idDest=".$id);
        return $query->result()[0]->name;
    }
    
    // get destination country by id
    // @param int $id
    // @return string
    public function get_country($id){
        $query = $this->db->query("select * from destination where idDest=".$id);
        return $query->result()[0]->country;
    }
    
    // get destination longitude by id
    // @param int $id
    // @return string
    public function get_longitude($id){
        $query = $this->db->query("select * from destination where idDest=".$id);
        return $query->result()[0]->longitude;
    }
    
    // get destination latitude by id
    // @param int $id
    // @return string
    public function get_latitude($id){
        $query = $this->db->query("select * from destination where idDest=".$id);
        return $query->result()[0]->latitude;
    }
    
    // Get destination by it's id
    // @param int $id 
    // @return destination as array
    public function get_destination($id){
        $query = $this->db->query("select * from destination where idDest=".$id);
        return $query->result()[0];
    }
    
    // get all destinations
    // @return array Array containing all destinations from database
    public function get_all_destinations(){
       $query = $this->db->query("select name, country, longitude, latitude, idDest from destination where pending=0");
       return $query->result_array();  
    }
    
    // Get destination id by it's name
    // @param int $name
    // @return destination id
    public function get_id($name) {
        $query = $this->db->query("select * from destination where name='".$name."'");
        return $query->result()[0]->idDest;
    }
    
    // get destination image by id
    // @param int $id
    // @return string Image url
    public function get_image($destid){
        $query = $this->db->query("select * from review where idDest=".$destid);
        $reviews=$query->result();     

        $img=null;
        $max;

        foreach($reviews as $r){

            if ($r->idImg!=null){
                if ($img==null){
                    $img=$r->idImg;
                    $max=$r->upCount-$r->downCount;
                }
                else {   

                    if ($max<$r->upCount-$r->downCount){
                        $img=$r->idImg;
                        $max=$r->upCount-$r->downCount;
                    }  
                }

            }

        }

        if ($img==null)
            return null;

        $query = $this->db->query("select * from image where idImg=".$img);


        return base_url()."uploads/".$query->result()[0]->img;


        return null;
    }
}