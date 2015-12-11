<?php
Class Stats_model extends CI_Model {
    
    function __construct()
    {
      parent::__construct();
    }
    
    //Deelnemer statistieken
    public function countAllUsers() {
        return $this->db->count_all('deelnemer');
    }
    
    public function countAllAdmins() {
        $this->db->where('niveauId', 1);
        return $this->db->count_all('deelnemer');
    }
    
    public function countAllSpeakers() {
        $this->db->where('niveauId', 2);
        return $this->db->count_all('deelnemer');
    }
    
    
    //Conferentie statistieken
    public function countAllConferences() {
        return $this->db->count_all('conferentie');
    }
    
    public function countAllArchived() {
        $this->db->where('Gearchiveerd', 1);
        return $this->db->count_all('conferentie');
    }
    
    public function countAllNonArchived() {
        $this->db->where('Gearchiveerd', 0);
        return $this->db->count_all('conferentie');
    }
    
    public function countAllActive() {
        $aantal = 0;
        $this->load->model('conferentie_model');
        $conferenties = $this->conferentie_model->getAllActive();
        foreach ($conferenties as $conf) {
            $aantal++;
        }
        return $aantal;
    }
    
    public function countAllNonActive() {
        $aantal = 0;
        $this->load->model('conferentie_model');
        $conferenties = $this->conferentie_model->getAllNonActive();
        foreach ($conferenties as $conf) {
            $aantal++;
        }
        return $aantal;
    }
    
    
    //Betalingen
    public function countAllPayments() {
        return $this->db->count_all('betaling');
    }
    
    public function countMoney() {
        $money = 0;
        
        //Alle betalingen
        $query = $this->db->get('betaling');
        $betalingen = $query->result();
        //Prijs omhoog doen
        foreach ($betalingen as $betaling) {
            $money += $betaling->prijs;
        }
        return $money;
    }
    
    public function getParticipantsConference($conferenceID) {
        $query = "SELECT COUNT( DISTINCT i.deelnemerId ) as deelnemers FROM inschrijvingDag i INNER JOIN conferentieDag cD ON i.conferentieDagId = cD.id WHERE cD.conferentieId = " . $conferenceID;
        $row = $this->db->query($query);
        return $row->row();
    }
    
    public function getParticipantsConferenceDay($conferenceDayId) {
        $query = "SELECT COUNT( DISTINCT i.deelnemerId ) as deelnemers FROM inschrijvingDag i WHERE i.conferentieDagId = " . $conferenceDayId;
        $row = $this->db->query($query);
        return $row->row();
    }
    
    public function getPaidPaymentsConference($conferenceID) {
        $query = "select COALESCE( SUM( b.prijs ) , 0 ) as prijs from inschrijvingDag d inner join betaling b on d.betalingId = b.id inner join conferentieDag cD on d.conferentieDagId = cD.id where b.heeftBetaald = 1 and cD.conferentieId = " . $conferenceID;
        $row = $this->db->query($query);
        return $row->row();
    }
    
    public function getPendingPaymentsConference($conferenceID) {
        $query = "select COALESCE( SUM( b.prijs ) , 0 ) as prijs from inschrijvingDag d inner join betaling b on d.betalingId = b.id inner join conferentieDag cD on d.conferentieDagId = cD.id where b.heeftBetaald = 0 and cD.conferentieId = " . $conferenceID;
        $row = $this->db->query($query);
        return $row->row();
    }
    
    
}