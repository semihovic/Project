<?php
Class Statusconferentie_model extends CI_Model {
    
    function __construct() {
       parent::__construct();
    }
    
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('statusConferentie');
        return $query->result();
  
    }
    
    public function get($id) {
        $query = $this->db->get_where('statusConferentie', array('id' => $id));
        return $query->row();
    }
    
    //Insert
    public function insert($status) {
        $this->db->where('id', $status->id);
        $this->db->insert('statusConferentie', $status);
        return $this->db->affected_rows();
    }
    
    //Update
    public function update($status) {
        $this->db->where('id', $status->id);
        $this->db->update('statusConferentie', $status);
        return $this->db->affected_rows();
    }
    
    //Delete
    function delete($status) {
        $this->db->where('id', $status->id);
        $this->db->delete('statusConferentie', $status);
        return $this->db->affected_rows();
    }
    
}