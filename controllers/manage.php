<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function hotels() {
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
        $this->load->model('hotel_model');

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Sessie verlopen? Teruggaan
        if ($id == null) {
            redirect('admin/home');
        }
        
        $conference = $this->conferentie_model->get($id);
        $hotels = $this->hotel_model->getAllByLocationId($conference->locatieId);

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Hotels';
        $data['conference'] = $conference;
        $data['hotels'] = $hotels;

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_hotels', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function rooms() {
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
        $this->load->model('lokaal_model');

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Sessie verlopen? Terug naar admin
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);
        $rooms = $this->lokaal_model->getAllByLocationId($conference->locatieId);

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Rooms';
        $data['conference'] = $conference;
        $data['rooms'] = $rooms;

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_rooms', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function pricing() {
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
        $this->load->model('conferentiedag_model');

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Sessie verlopen? Terug naar homepage!
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);
        $conferenceDays = $this->conferentiedag_model->getAllByConference($id);

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Prices';
        $data['conference'] = $conference;
        $data['conferenceDays'] = $conferenceDays;

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_pricing', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function downloads() {
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
        $this->load->model('download_model');

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Downloads';
        $data['downloads'] = $this->download_model->getPerConference($id);
        $data['conference'] = $conference;

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_downloads', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function announcements() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        // laden models
        $this->load->model('conferentie_model');
        $this->load->model('aankondiging_model');

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Sessie verlopen? Terug naar admin home
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);
        $aankondigingen = $this->aankondiging_model->getPerConferentie($id);

        $data['user'] = $user;
        $data['announcements'] = $aankondigingen;
        $data['title'] = 'Admin - Manage Announcements';
        $data['conference'] = $conference;
        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_announcements', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function schedule() {
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
        $this->load->model('conferentiedag_model');
        $this->load->model('sessie_model');

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Controleren of er een sessie is
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);
        

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Schedule';
        $data['conference'] = $conference;
        $data['conferenceDays'] = $this->conferentiedag_model->getAllByConference($id);


        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_schedule', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function proposals() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        // laden models
        $this->load->model('conferentie_model');
        $this->load->model('voorstel_model');
        $this->load->model('voorstelstatus_model');

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Controleren of er een sessie is
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Hotels';
        $data['conference'] = $conference;
        $data['voorstellen'] = $this->voorstel_model->getPerConference($id);
        $data['statussen'] = $this->voorstelstatus_model->getAll();
        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_proposals', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function stats() {
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
        $this->load->model('stats_model');

        //Sessie ophalen
        $id = $this->session->userdata('managing_conference');
        //Kijken of sessie verlopen is
        if ($id == null) {
            redirect('admin/home');
        }
        $conference = $this->conferentie_model->get($id);

        //Aantal users laden voor header & andere info
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['participants'] = $this->stats_model->getParticipantsConference($id);
        $data['pendingPayment'] = $this->stats_model->getPendingPaymentsConference($id);
        $data['paidPayment'] = $this->stats_model->getPaidPaymentsConference($id);

        $data['user'] = $user;
        $data['title'] = 'Admin - Stats';
        $data['conference'] = $conference;

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_stats', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function profiles() {
        
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $this->load->model('user_model');
        $this->load->model('niveau_model');
        $data['users'] = $this->user_model->getAll();
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['levels'] = $this->niveau_model->getAll();

        $data['user'] = $user;
        $data['title'] = 'Admin - Stats';

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_profiles', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

}
