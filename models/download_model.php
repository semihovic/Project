<?php

class Download_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('download');
        return $query->result();
    }

    public function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('download');
        return $query->row();
    }

    public function getPerConference($id) {
        $this->db->where('conferentieId', $id);
        $query = $this->db->get('download');
        return $query->result();
    }

// Insert/Delete/Update statements
    public function insert($land) {
        $this->db->insert('download', $land);
        return $this->db->insert_id();
    }

    public function update($download) {
        $this->db->where('id', $download->id);
        $this->db->update('download', $download);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('download');
        return $this->db->affected_rows();
    }

}
