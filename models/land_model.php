<?php

class Land_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('land');
        return $query->result();
    }
    
    public function get($id)
    {  
        $this->db->where('id', $id);
        $query = $this->db->get('land');
        return $query->row();
    }
    
    public function getByLand($land){
        $query = $this->db->select('*')->from('land')
        ->where("naam LIKE '%$land%'")->get();
        echo $query->row();
        return $query->row();
    }
    
    
    // Insert/Delete/Update statements
    public function insert($land) {
        $this->db->insert('lokaal', $land);
        return $this->db->insert_id();
    }
    
    public function update($land) {
        $this->db->where('id', $land->id);
        $this->db->update('lokaal', $land);
    }
    
    public function delete($land) {
        $this->db->where('id', $land->id);
        $this->db->delete('lokaal', $land);
    }
    
}