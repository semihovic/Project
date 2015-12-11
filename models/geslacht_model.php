<?php
Class Geslacht_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $query = $this->db->get('geslacht');
        return $query->result();
    }
    
    public function get($id) {
        $query = $this->db->get_where('geslacht', array('id' => $id));
        return $query->row();
    }
    
    
    
   
    // Insert/Delete/Update statements
    public function insert($geslacht) {
        $this->db->insert('geslacht', $geslacht);
        return $this->db->insert_id();
    }
    
    public function update($geslacht) {
        $this->db->where('id', $geslacht->id);
        $this->db->update('geslacht', $geslacht);
        return $this->db->affected_rows();
    }
    
    public function delete($geslacht) {
        $this->db->where('id', $geslacht->id);
        $this->db->delete('geslacht', $geslacht);
        return $this->db->affected_rows();
    }
}