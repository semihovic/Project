<?php

//k
//session_start();

class Pricing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }
    
    public function modify() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            return;
        }
        if ($user->niveauId != 1) {
            return;
        }
        //Gegevens ophalen
        $conferentieDagId = $this->input->post('conferentieDagId');
        $prijs = $this->input->post('prijs');
        
        //Model laden
        $this->load->model('conferentiedag_model');
        
        //Object ophalen
        $conferentieDag = $this->conferentiedag_model->get($conferentieDagId);
        
        //Prijs aanpassen
        $conferentieDag->prijs = $prijs;
        
        $this->conferentiedag_model->update($conferentieDag);
        
        //Nieuw doorsturen
        $conferentieDagNew = $this->conferentiedag_model->get($conferentieDagId);
        
        echo json_encode($conferentieDagNew);
        
    }
}