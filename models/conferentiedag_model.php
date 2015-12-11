<?php
Class Conferentiedag_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('datum', 'asc');
        $query = $this->db->get('conferentieDag');
        $conferentieDagen =  $query->result();
        
        $this->load->model('conferentie_model');
        foreach ($conferentieDagen as $conferentieDag) {
            $conferentieDag->conferentie = $this->conferentie_model->get($conferentieDag->conferentieId);
        }
        return $conferentieDagen;
        
    }
    
    //Zoeken op conferentieID
    public function getAllByConference($conferentieID) {
        $this->db->order_by('datum', 'asc');
        $query = $this->db->get_where('conferentieDag', array('conferentieId' => $conferentieID));
        $conferentieDagen = $query->result();
        
        $this->load->model('conferentie_model');
        $this->load->model('activiteit_model');
        foreach ($conferentieDagen as $conferentieDag) {
            $conferentieDag->conferentie = $this->conferentie_model->get($conferentieDag->conferentieId);
            $conferentieDag->activiteiten = $this->activiteit_model->getByConferenceDay($conferentieDag->id);
        }        
        return $conferentieDagen;
    }
    
    //Zoeken op conferentieID
    public function getAllNotSignedByConference($conferentieID, $userID) {
        $sql = "select cD.* from conferentieDag cD inner join conferentie c on cD.conferentieID = c.id where cD.id not in (select iD.conferentieDagId from inschrijvingDag iD where iD.deelnemerId = $userID) and c.id = $conferentieID order by cD.datum";
        $query = $this->db->query($sql);
        $conferentieDagen = $query->result();
        
        $this->load->model('conferentie_model');
        $this->load->model('activiteit_model');
        foreach ($conferentieDagen as $conferentieDag) {
            $conferentieDag->conferentie = $this->conferentie_model->get($conferentieDag->conferentieId);
            $conferentieDag->activiteiten = $this->activiteit_model->getByConferenceDay($conferentieDag->id);
        }        
        return $conferentieDagen;
    }
    
    public function getByDate($date) {
        $query = $this->db->get_where('conferentieDag', array('datum' => $date));
        $conferentieDag = $query->row();
        
        $this->load->model('conferentie_model');
        
        $conferentieDag->conferentie = $this->conferentie_model->get($conferentieDag->conferentieId);
        
        return $conferentieDag;
    }
    
    //Zoeken op gewone ID
    public function get($id) {
        $query = $this->db->get_where('conferentieDag', array('id' => $id));
        $conferentieDag = $query->row();
        
        $this->load->model('conferentie_model');
        $conferentieDag->conferentie = $this->conferentie_model->get($conferentieDag->conferentieId);
        
        return $conferentieDag;
    }
        
    //Insert
    public function insert($conferentieDag) {
        if ($this->getByDate($conferentieDag->datum) != null) {
            return '0';
        }
        $this->db->where('id', $conferentieDag->id);
        $this->db->insert('conferentieDag', $conferentieDag);
        return $this->db->affected_rows();
    }
    
    //Update
    public function update($conferentieDag) {
        $this->db->where('id', $conferentieDag->id);
        $this->db->update('conferentieDag', $conferentieDag);
        return $this->db->affected_rows();
    }
    
    //Delete
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('conferentieDag');
        return $this->db->affected_rows();
    }
}