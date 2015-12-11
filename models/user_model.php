<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Alle deelnemers
    function getAll() {
        $this->db->order_by('achternaam', 'asc');
        $query = $this->db->get('deelnemer');
        $deelnemers = $query->result();
        //Andere model laden voor gegevens
        $this->load->model('niveau_model');
        foreach ($deelnemers as $deelnemer) {
            $deelnemer->niveau = $this->niveau_model->get($deelnemer->niveauId);
        }
        return $deelnemers;
    }

    //Een deelnemer
    function get($id) {
        // geef user-object met opgegeven $id   
        $this->db->where('id', $id);

        $query = $this->db->get('deelnemer');
        $deelnemer = $query->row();

        //Andere model laden voor gegevens
        $this->load->model('niveau_model');
        $deelnemer->niveau = $this->niveau_model->get($deelnemer->niveauId);

        return $deelnemer;
    }

    function getAllSpeakers() {
        $this->db->order_by('achternaam', 'asc');
        $where = "niveauId = '2' OR niveauId = '3'";
        $this->db->where($where);
        $query = $this->db->get_where('deelnemer');
        $deelnemers = $query->result();
        //Andere model laden voor gegevens
        $this->load->model('niveau_model');
        foreach ($deelnemers as $deelnemer) {
            $deelnemer->niveau = $this->niveau_model->get($deelnemer->niveauId);
        }
        return $deelnemers;
    }

    //Usernaam checken
    function checkUsername($usernaam) {
        // geef user-object met opgegeven $id   
        $this->db->where('usernaam', $usernaam);

        $query = $this->db->get('deelnemer');
        $deelnemer = $query->row();

        return $deelnemer;
    }

    function checkEmail($email) {
        // geef user-object met opgegeven $id   
        $this->db->where('email', $email);

        $query = $this->db->get('deelnemer');
        $deelnemer = $query->row();

        return $deelnemer;
    }

    //Account krijgen met behulp van email en password
    function getAccount($email, $paswoord) {
        // geef user-object met $email en $password EN geactiveerd = 1
        $this->db->where('email', $email);
        $this->db->where('paswoord', sha1($paswoord));
        $this->db->where('geactiveerd', 1);
        $query = $this->db->get('deelnemer');
        if ($query->num_rows() == 1) {
            $deelnemer = $query->row();
            //Andere model laden voor gegevens
            $this->load->model('niveau_model');
            $deelnemer->niveau = $this->niveau_model->get($deelnemer->niveauId);
            //Returnen
            return $deelnemer;
        } else {
            return null;
        }
    }

    function getLanden() {
        $this->db->select('id, naam');
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('land');
        if ($query) {
            $query = $query->result_array();
            return $query;
        }
    }

    function getAanspreking() {
        $this->db->select('id, naam');
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('aanspreking');
        if ($query) {
            $query = $query->result_array();
            return $query;
        }
    }

    function emailVrij($email) {
        // is email al dan niet aanwezig
        $this->db->where('email', $email);
        $query = $this->db->get('deelnemer');
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert($aanspreking, $naam, $achternaam, $adres, $woonplaats, $landId, $geslachtId, $usernaam, $email, $paswoord, $random) {
        // voeg nieuwe user toe
        $user = new stdClass();
        $user->voornaam = $naam;
        $user->achternaam = $achternaam;
        $user->geslachtId = $geslachtId;
        $user->adres = $adres;
        $user->woonplaats = $woonplaats;
        $user->landId = $landId;
        $user->usernaam = $usernaam;
        $user->email = $email;
        $user->paswoord = sha1($paswoord);
        $user->niveauId = 3;
        $user->geactiveerd = 0;
        $user->generatedKey = $random;
        $user->aansprekingId = $aanspreking;
        if ($geslachtId == 1) {
            $user->profielfoto = "profile_male.png";
        } else {
            $user->profielfoto = "profile_female.png";
        }

        $this->db->insert('deelnemer', $user);
        return $this->db->insert_id();
    }

    function update($user) {
        $this->db->where('id', $user->id);
        $this->db->update('deelnemer', $user);
        return $this->db->affected_rows();
    }

    function delete($user) {
        $this->db->where('id', $user->id);
        $this->db->delete('deelnemer', $user);
        return $this->db->affected_rows();
    }

    function activeer($id, $random) {
        $this->db->where('id', $id);
        $this->db->where('generatedKey', $random);
        $query = $this->db->get('deelnemer');
        if ($query->num_rows() != 0) {
            $user = new stdClass();
            $user->geactiveerd = 1;
            $this->db->where('id', $id);
            $this->db->update('deelnemer', $user);
        } else {
            redirect('/user/fout');
        }
    }

    function resetPassword($email) {

        $wachtwoord = random_string('alnum', 8);

        $user->paswoord = sha1($wachtwoord);
        $this->db->where('email', $email);
        $this->db->update('deelnemer', $user);

        return $wachtwoord;
    }

}

?>