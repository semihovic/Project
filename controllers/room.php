<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Room extends CI_Controller {

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
        $this->load->model('lokaal_model');
        $this->load->model('conferentie_model');
        
        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();
        
        $id = $this->session->userdata('managing_conference');
        $conference = $this->conferentie_model->get($id);

        // Laden Template Partials + View
        $data['user'] = $user;
        $data['title'] = "Manage Conference - Add Room";
        $data['conference'] = $conference;
        $partials = array('header' => 'admin_header',
            'content' => 'admin/add_room',
            'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function confirmAdd() {
        // kijken of user is ingelogd en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null || $user->niveauId != 1) {
            redirect('home/login');
        }

        // laden models
        $this->load->model('lokaal_model');

        // ophalen gegevens formulier
        $room = new stdClass();
        $room->naam = $this->input->post('name');
        $room->locatieId = $this->input->post('locationId');
        

        // insert hotel
        $this->lokaal_model->insert($room);

        // manage page oproepen
        redirect('manage/rooms');
    }

    public function delete($id) {
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
            redirect('manage/hotels');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/hotels');
            }
        }

        // laden models
        $this->load->model('lokaal_model');

        // Archiveren
        $this->lokaal_model->delete($id);

        // Redirect naar Admin Index
        redirect('manage/rooms');
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
        $roomId = $this->input->post('roomId');
        $naam = $this->input->post('room');
        //Model laden
        $this->load->model('lokaal_model');
        //Object ophalen
        $room = $this->lokaal_model->get($roomId);
        //aanpassen
        $room->naam = $naam;
        
        $this->lokaal_model->update($room);
        
        $roomNew = $this->lokaal_model->get($roomId);
        
        echo json_encode($roomNew);
    }
    
    
    
}
