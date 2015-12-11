<?php


class Session extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Conferences - IC Clear/Clarity';

        $this->load->model('sessie_model');
        $data['sessie'] = $this->sessie_model->getAll();
        $data['title'] = 'IC Clear/Clarity - Sessions';

        $data['user'] = $this->authex->getUserInfo();

        

        //Template
        $partials = array('header' => 'main_header',
            'content' => 'session/index',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
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
        //Model laden
        $this->load->model('sessie_model');
        
        //Doorgeven info
        $data['session'] = $this->sessie_model->get($id);

        //Models laden
        $this->load->model('conferentie_model');
        $this->load->model('conferentiedag_model');
        $this->load->model('stats_model');
        $this->load->model('lokaal_model');
        $this->load->model('user_model');

        $conferentieID = $this->session->userdata('managing_conference');
        if ($conferentieID == null) {
            redirect('admin/index');
        }
        $conference = $this->conferentie_model->get($conferentieID);
       
        //Aantal users laden voor header
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['conference'] = $conference;
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Schedule';

        $data['rooms'] = $this->lokaal_model->getAll();
        $data['speakers'] = $this->user_model->getAllSpeakers();

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_session', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function add($id) {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

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
        $this->load->model('user_model');
        $this->load->model('conferentiedag_model');

        $conferentieID = $this->session->userdata('managing_conference');
        $conference = $this->conferentie_model->get($conferentieID);
        if ($conferentieID == null) {
            redirect('admin/index');
        }

        //Aantal users laden voor header
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['conference'] = $conference;
        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Schedule';
        $data['conferenceDay'] = $this->conferentiedag_model->get($id);

        $data['rooms'] = $this->lokaal_model->getAll();
        $data['speakers'] = $this->user_model->getAllSpeakers();

        $partials = array('header' => 'admin_header', 'content' => 'admin/modify_session', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function modifyConfirm() {
        $id = $this->input->post('id');
        $conferenceDayId = $this->input->post('conferenceDayId');
        $starttime = $this->input->post('starttime');
        $endtime = $this->input->post('endtime');
        $description = $this->input->post('description');
        $name = $this->input->post('name');
        $room = $this->input->post('room');
        $speakers = $this->input->post('sprekers');


        $this->load->model('sessie_model');
        $this->load->model('wordtgegevendoor_model');

        $sessie = new stdClass();
        $sessie->beginuur = $starttime;
        $sessie->einduur = $endtime;
        $sessie->naam = $name;
        $sessie->beschrijving = $description;
        $sessie->lokaalId = $room;
        $sessie->conferentieDagId = $conferenceDayId;

        if ($id == '0') {
            $sessie->id = $this->sessie_model->insert($sessie);
        } else {
            $sessie->id = $id;
            $this->sessie_model->update($sessie);
        }

        //Ids in array stoppen voor later
        $arrayWithSpeakerIds[] = array();
        
        //Door alle sprekers loopen, om, indien ze nog niet in database zitten, toetevoegen
        foreach ($speakers as $speaker) {
            $arrayWithSpeakerIds[] = $speaker;
            $tempSpreker = $this->wordtgegevendoor_model->get3($sessie->id, $speaker);
            if (count($tempSpreker) == 0) {
                $spreker = new stdClass();
                $spreker->deelnemerId = $speaker;
                $spreker->sessieId = $sessie->id;
                $this->wordtgegevendoor_model->insert($spreker);
            }
        }
        
        //Hier controleren we of de sprekers in de database zetten en niet zijn meegegeven door de admin
        //Ze moeten dus verwijderd worden bij wordtgegevendoor
        //We halen dus alle sprekers op voor een sessie, kijken welke ids er zijn meegegeven en welke in de database zitten
        //Verwijderen de geen die in de database zitten en niet zijn meegegeven door de admin
        $tempSpeakers = $this->wordtgegevendoor_model->get2($sessie->id);
        foreach ($tempSpeakers as $tempSpeaker) {
            if (!in_array($tempSpeaker->deelnemer->id, $arrayWithSpeakerIds)) {
                $this->wordtgegevendoor_model->deleteThroughSpeakerAndSession($tempSpeaker->deelnemer->id, $sessie->id);
            }
        }
        
        // Terug naar overview
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
        //Kijken of er een id is ingevuld
        if ($id == null) {
            redirect('manage/schedule');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/schedule');
            }
        }
        //Models laden
        $this->load->model('sessie_model');
        $this->load->model('wordtgegevendoor_model');
        
        //Alle sessies met spreker verwijderen
        foreach ($this->wordtgegevendoor_model->get2($id) as $speakerInfo) {
            $this->wordtgegevendoor_model->deleteThroughSession($speakerInfo->sessieId);
        }
        $this->sessie_model->delete($id);
        
        //Teruggaan
        redirect_back();
    }

}
