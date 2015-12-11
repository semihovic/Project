<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Download extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }

    public function index() {
        //Titel doorgeven
        $data['title'] = 'Downloads - IC Clear/Clarity';

        //Kijken of er iemand ingelogd is
        $data['user'] = $this->authex->getUserInfo();



        //Template
        $partials = array('header' => 'main_header',
            'content' => 'download/index',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
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

        //Sessie ophalen
        $conferentieID = $this->session->userdata('managing_conference');
        //Indien sessie niet bestaat, terug naar admin
        if ($conferentieID == null) {
            redirectt('admin/index');
        }

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Downloads';

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_downloads', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function modifyConfirm() {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();

        //Controleren of user ingelogd is
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Controleren of de sessie nog bestaat
        $conferentieID = $this->session->userdata('managing_conference');
        //Sessie verlopen? Terug naar Index
        if ($conferentieID == null) {
            redirect('admin/home');
        }

        //Bestandsnaam & succes controle
        $bestandsnaam = "";
        $succesfull = true;

        //Basic upload informatie
        $config['upload_path'] = 'upload/files';
        $config['allowed_types'] = 'pdf';

        //Kijken of upload path bestaat. Indien niet, aanmaken
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        // Upload library laden
        $this->load->library('upload', $config);
        $this->upload->overwrite = true;

        //Gegevens ophalen
        $id = $this->input->post('id');
        $title = $this->input->post('title');

        //Object aanmaken
        $download = new stdClass();
        $download->titel = $title;
        $download->conferentieId = $conferentieID;

        //Models laden
        $this->load->model('download_model');

        //Controleren of er een file upgeload moet worden en of er 1 is
        //Bij update, moet er geen nieuwe zijn, enkel de titel kan aangepast zijn
        if ($this->input->post('hiddenFileName') != "") {
            if ($this->upload->do_upload()) {
                //Indien uploaden gelukt is
                $settings = $this->upload->data();
                $bestandsnaam = $settings['file_name'];
                $download->upload = $bestandsnaam;
            } else {
                $succesfull = false;
                //$error = $this->upload->display_errors('<p>', '</p>');
            }
        }

        //Indien uploaden succesfull is, inserten/updaten we
        if ($succesfull) {
            //id = 0 toevoegen, id anders update
            if ($id == '0') {
                //Uploaden gelukt?
                $this->download_model->insert($download);
            } else {
                $download->id = $id;
                $this->download_model->update($download);
            }
        }
        redirect('manage/downloads');
    }

    public function modify($id) {
        //Controleren of er een id is, anders redirecten. Gebruiker kan nooit hier op komen zonder ID.
        //Als er geen ID is, heeft hij de url zelf zo ingetypd.
        if ($id == null) {
            redirect('manage/downloads');
        } else {
            if(!is_numeric($id)) {
                redirect('manage/downloads');
            }
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
        $this->load->model('download_model');
        $this->load->model('stats_model');

        $conferentieID = $this->session->userdata('managing_conference');
        if ($conferentieID == null) {
            redirectt('admin/index');
        }

        //Aantal users laden voor header
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['download'] = $this->download_model->get($id);

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Downloads';

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_downloads', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function delete($id) {
        if ($id == null) {
            redirect('manage/downloads');
        }
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Models laden
        $this->load->model('download_model');

        //Verwijderen uit database
        $this->download_model->delete($id);

        redirect('manage/downloads');
    }

}
