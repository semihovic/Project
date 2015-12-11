<?php

class Inschrijvingactiviteit_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get('inschrijvingActiviteit');
        return $query->result();
    }

    public function getPerParticipant($id) {
        $this->db->where('deelnemerId', $id);
        $query = $this->db->get('inschrijvingActiviteit');
        $activities = $query->result();
        
        //Models laden
        $this->load->model('activiteit_model');
        //Object in activities stoppen
        foreach ($activities as $activity) {
            $activity->activity = $this->activiteit_model->get($activity->activiteitId);
        }
        return $activities;
    }

    public function getPerActiviteit($id) {
        $this->db->where('activiteitId', $id);
        $query = $this->db->get('inschrijvingActiviteit');
        return $query->row();
    }

    // Insert/Delete/Update statements
    public function insert($inschrijvingActiviteit) {
        $this->db->insert('inschrijvingActiviteit', $inschrijvingActiviteit);
        return $this->db->affected_rows();
    }

    public function update($inschrijvingActiviteit) {
        $this->db->where('id', $inschrijvingActiviteit->id);
        $this->db->update('inschrijvingActiviteit', $inschrijvingActiviteit);
    }

    public function delete($inschrijvingActiviteit) {
        $this->db->where('id', $inschrijvingActiviteit->id);
        $this->db->delete('inschrijvingActiviteit', $inschrijvingActiviteit);
    }

}
