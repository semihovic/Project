<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Proposal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }
    
    public function edit() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            return;
        }
        if ($user->niveauId != 1) {
            return;
        }
        
        //Gegevens ophalen
        $statusId = $this->input->post('statusId');
        $proposalId = $this->input->post('proposalId');
        
        //Model laden
        $this->load->model('voorstel_model');
        
        //Aanpassen
        $proposal = $this->voorstel_model->get($proposalId);
        $proposal->statusId = $statusId;
        
        $this->voorstel_model->update($proposal);
        $proposalNew = $this->voorstel_model->get($proposalId);
        
        echo json_encode($proposalNew);
    }
}