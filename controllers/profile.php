<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('json');
        $this->load->library('email');
        $this->load->helper('email');
    }

    public function index() {
        $data['title'] = 'Profile';

        //Kijken of er iemand ingelogd is
        $user = $this->authex->getUserInfo();
        //Kijken of user ingelogd is
        if ($user == null) {
            redirect('home/login');
        }
        //User doorgeven naar nieuwe pagina
        $data['user'] = $user;
        
        //Models laden
        $this->load->model('land_model');
        $this->load->model('aanspreking_model');
        $this->load->model('betaling_model');
        $this->load->model('inschrijvingdag_model');
        
        
        //Gegevens doorgeven
        $data['datas'] = $this->inschrijvingdag_model->getPerDeelnemer($user->id);
        $data['betalingen'] = $this->betaling_model->getUnpaidByDeelnemer($user->id);
//        $data['totaal'] = $this->betaling_model->getTotalUnpaidByDeelnemer($user->id);
        $data['landen'] = $this->land_model->getAll();
        $data['aanspreking'] = $this->aanspreking_model->getAll();

        $partials = array('header' => 'main_header', 'content' => 'profile/index', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }


    public function lock($id) {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Controleren of er een id is
        if ($id == null) {
            redirect('manage/profiles');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/profiles');
            }
        }

        $this->load->model('user_model');
        $newUser = $this->user_model->get($id);
        $newUser->locked = 1;
        $this->user_model->update($newUser);

        redirect('manage/profiles');
    }

    public function unlock($id) {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Controleren of er een id is
        if ($id == null) {
            redirect('manage/profiles');
        } else {
            if (!is_numeric($id)) {
                redirect('manage/profiles');
            }
        }

        //Gegevens aanpassen
        $this->load->model('user_model');
        $newUser = $this->user_model->get($id);
        $newUser->locked = 0;
        $this->user_model->update($newUser);

        //Teruggaan naar pagina
        redirect('manage/profiles');
    }

    public function changeLevel() {
        $success = true;
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            $success = false;
        }
        if ($user->niveauId != 1) {
            $success = false;
        }

        $object = new stdClass();

        if ($success) {
            //Gegevens ophalen uit POST
            $userId = $this->input->post('userId');
            $levelId = $this->input->post('levelId');

            //Gegevens uit database halen
            $this->load->model('user_model');
            $newUser = $this->user_model->get($userId);
            //User bestaat? (Controle om zeker te zijn)
            if ($newUser != null) {
                //Aanpassen
                $newUser->niveauId = $levelId;
                $this->user_model->update($newUser);
                $object->success = true;
            } else {
                $object->success = false;
            }
        } else {
            $object->success = false;
        }

        echo json_encode($object);
    }

}
