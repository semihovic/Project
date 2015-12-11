<?php
Class Aanspreking_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $query = $this->db->get('aanspreking');
        return $query->result();
    }
    
    public function get($id) {
        $query = $this->db->get_where('aanspreking', array('id' => $id));
        return $query->row();
    }
    
    
    
   
    // Insert/Delete/Update statements
    public function insert($aanspreking) {
        $this->db->insert('aanspreking', $aanspreking);
        return $this->db->insert_id();
    }
    
    public function update($aanspreking) {
        $this->db->where('id', $aanspreking->id);
        $this->db->update('aanspreking', $aanspreking);
        return $this->db->affected_rows();
    }
    
    public function delete($aanspreking) {
        $this->db->where('id', $aanspreking->id);
        $this->db->delete('aanspreking', $aanspreking);
        return $this->db->affected_rows();
    }
}