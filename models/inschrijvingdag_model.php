<?php

class Inschrijvingdag_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get('inschrijvingDag');
        return $query->result();
    }
    
    public function getPerDeelnemer($id)
    {  
        $this->db->where('deelnemerId', $id);
        $query = $this->db->get('inschrijvingDag');
        
        $inschrijvingen = $query->result();
        
        $this->load->model('conferentiedag_model');
        foreach ($inschrijvingen as $inschrijving) {
            $inschrijving->conferentieDag = $this->conferentiedag_model->get($inschrijving->conferentieDagId);
        }
        return $inschrijvingen;
    }
    
    public function getPerParticipant($id)
    {  
        $this->db->where('deelnemerId', $id);
        $query = $this->db->get('inschrijvingDag');
        
        $inschrijvingen = $query->result();
        
        $this->load->model('conferentiedag_model');
        foreach ($inschrijvingen as $inschrijving) {
            $inschrijving->conferentieDag = $this->conferentiedag_model->get($inschrijving->conferentieDagId);
        }
        return $inschrijvingen;
    }
    
     public function getPerBetaling($id)
    {  
        $this->db->where('betalingId', $id);
        $query = $this->db->get('inschrijvingDag');
        
        $inschrijvingen = $query->result();
        
        $this->load->model('conferentiedag_model');
        foreach ($inschrijvingen as $inschrijving) {
            $inschrijving->conferentieDag = $this->conferentiedag_model->get($inschrijving->conferentieDagId);
        }
        return $inschrijvingen;
    }
    
    public function getPerConferentieDag($id)
    {  
        $this->db->where('conferentieDagId', $id);
        $query = $this->db->get('inschrijvingDag');
        return $query->row();
    }
   
    // Insert/Delete/Update statements
    public function insert($inschrijvingDag) {
        $this->db->insert('inschrijvingDag', $inschrijvingDag);
        return $this->db->affected_rows();
    }
    
    public function update($inschrijvingDag) {
        $this->db->where('id', $inschrijvingDag->id);
        $this->db->update('inschrijvingDag', $inschrijvingDag);
        return $this->db->affected_rows();
    }
    
    public function delete($inschrijvingDag) {
        $this->db->where('id', $inschrijvingDag->id);
        $this->db->delete('inschrijvingDag', $inschrijvingDag);
        return $this->db->affected_rows();
    }
    
}
