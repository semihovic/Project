<?php

session_start();

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        //Aankondiging laden
        $this->load->model('aankondiging_model');
        $data['aankondigingen'] = $this->aankondiging_model->getAll();

        //Titel doorgeven
        $data['title'] = 'Welcome - IC Clear/Clarity';

        //Kijken of er iemand ingelogd is
        $data['user'] = $this->authex->getUserInfo();


        //Template
        $partials = array('header' => 'main_header',
            'content' => 'home',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function logout() {
        //Sessie verwijderen
        $this->session->unset_userdata('user_id');
        redirect('home', 'refresh');
    }

    public function login() {
        $data['title'] = 'Login';
        $data['user'] = $this->authex->getUserInfo();

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'home_login', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function fout() {
        $data['title'] = 'Error!';
        $data['user'] = $this->authex->getUserInfo();

       

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'home_fout', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function aanmelden() {
        //Json laden, omdat we dit enkel hier nodig hebben
        $this->load->helper('json');
        $email = $this->input->post('email');
        $paswoord = $this->input->post('paswoord');
        
        $login = new stdClass();

        //Login succesvol?
        if ($this->authex->login($email, $paswoord)) {
            if ($this->session->userdata('inschrijving') != null || $this->session->userdata('activities') != null) {
                $login->success = "signin";
                //redirect('conference/signin');
            } else {
                $login->success = true;
                //redirect('home/index');
            }
        } else {
            $login->success = false;
            //redirect('home/fout');
        }
        echo json_encode($login);
    }

    public function afmelden() {
        $this->authex->logout();
        redirect('home/index');
    }

    public function speakerRequest() {
        // User gegevens ophalen
        $user = $this->authex->getUserInfo();
        
        //Je kan dit niet doen als je niet ingelogd bent, dus redirecten naar de login pagina
        if ($user == null) {
            redirect('home/login');
        }
       
        //Model laden
        $this->load->model('voorstel_model');
        
        //Kijken of er al een request is, om te weten naar welke pagina we gaan
        $hasSpeakersRequest = $this->voorstel_model->getPerDeelnemer($user->id);

        //Kijken of de gebruiker een spreker is OF een voorstel heeft
        if (empty($hasSpeakersRequest)) {
           redirect('speaker/proposeSubject');
        } else {
           redirect('speaker/viewSubjects');
        }
    }

}

?>
