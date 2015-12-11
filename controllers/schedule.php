<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schedule extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }

    public function addDay() {
        $success = true;
        $newDay = new stdClass();
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            $success = false;
        }
        if ($user->niveauId != 1) {
            $success = false;
        }
        //Via Ajax, dus niet redircten, maar gewoon niet toevoegen
        if ($success) {
            $id = $this->session->userdata('managing_conference');
            $datum = $this->input->post('day');

            $this->load->model('conferentiedag_model');

            $conferentieDag = new stdClass();
            $conferentieDag->conferentieId = $id;
            $conferentieDag->datum = $datum;
            $conferentieDag->prijs = 0;

            $newDay = new stdClass();

            if ($this->conferentiedag_model->insert($conferentieDag) == '0') {
                $newDay->success = false;
            } else {
                $newDay->success = true;
            }
        } else {
            $newDay->success = false;
        }


        echo json_encode($newDay);
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

        //Models laden
        $this->load->model('conferentiedag_model');
        $this->load->model('sessie_model');
        $this->load->model('activiteit_model');
        //Kijken of er geen sessies meer aan gebonden zijn 
        $sessies = $this->sessie_model->getSessionsConferenceDay($id);
        $activities = $this->activiteit_model->getAllActivitiesConference($id);

        //Kijken of er sessies/activities aan gebonden zijn
        if (count($sessies) == 0 && count($activities) == 0) {
            $this->conferentiedag_model->delete($id);
        }

        //Redirect terug naar current pagina
        redirect_back();
    }

    public function overview($id) {
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
            redirect('manage/schedule');
        }

        if (!is_numeric($id)) {
            redirect('manage/schedule');
        }

        //ConferentieDagId zetten als sessie, om er de volgende pagina aan te kunnen
        $this->session->set_userdata('conferenceDayId', $id);

        //Models laden
        $this->load->model('sessie_model');
        $this->load->model('conferentie_model');
        $this->load->model('conferentiedag_model');
        $this->load->model('stats_model');
        $this->load->model('activiteit_model');


        //Kijken of er geen sessies meer aan gebonden zijn 
        $sessions = $this->sessie_model->getSessionsConferenceDay($id);

        $conferentieID = $this->session->userdata('managing_conference');
        if ($conferentieID == null) {
            redirectt('admin/index');
        }
        $conference = $this->conferentie_model->get($conferentieID);

        //Aantal users laden voor header

        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['conferenceDay'] = $this->conferentiedag_model->get($id);
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Schedule';
        $data['conference'] = $conference;
        $data['sessions'] = $sessions;
        $data['activities'] = $this->activiteit_model->getByConferenceDay($id);

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_sessions', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

}
