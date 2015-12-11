<?php

class Voorstel_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get('voorstel');
        $voorstellen = $query->result();
        
        //Model laden om OO te programmeren
        $this->load->model('deelnemer_model');
        $this->load->model('conferentie_model');
        $this->load->model('voorstelstatus_model');
        
        foreach ($voorstellen as $voorstel) {
            $voorstel->deelnemer = $this->deelnemer_model->get($voorstel->deelnemerId);
            $voorstel->conferentie = $this->conferentie_model->get($voorstel->conferentieId);
            $voorstel->status = $this->voorstelstatus_model->get($voorstel->statusId);
        }
        return $voorstellen;
    }
    
    public function get($id)
    {  
        $this->db->where('id', $id);
        $query = $this->db->get('voorstel');
        $voorstel = $query->row();
        
        //Model laden om OO te programmeren
        $this->load->model('deelnemer_model');
        $this->load->model('conferentie_model');
        $this->load->model('voorstelstatus_model');
        
        $voorstel->deelnemer = $this->deelnemer_model->get($voorstel->deelnemerId);
        $voorstel->conferentie = $this->conferentie_model->get($voorstel->conferentieId);
        $voorstel->status = $this->voorstelstatus_model->get($voorstel->statusId);
        
        return $voorstel;
    }
    
    public function getPerDeelnemer($id)
    {  
        $this->db->where('deelnemerId', $id);
        $query = $this->db->get('voorstel');
        $voorstellen = $query->result();
        
        //Model laden om OO te programmeren
        $this->load->model('deelnemer_model');
        $this->load->model('conferentie_model');
        $this->load->model('voorstelstatus_model');
        
        
        foreach ($voorstellen as $voorstel) {
            $voorstel->deelnemer = $this->deelnemer_model->get($voorstel->deelnemerId);
            $voorstel->conferentie = $this->conferentie_model->get($voorstel->conferentieId);
            $voorstel->status = $this->voorstelstatus_model->get($voorstel->statusId);
        }
        return $voorstellen;
    }
    
    
    public function getPerConference($id)
    {  
        $this->db->where('conferentieId', $id);
        $query = $this->db->get('voorstel');
        $voorstellen = $query->result();
        
        //Model laden om OO te programmeren
        $this->load->model('deelnemer_model');
        $this->load->model('conferentie_model');
        $this->load->model('voorstelstatus_model');
        
        foreach ($voorstellen as $voorstel) {
            $voorstel->deelnemer = $this->deelnemer_model->get($voorstel->deelnemerId);
            $voorstel->conferentie = $this->conferentie_model->get($voorstel->conferentieId);
            $voorstel->status = $this->voorstelstatus_model->get($voorstel->statusId);
        }
        return $voorstellen;
    }
    
    
    // Insert/Delete/Update statements
    public function insert($voorstel) {
        $this->db->insert('voorstel', $voorstel);
        return $this->db->insert_id();
    }
    
    public function update($voorstel) {
        $this->db->where('id', $voorstel->id);
        $this->db->update('voorstel', $voorstel);
    }
    
    public function delete($voorstel) {
        $this->db->where('id', $voorstel->id);
        $this->db->update('voorstel', $voorstel);
    }

}
