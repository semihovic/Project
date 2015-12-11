<?php

class Voorstelstatus_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $query = $this->db->get('voorstelStatus');
        return $query->result();

    }
    
    public function get($id)
    {  
        $this->db->where('id', $id);
        $query = $this->db->get('voorstelStatus');
        return $query->row();

    }
    

    // Insert/Delete/Update statements
    public function insert($voorstelStatus) {
        $this->db->insert('voorstelStatus', $voorstelStatus);
        return $this->db->insert_id();
    }
    
    public function update($voorstelStatus) {
        $this->db->where('id', $voorstelStatus->id);
        $this->db->update('voorstelStatus', $voorstelStatus);
    }
    
    public function delete($voorstelStatus) {
        $this->db->where('id', $voorstelStatus->id);
        $this->db->update('voorstelStatus', $voorstelStatus);
    }

}
