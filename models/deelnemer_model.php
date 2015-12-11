<?php
Class Deelnemer_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        
        $this->db->order_by('achternaam', 'asc');
        $query = $this->db->get('deelnemer');
        $deelnemers =  $query->result();
        
        $this->load->model('aanspreking_model');
        $this->load->model('geslacht_model');
        $this->load->model('niveau_model');
        foreach ($deelnemers as $deelnemer) {
            $deelnemer->aanspreking = $this->aanspreking_model->get($deelnemer->aansprekingId); 
            $deelnemer->geslacht = $this->geslacht_model->get($deelnemer->geslachtId); 
            $deelnemer->niveau = $this->niveau_model->get($deelnemer->niveauId); 
        }
        
        return $deelnemers;
    }
    
    public function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('deelnemer');
        $deelnemer = $query->row();
        
        $this->load->model('aanspreking_model');
        $this->load->model('geslacht_model');
        $this->load->model('niveau_model');
        
            $deelnemer->aanspreking = $this->aanspreking_model->get($deelnemer->aansprekingId); 
            $deelnemer->geslacht = $this->geslacht_model->get($deelnemer->geslachtId); 
            $deelnemer->niveau = $this->niveau_model->get($deelnemer->niveauId); 
        
        return $deelnemer;

    }
    
    public function getAllSpeakers($conferenceID) {
        $sql = "SELECT DISTINCT dL.* as deelnemer from conferentie c inner join conferentieDag cD on c.id = cD.conferentieId inner join sessie s on s.conferentieDagId = cD.id inner join wordtGegevenDoor w on w.sessieId = s.id inner join deelnemer dL on w.deelnemerId = dL.id  where c.id = $conferenceID";
        $query = $this->db->query($sql);
        return $query->result();
 }
    
    // Insert/Delete/Update statements
    public function insert($deelnemer) {
        $this->db->insert('deelnemer', $deelnemer);
        return $this->db->insert_id();
    }
    
    public function update($deelnemer) {
        $this->db->where('id', $deelnemer->id);
        $this->db->update('deelnemer', $deelnemer);
        return $this->db->affected_rows();
    }
    
    public function delete($deelnemer) {
        $this->db->where('deelnemer', $deelnemer->id);
        $this->db->delete('deelnemer', $deelnemer);
        return $this->db->affected_rows();
    }
}