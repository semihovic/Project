<?php

class Inschrijvingsessie_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get('inschrijvingSessie');
        return $query->result();
    }
    
    public function getPerDeelnemer($id)
    {  
        $this->db->where('deelnemerId', $id);
        $query = $this->db->get('inschrijvingSessie');
        return $query->row();
    }
    
    public function getPerSessie($id)
    {  
        $this->db->where('sessieId', $id);
        $query = $this->db->get('inschrijvingSessie');
        return $query->row();
    }
   
    // Insert/Delete/Update statements
    public function insert($inschrijvingSessie) {
        $this->db->insert('inschrijvingSessie', $inschrijvingSessie);
        return $this->db->affected_rows();
    }
    
    public function update($inschrijvingSessie) {
        $this->db->where('id', $inschrijvingSessie->id);
        $this->db->update('inschrijvingSessie', $inschrijvingSessie);
        return $this->db->affected_rows();
    }
    
    public function delete($inschrijvingSessie) {
        $this->db->where('id', $inschrijvingSessie->id);
        $this->db->delete('inschrijvingSessie', $inschrijvingSessie);
        return $this->db->affected_rows();
    }
    
}