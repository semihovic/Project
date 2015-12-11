<?php

//k
//session_start();

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1){
            redirect('home/login');
        }
        
        // Laden conferentiemodel
        $this->load->model('conferentie_model');
        $this->load->model('stats_model');
        
        $data['user'] = $user;
        $data['title'] = 'Admin';
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['conferences'] = $this->conferentie_model->getNonArchived();

        $partials = array('header' => 'admin_header', 'content' => 'admin/home', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

}
