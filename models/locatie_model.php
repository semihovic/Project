<?php

class Locatie_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('locatie');
        $locaties = $query->result();
        
        //Model laden om OO te programmeren
        $this->load->model('land_model');
        
        //OO Land gegevens in Locatie zetten
        foreach ($locaties as $locatie) {
            $locatie->land = $this->land_model->get($locatie->landId);
        }
        return $locaties;
    }
    
    public function get($id)
    {  
        $this->db->where('id', $id);
        $query = $this->db->get('locatie');
        $locatie = $query->row();
        
        //Model laden om OO te programmeren
        $this->load->model('land_model');
        
        //Land gegevens OO in locatie zetten
        $locatie->land = $this->land_model->get($locatie->landId);
        return $locatie;
    }
    
    // Insert/Delete/Update statements
    public function insert($locatie) {
        $this->db->insert('locatie', $locatie);
        return $this->db->insert_id();
    }
    
    public function update($locatie) {
        $this->db->where('id', $locatie->id);
        $this->db->update('locatie', $locatie);
        return $this->db->affected_rows();
    }
    
    public function delete($locatie) {
        $this->db->where('id', $locatie->id);
        $this->db->delete('locatie', $locatie);
        return $this->db->affected_rows();
    }
    
}