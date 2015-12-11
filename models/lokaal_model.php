<?php

class Lokaal_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('lokaal');
        $lokalen = $query->result();
        
        //Andere model laden om OO te programmeren
        $this->load->model('locatie_model');
        
        //Alle lokalen afgaan om hun lokaal in het object te plaatsen
        foreach ($lokalen as $lokaal) {
            $lokaal->locaties = $this->locatie_model->get($lokaal->locatieId);
        }
        return $lokalen;
    }
    
    public function get($id)
    {  
        $this->db->where('id', $id);
        $query = $this->db->get('lokaal');
        $lokaal = $query->row();
        
        //Andere model laden om OO te programmeren
        $this->load->model('locatie_model');
        $lokaal->locatie = $this->locatie_model->get($lokaal->locatieId);
        
        return $lokaal;
    }
    
    // Insert/Delete/Update statements
    public function insert($lokaal) {
        $this->db->insert('lokaal', $lokaal);
        return $this->db->insert_id();
    }
    
    public function update($lokaal) {
        $this->db->where('id', $lokaal->id);
        $this->db->update('lokaal', $lokaal);
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('lokaal');
    }
    
    public function getAllByLocationId($id) {
        $this->db->where('locatieId',$id);
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('lokaal');
        $rooms = $query->result();
        
        //Model laden om OO te programmeren
        $this->load->model('locatie_model');
        
        //OO Land gegevens in Locatie zetten
        foreach ($rooms as $room) {
            $room->locatie = $this->locatie_model->get($room->locatieId);
        }
        return $rooms;
    }
}