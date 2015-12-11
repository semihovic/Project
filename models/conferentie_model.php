<?php

Class Conferentie_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('conferentie');
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
            
        }
        return $conferenties;
    }

    public function getNonArchived() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('conferentie', array('gearchiveerd' => 0));
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }
        return $conferenties;
    }

    public function getArchived() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('conferentie', array('gearchiveerd' => 1));
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }
        return $conferenties;
    }

    public function getUnArchived() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('conferentie', array('gearchiveerd' => 0));
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }
        return $conferenties;
    }

    public function getAllActive() {
        $this->db->order_by('naam', 'asc');

        //Via de database de correcte status ophalen, zodat deze niet hardgecoord is
        $this->load->model('statusconferentie_model');
        $statussen = $this->statusconferentie_model->getAll();
        $activeID = null;
        foreach ($statussen as $status) {
            if ($status->naam == "Active") {
                $activeID = $status->id;
            }
        }

        $query = $this->db->get_where('conferentie', array('statusConferentieId' => $activeID));
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }
        return $conferenties;
    }

    public function get($id) {
        $query = $this->db->get_where('conferentie', array('id' => $id));
        $conferentie = $query->row();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);

        return $conferentie;
    }

    public function getActieveConferenties() {
        $this->db->where('statusConferentieId', '1');
        $query = $this->db->get('conferentie');
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locaties = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }

        return $conferenties;
    }

    public function getAllNonActive() {
        $query = $this->db->get_where('conferentie', array('statusConferentieId' => '2'));
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }

        return $conferenties;
    }

    //Insert
    public function insert($conferentie) {
        $this->db->insert('conferentie', $conferentie);
        return $this->db->affected_rows();
    }

    //Update
    public function update($conferentie) {
        $this->db->where('id', $conferentie->id);
        $this->db->update('conferentie', $conferentie);
        return $this->db->affected_rows();
    }

    //Archive
    function archive($conferentieId) {
        $this->db->where('id', $conferentieId);
        $conferentie = new stdClass();
        $conferentie->gearchiveerd = 1;
        $conferentie->statusConferentieId = 2;
        $this->db->update('conferentie', $conferentie);
        return $this->db->affected_rows();
    }
    
    function dearchive($conferentieId) {
        $this->db->where('id', $conferentieId);
        $conferentie = new stdClass();
        $conferentie->gearchiveerd = 0;
        $this->db->update('conferentie', $conferentie);
        return $this->db->affected_rows();
    }
    

    //Alle conferenties per land afhalen
    function GetAllActiveByCountry($countryId) {
        $this->db->where('statusConferentieId', '1');
        $this->db->where('landId', $countryId);
        $query = $this->db->get('conferentie');
        $conferenties = $query->result();

        $this->load->model('locatie_model');
        $this->load->model('statusconferentie_model');
        foreach ($conferenties as $conferentie) {
            $conferentie->locatie = $this->locatie_model->get($conferentie->locatieId);
            $conferentie->status = $this->statusconferentie_model->get($conferentie->statusConferentieId);
        }
        return $conferenties;
    }

}
