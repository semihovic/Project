<?php
Class Activiteit_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('activiteit');
        $activiteiten=  $query->result();
        
        $this->load->model('conferentiedag_model');
        foreach ($activiteiten as $activiteit) {
            $activiteit->conferenceDay = $this->conferentiedag_model->get($activiteit->conferentieDagId); 
        }
        return $activiteiten;
    }
    
    public function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('activiteit');
        $activiteit = $query->row();
        
        $this->load->model('conferentiedag_model');
        $activiteit->conferenceDay = $this->conferentiedag_model->get($activiteit->conferentieDagId);
        
        return $activiteit;

    }
    
    public function getAllActivitiesConference($conferenceID) {
        $this->db->select('activiteit.*');
        $this->db->from('activiteit');
        $this->db->join('conferentieDag', 'activiteit.conferentieDagId = conferentieDag.id');
        $this->db->where('conferentieDag.conferentieId', $conferenceID);
        
        $query = $this->db->get();
        $activiteiten =  $query->result();
        foreach ($activiteiten as $activiteit) {
            $activiteit->conferentieDag = $this->conferentiedag_model->get($activiteit->conferentieDagId);
        }
        return $activiteiten;
       
    }
    
    public function getAllUnsignedByConference($conferenceID, $userID) {
        $sql = "select a.* from activiteit a inner join conferentieDag cD on a.conferentieDagId = cD.id inner join conferentie c on cD.conferentieId = c.id where a.id not in (select iA.activiteitId from inschrijvingActiviteit iA where iA.deelnemerId = $userID) and cD.conferentieId = $conferenceID";
        $query = $this->db->query($sql);
        $activiteiten = $query->result();
        foreach ($activiteiten as $activiteit) {
            $activiteit->conferentieDag = $this->conferentiedag_model->get($activiteit->conferentieDagId);
        }
        return $activiteiten;
    }
    
    public function getByConferenceDay($id) {
        $this->db->order_by('beginuur', 'asc');
        $this->db->where('conferentieDagId', $id);
        $query = $this->db->get('activiteit');
        $activiteiten = $query->result();
        
        $this->load->model('conferentiedag_model');
        foreach ($activiteiten as $activiteit) {
            $activiteit->conferentieDag = $this->conferentiedag_model->get($activiteit->conferentieDagId);
        }
        
        return $activiteiten;
    }
    
    
    
    
    
    // Insert/Delete/Update statements
    public function insert($activiteit) {
        $this->db->insert('activiteit', $activiteit);
        return $this->db->insert_id();
    }
    
    public function update($activiteit) {
        $this->db->where('id', $activiteit->id);
        $this->db->update('activiteit', $activiteit);
        return $this->db->affected_rows();
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('activiteit');
        return $this->db->affected_rows();
    }
}