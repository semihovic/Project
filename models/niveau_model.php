<?php

class Niveau_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }

    //Alle deelnemers
    function getAll()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('niveau');
        return $query->result();
    }
    
    function get($id)
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get_where('niveau', array('id' => $id));
        return $query->row();
    }
}