<?php
Class Forumonderwerp_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        
        $this->db->order_by('datum_creatie', 'asc');
        $query = $this->db->get('forumonderwerp');
        $forumonderwerpen =  $query->result();
        
        $this->load->model('sessie_model');
        $this->load->model('deelnemer_model');
        
        foreach ($forumonderwerpen as $forumonderwerp) {
            $forumonderwerp->reactie = $this->forumonderwerp_model->get($forumonderwerp->reactieId); 
            $forumonderwerp->sessie = $this->sessie_model->get($forumonderwerp->sessieId); 
            $forumonderwerp->deelnemer = $this->deelnemer_model->get($forumonderwerp->deelnemerId);  
        }
        
        return $forumonderwerp;
    }
    
    public function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('forumonderwerp');
        $forumonderwerp = $query->row();
        
        $this->load->model('sessie_model');
        $this->load->model('deelnemer_model');
        
        $forumonderwerp->reactie = $this->forumonderwerp_model->get($forumonderwerp->reactieId); 
        $forumonderwerp->sessie = $this->sessie_model->get($forumonderwerp->sessieId); 
        $forumonderwerp->deelnemer = $this->deelnemer_model->get($forumonderwerp->deelnemerId); 
        
        return $forumonderwerp;

    }
    
    // Insert/Delete/Update statements
    public function insert($forumonderwerp) {
        $this->db->insert('forumonderwerp', $forumonderwerp);
        return $this->db->insert_id();
    }
    
    public function update($forumonderwerp) {
        $this->db->where('id', $forumonderwerp->id);
        $this->db->update('forumonderwerp', $forumonderwerp);
        return $this->db->affected_rows();
    }
    
    public function delete($forumonderwerp) {
        $this->db->where('forumonderwerp', $forumonderwerp->id);
        $this->db->delete('forumonderwerp', $forumonderwerp);
        return $this->db->affected_rows();
    }
}