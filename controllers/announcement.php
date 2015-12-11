<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Announcement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }

    public function add() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        // laden models
        $this->load->model('conferentie_model');
        $this->load->model('aankondiging_model');

        //Sessie ophalen
        $conferentieID = $this->session->userdata('managing_conference');
        //Indien sessie niet bestaat, terug naar hoofdpagina Admin
        if ($conferentieID == null) {
            redirectt('admin/index');
        }

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();
        
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Announcement';

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_announcement', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function modifyConfirm() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }
        
        //Gegevens ophalen
        $id = $this->input->post('id');
        $titel = $this->input->post('titel');
        $omschrijving = $this->input->post('omschrijving');

        //Controleren of er een id is, anders redirecten. Gebruiker kan nooit hier op komen zonder ID.
        //Als er geen ID is, heeft hij de url zelf zo ingetypd.
        $conferentieID = $this->session->userdata('managing_conference');
        //Als conferentieID(sessie) geen value heeft, teruggaan om error te verkomen
        if ($conferentieID == null) {
            redirect('admin/index');
        }

        //Gegevens in object zetten
        $aankondiging = new stdClass();
        $aankondiging->titel = $titel;
        $aankondiging->conferentieId = $conferentieID;
        $aankondiging->beschrijving = $omschrijving;
        $this->load->model('aankondiging_model');

        //Indien id == null, toevoegen, anders aanpassen
        if ($id == "0") {
            $this->aankondiging_model->insert($aankondiging);
        } else {
            $aankondiging->id = $id;
            $this->aankondiging_model->update($aankondiging);
        }

        redirect('manage/announcements');
    }

    public function modify($id) {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }
        
        //Controleren of er een id is, anders redirecten. Gebruiker kan nooit hier op komen zonder ID.
        //Als er geen ID is, heeft hij de url zelf zo ingetypd.
        if ($id == null) {
            redirect('manage/announcements');
        }

        if (!is_numeric($id)) {
            redirect('manage/announcements');
        }

        // laden models
        $this->load->model('conferentie_model');
        $this->load->model('aankondiging_model');

        $conferentieID = $this->session->userdata('managing_conference');
        if ($conferentieID == null) {
            redirectt('admin/index');
        }

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();
        
        $data['announcement'] = $this->aankondiging_model->get($id);
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Announcement';

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_announcement', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function delete($id) {
        //Kijken of er wel een id is
        if ($id == null) {
            redirect('admin/index');
        }

        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        // laden models
        $this->load->model('conferentie_model');
        $this->load->model('aankondiging_model');

        //Id van announcement laden
        $announcement = $this->aankondiging_model->get($id);

        //Announcement object aanmaken en verwijderen
        $aankondiging = new stdClass();
        $aankondiging->id = $announcement;
        $this->aankondiging_model->delete($announcement);

        //Terug naar overzicht met announcements
        redirect('manage/announcements');
    }

}
