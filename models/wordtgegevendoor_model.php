<?php

class Wordtgegevendoor_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $query = $this->db->get('wordtGegevenDoor');
        $gegevenDoor = $query->result();
        
        //Andere model laden om OO te programmeren
        $this->load->model('user_model');
        
        foreach ($gegevenDoor as $gD) {
            $gD->deelnemer = $this->user_model->get($gD->deelnemerId);
        }

        return $gegevenDoor;
    }
    
    // Een object uit de database halen met behulp van Deelnemer
    public function get($id) {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get_where('wordtGegevenDoor', array('deelnemerId' => $id));
        $gegevenDoor = $query->result();
        
        //Andere model laden om OO te programmeren
        $this->load->model('user_model');
        foreach ($gegevenDoor as $gD) {
            $gD->deelnemer = $this->user_model->get($gD->deelnemerId);
        }

        return $gegevenDoor;
    }
    
    //Een object uit de database halen met behulp van Sessie
    public function get2($id) {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get_where('wordtGegevenDoor', array('sessieId' => $id));
        $gegevenDoor = $query->result();
        
        //Andere model laden om OO te programmeren
        $this->load->model('user_model');
        
        foreach ($gegevenDoor as $gD) {
            $gD->deelnemer = $this->user_model->get($gD->deelnemerId);
        }

        return $gegevenDoor;
    }
    
    //Een object uit de database halen met behulp van Sessie en DeelnemerId
    public function get3($id, $id2) {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get_where('wordtGegevenDoor', array('sessieId' => $id, 'deelnemerId' => $id2));
        $gegevenDoor = $query->result();
        
        //Andere model laden om OO te programmeren
        $this->load->model('user_model');
        
        foreach ($gegevenDoor as $gD) {
            $gD->deelnemer = $this->user_model->get($gD->deelnemerId);
        }

        return $gegevenDoor;
    }
    
    
    
     // Insert/Delete/Update statements
    public function insert($object) {
        $this->db->insert('wordtGegevenDoor', $object);
        return $this->db->insert_id();
    }
    
    public function updateviaDeelnemer($object) {
        $this->db->where('id', $object->deelnemerId);
        $this->db->update('wordtGegevenDoor', $object);
    }
    
    public function updateviaSessie($object) {
        $this->db->where('id', $object->sessieId);
        $this->db->update('wordtGegevenDoor', $object);
    }
    
    public function deleteThroughSpeakerAndSession($id, $sessionId) {
        $this->db->where(array('deelnemerId' => $id, 'sessieId' => $sessionId));
        $this->db->delete('wordtGegevenDoor');
    }
    
    public function deleteThroughSession($id) {
        $this->db->where('sessieId', $id);
        $this->db->delete('wordtGegevenDoor');
    }
    
}