<?php
Class Statussessie_model extends CI_Model {
    
    function __construct() {
       parent::__construct();
    }
    
    public function get($id) {
        $query = $this->db->get_where('statusSessie', array('id' => $id));
        return $query->row();
    }
    
}