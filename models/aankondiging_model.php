<?php
Class Aankondiging_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
       // $this->db->order_by('id', 'desc');
        $query = $this->db->query("SELECT * FROM aankondiging order by id desc LIMIT 3;");
        
        //$query = $this->db->get('aankondiging');
        
        $aankondigingen =  $query->result();
        
        $this->load->model('conferentie_model');
        
        foreach ($aankondigingen as $aankondiging) {
            $aankondiging->conferentie = $this->conferentie_model->get($aankondiging->conferentieId);
        }
        
        return $aankondigingen;
    }
    
    public function get($id) {
        $query = $this->db->get_where('aankondiging', array('id' => $id));
        
        $aankondiging = $query->row();
        
        $this->load->model('conferentie_model');
        
        $aankondiging->conferentie = $this->conferentie_model->get($aankondiging->conferentieId);
        
        return $aankondiging;
    }
    
    public function getPerConferentie($id) {
        $this->db->order_by('titel', 'asc');
        $query = $this->db->get_where('aankondiging', array('conferentieId' => $id));
        
        $aankondigingen =  $query->result();
        
        $this->load->model('conferentie_model');
        
        foreach ($aankondigingen as $aankondiging) {
            $aankondiging->conferentie = $this->conferentie_model->get($aankondiging->conferentieId);
        }
        
        return $aankondigingen;
    }
    
    
    
    
    // Insert/Delete/Update statements
    public function insert($aankondiging) {
        $this->db->insert('aankondiging', $aankondiging);
        return $this->db->insert_id();
    }
    
    public function update($aankondiging) {
        $this->db->where('id', $aankondiging->id);
        $this->db->update('aankondiging', $aankondiging);
        return $this->db->affected_rows();
    }
    
    public function delete($aankondiging) {
        $this->db->where('id', $aankondiging->id);
        $this->db->delete('aankondiging', $aankondiging);
        return $this->db->affected_rows();
    }
}