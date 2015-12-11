<?php
Class Betaling_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('deelnemerId', 'asc');
        $query = $this->db->get('betaling');
        return $query->result();
    }
    
    public function get($id) {
        $query = $this->db->get_where('id', array('id' => $id));
        return $query->row();
    }
    
    public function getByDeelnemer($deelnemerID) {
        $this->db->order_by('prijs', 'asc');
        $query = $this->db->get_where('betaling', array('deelnemerid' => $deelnemerID));
        return $query->result();
    }
    
    public function getUnpaidByDeelnemer($deelnemerId) {
        $this->db->order_by('prijs', 'asc');
        $query = $this->db->get_where('betaling', array('deelnemerid' => $deelnemerId,'heeftBetaald' => 0));
        $betalingen = $query->result();
        
        $this->load->model("inschrijvingdag_model");
        foreach ($betalingen as $betaling) {
            $inschrijvingDagen = $this->inschrijvingdag_model->getPerBetaling($betaling->id);
            
            $dag = $inschrijvingDagen[0];
            $betaling->conferentie = $dag->conferentieDag->conferentie;
            
        }
        return $betalingen;
    }
    
//    public function getTotalUnpaidByDeelnemer($deelnemerId) {
//        $this->db->select_sum("prijs");
//        $query = $this->db->get_where('betaling',array('deelnemerid' => $deelnemerId,'heeftBetaald' => 0 ));
//        return $query->row();
//    }
    
    
    
    
    // Insert/Delete/Update statements
    public function insert($betaling) {
        $this->db->insert('betaling', $betaling);
        return $this->db->insert_id();
    }
    
    public function update($betaling) {
        $this->db->where('id', $betaling->id);
        $this->db->update('betaling', $betaling);
    }
    
    public function delete($betaling) {
        $this->db->where('id', $betaling->id);
        $this->db->delete('betaling', $betaling);
    }
}