<?php
Class Sessie_model extends CI_Model {
    
    function __construct() {
       parent::__construct();
    }
    
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('beginuur', 'asc');
        $query = $this->db->get('sessie');
        $sessies =  $query->result();
        
        //Andere models laden voor OO programmeren
        $this->load->model('conferentiedag_model');
        $this->load->model('lokaal_model');
        $this->load->model('wordtgegevendoor_model');
        foreach ($sessies as $sessie) {
            $sessie->conferentieDag = $this->conferentie_model->get($sessie->conferentieDagId);
            $sessie->lokaal = $this->lokaal_model->get($sessie->lokaalId);
            $sessie->gegevenDoor = $this->wordtgegevendoor_model->get2($sessie->id);
        }
        
        return $sessies;
    }
    
    public function get($id) {
        $query = $this->db->get_where('sessie', array('id' => $id));
        $sessie = $query->row();
        
        //Andere models laden voor OO programmeren
        $this->load->model('conferentiedag_model');
        $this->load->model('lokaal_model');
        $this->load->model('wordtgegevendoor_model');
        
        $sessie->conferentieDag = $this->conferentiedag_model->get($sessie->conferentieDagId);
        $sessie->lokaal = $this->lokaal_model->get($sessie->lokaalId);
        $sessie->gegevenDoor = $this->wordtgegevendoor_model->get2($sessie->id);
         
        return $sessie;
    }
    public function getSessionsConferenceDay($conferenceDayId) {
        $this->db->order_by("beginuur", "asc");
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('sessie', array('conferentieDagId' => $conferenceDayId));
        $sessies =  $query->result();
        
        //Andere models laden voor OO programmeren
        $this->load->model('conferentiedag_model');
        $this->load->model('lokaal_model');
        $this->load->model('wordtgegevendoor_model');
        foreach ($sessies as $sessie) {
            $sessie->conferentieDag = $this->conferentiedag_model->get($sessie->conferentieDagId);
            $sessie->lokaal = $this->lokaal_model->get($sessie->lokaalId);
            $sessie->gegevenDoor = $this->wordtgegevendoor_model->get2($sessie->id);
        }

        return $sessies;
    }
    
    
    public function getGoedgekeurdeSessies() { 
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('sessie', array('statusId' => 1));
        $sessies = $query->result();
        
         //Andere models laden voor OO programmeren
        $this->load->model('conferentiedag_model');
        $this->load->model('lokaal_model');
        foreach ($sessies as $sessie) {
            $sessie->conferentie = $this->conferentiedag_model->get($sessie->conferentieDagId);
            $sessie->lokaal = $this->lokaal_model->get($sessie->lokaalId);
        }
        
        return $sessies;
    }
    
    public function getPendingSessies() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('sessie', array('statusId' => 2));
        $sessies =  $query->result();
        
        //Andere models laden voor OO programmeren
        $this->load->model('conferentie_model');
        $this->load->model('lokaal_model');
        foreach ($sessies as $sessie) {
            $sessie->conferentie = $this->conferentie_model->get($sessie->conferentieDagId);
            $sessie->lokaal = $this->lokaal_model->get($sessie->lokaalId);
        }
        
        return $sessies;
    }
    
    
    
    function insert($sessie) {
        $this->db->insert('sessie', $sessie);
        return $this->db->insert_id();
    }
    
    function update($sessie) {
        $this->db->where('id', $sessie->id);
        $this->db->update('sessie', $sessie);
    }
    
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('sessie');
    }
}
