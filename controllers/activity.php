<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Activity extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }

    public function add($id) {
        // Kijken of user ingelogd is en admin is
        //Indien niet, gaan we naar login
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
        } else {
            if (!is_numeric($id)) {
                redirect('manage/schedule');
            }
        }

        //Models laden
        $this->load->model('conferentie_model');
        $this->load->model('stats_model');
        $this->load->model('lokaal_model');
        $this->load->model('conferentiedag_model');

        //Sesie ophalen
        $conferentieID = $this->session->userdata('managing_conference');
        //Sessie verlopen? Terug naar index
        if ($conferentieID == null) {
            redirect('admin/index');
        }
        $conference = $this->conferentie_model->get($conferentieID);


        //Aantal users laden voor header
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['conference'] = $conference;
        $data['conferenceDay'] = $this->conferentiedag_model->get($id);
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Schedule';

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_activity', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
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
            redirect('manage/schedule');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/schedule');
            }
        }

        //Models laden
        $this->load->model('conferentie_model');
        $this->load->model('stats_model');
        $this->load->model('lokaal_model');
        $this->load->model('conferentiedag_model');
        $this->load->model('activiteit_model');

        //Sessie ophalen
        $conferentieID = $this->session->userdata('managing_conference');
        //Sessie verlopen? Terug naar index!
        if ($conferentieID == null) {
            redirect('admin/index');
        }
        if ($this->session->userdata('conferenceDayId') == null) {
            redirect('manage/schedule');
        }
        $conference = $this->conferentie_model->get($conferentieID);


        //Aantal users laden voor header
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['conference'] = $conference;
        $data['conferenceDay'] = $this->conferentiedag_model->get($this->session->userdata('conferenceDayId'));
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Schedule';
        $data['activity'] = $this->activiteit_model->get($id);

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_activity', 'footer' => 'admin_footer');

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
        
        //Info ophalen
        $id = $this->input->post('id');
        $conferenceDayId = $this->input->post('conferenceDayId');
        $name = $this->input->post('name');
        $starttime = $this->input->post('starttime');
        $endtime = $this->input->post('endtime');
        $price = $this->input->post('price');

        //Info in object zetten
        $activity = new stdClass();
        $activity->naam = $name;
        $activity->beginuur = $starttime;
        $activity->einduur = $endtime;
        $activity->conferentieDagId = $conferenceDayId;
        $activity->prijs = $price;

        $this->load->model('activiteit_model');

        //Als id 0 is, inserten we, anders updaten we
        if ($id == '0') {
            $this->activiteit_model->insert($activity);
        } else {
            $activity->id = $id;
            $this->activiteit_model->update($activity);
        }

        redirect('schedule/overview/' . $conferenceDayId);
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
            redirect('manage/schedule');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/schedule');
            }
        }
        
        //Deleten
        $this->load->model('activiteit_model');
        $this->activiteit_model->delete($id);

        //Reload back 
        redirect_back();
    }

}
