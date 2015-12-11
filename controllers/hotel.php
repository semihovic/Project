<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Hotel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }

    public function add() {
        // kijken of user is ingelogd en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null || $user->niveauId != 1) {
            redirect('home/login');
        }

        // laden models
        $this->load->model('hotel_model');
        $this->load->model('conferentie_model');

        //Sessie bestaat?
        $id = $this->session->userdata('managing_conference');
        if ($id == null) {
            redirect('admin/index');
        }
        $conference = $this->conferentie_model->get($id);

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        // Laden Template Partials + View
        $data['user'] = $user;
        $data['title'] = "Manage Conference - Add Hotel";
        $data['conference'] = $conference;
        $partials = array('header' => 'admin_header',
            'content' => 'admin/add_hotel',
            'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function confirmAdd() {
        // kijken of user is ingelogd en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        } else {
            if ($user->niveauId != 1) {
                redirect('home/login');
            }
        }

        // laden models
        $this->load->model('hotel_model');

        // ophalen gegevens formulier
        $hotel = new stdClass();
        $hotel->naam = $this->input->post('name');
        $hotel->locatieId = $this->input->post('locationId');
        $hotel->adres = $this->input->post('address');
        $hotel->plaats = $this->input->post('city');
        $hotel->website = $this->input->post('website');
        $hotel->telefoon = $this->input->post('tel');
        $hotel->prijsPerNacht = $this->input->post('prijsNacht');

        // insert hotel
        $this->hotel_model->insert($hotel);

        // manage page oproepen
        redirect('manage/hotels');
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
            redirect('manage/hotels');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/hotels');
            }
        }

        // laden models
        $this->load->model('hotel_model');

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        // ophalen gewenste conferentie
        $data['hotel'] = $this->hotel_model->get($id);

        // Laden Template Partials + View
        $data['user'] = $user;
        $data['title'] = "Manage Conference - Modify Hotel";
        $partials = array('header' => 'admin_header',
            'content' => 'admin/modify_hotel',
            'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function confirmModify() {
        // kijken of user is ingelogd en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null || $user->niveauId != 1) {
            redirect('home/login');
        }

        // laden models
        $this->load->model('hotel_model');

        // ophalen gegevens formulier
        $hotel = new stdClass();
        $hotel->id = $this->input->post('id');
        $hotel->naam = $this->input->post('name');
        $hotel->locatieId = $this->input->post('locationId');
        $hotel->adres = $this->input->post('address');
        $hotel->plaats = $this->input->post('city');
        $hotel->website = $this->input->post('website');
        $hotel->telefoon = $this->input->post('tel');
        $hotel->prijsPerNacht = $this->input->post('prijsNacht');

        // update conferentie
        $this->hotel_model->update($hotel);

        // manage page oproepen
        redirect('manage/hotels');
    }

    public function delete($id) {
        // kijken of user is ingelogd en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null || $user->niveauId != 1) {
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
        $this->load->model('hotel_model');

        // Archiveren
        $this->hotel_model->delete($id);

        // Redirect naar Admin Index
        redirect('manage/hotels');
    }

}
