<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('speaker_model'); 
        $this->load->helper('json_helper');
        $this->load->library('email');
        $this->load->helper('email');
    }

    //Prijs aanpassen
    public function adjustPrice() {
        $dagId = $this->input->post('dagId');

        $this->load->model('conferentiedag_model');

        $data = $this->conferentiedag_model->get($dagId);

        echo json_encode($data);
    }

    //Prijs aanpassen bij Activity
    public function adjustPriceActivity() {
        $activityId = $this->input->post('activityId');

        $this->load->model('activiteit_model');

        $data = $this->activiteit_model->get($activityId);

        echo json_encode($data);
    }

    //Schedule zien
    public function checkSchedule() {
        $conferentieDagId = $this->input->post('conferentieDagId');
        //Model laden
        $this->load->model('sessie_model');

        //Gegevens van conferentie in variabele zetten
        //$data['sessies'] = $this->sessie_model->getSessiesConferentie($id);
        echo json_encode($this->sessie_model->getSessionsConferenceDay($conferentieDagId));
    }

    //Controleren of username valide is
    public function checkValidUsername($username) {
        $this->load->model('user_model');
        $user = $this->user_model->checkUsername($username);

        return $user == null;
    }

    //Controleren of email valide is
    public function checkEmail() {
        $email = $this->input->post('email');

        $bestaat = new stdClass();
        $bestaat->bool = false;

        $this->load->model('user_model');
        $user = $this->user_model->checkEmail($email);
        if ($user != null) {
            $bestaat->bool = true;
        }

        echo json_encode($bestaat);
    }

    //Password controleren - juist ingevuld?
    public function checkCurrentPassword() {
        $password = $this->input->post('password');
        $isHetzelfde = new stdClass();

        $user = $this->authex->getUserInfo();

        $isHetzelfde->bool = (sha1($password) == $user->paswoord);

        echo json_encode($isHetzelfde);
    }

    //Password veranderen met checks
    public function changePassword() {
        $oldPassword = $this->input->post('password');
        $newPassword = $this->input->post('newPassword');
        $repeat = $this->input->post('repeatNewPassword');
        $object = new stdClass();

        $user = $this->authex->getUserInfo();

        $samePassword = (sha1($oldPassword) == $user->paswoord);

        if (!$samePassword) {
            $object->message = "wrong";
        } else {
            if ($repeat != $newPassword) {
                $object->message = false;
            } else {
                $this->load->model('user_model');
                $newUser = new stdClass();
                $newUser->id = $user->id;
                $newUser->paswoord = sha1($newPassword);
                $this->user_model->update($newUser);
                $object->message = true;
            }
        }

        echo json_encode($object);
    }

    //Profiel veranderen met checks
    public function changeProfile() {
        $object = new stdClass();
        $oldUser = $this->authex->getUserInfo();
        if ($oldUser->usernaam != $this->input->post('usernaam') && !$this->checkValidUsername($this->input->post('usernaam'))) {
            $object->message = false;
        } else {
            //Gegevens aanpassen aan de database
            
            $user = new stdClass();
            $user->id = $oldUser->id;
            $user->aansprekingId = $this->input->post('aanspreking');
            $user->voornaam = $this->input->post('naam');
            $user->achternaam = $this->input->post('achternaam');
            $user->usernaam = $this->input->post('usernaam');
            $user->adres = $this->input->post('adres');
            $user->woonplaats = $this->input->post('woonplaats');
            $user->landId = $this->input->post('land');
            if ($this->input->post('aanspreking') == 2 || $this->input->post('aanspreking') == 3) {
                $user->geslachtId = 2;
            } else {
                $user->geslachtId = 1;
            }
            $this->load->model('user_model');
            $this->user_model->update($user);

            $object->message = true;
        }
        echo json_encode($object);
    }

    //Email aanpassen
    public function changeEmail() {

        $user = $this->authex->getUserInfo();
        $email = $this->input->post('email');
        $password = $this->input->post('paswoord');
        $emailConfirm = $this->input->post('emailConfirm');

        $object = new stdClass();

        if (sha1($password) != $user->paswoord) {
            $object->message = "password";
        } else {
            if ($email != $emailConfirm) {
                $object->message = "email";
            } else {
                //Nieuwe activatielink - omdat email veranderd is
                $random = sha1(mt_rand(10000, 99999) . time() . $email);
                $this->sendmail($email, $user->id, $random);
                $user->email = $email;
                $user->generatiecode = $random;
                $user->geActiveerd = 0;

                $this->load->model('user_model');
                $this->user_model->update($user);
                
                $object->message = true;
                
                $this->authex->logout();
            }
        }

        echo json_encode($object);
    }

    //Archiveerde conferenties zien
    public function showArchived() {
        $this->load->model('conferentie_model');
        echo json_encode($this->conferentie_model->getArchived());
    }

    //Niet-gearchiveerde conferenties zien
    public function showUnarchived() {
        $this->load->model('conferentie_model');
        echo json_encode($this->conferentie_model->getUnArchived());
    }

    //Nieuwe DropDown plaatsen
    function addSpeakerDropdown() {
        $this->load->model('user_model');
        echo json_encode($this->user_model->getAllSpeakers());
    }

    //Mail verzenden
    private function sendmail($to, $id, $random) {
        $this->email->from('r0599013@student.thomasmore.be', 'IC Clarity');
        $this->email->to($to);

        $this->email->subject('IC Clear: activationlink');
        $link = site_url() . '/user/activeer/';
        $this->email->message('You have requested to change your email on our website, please click on the following link to activate your account.' . PHP_EOL . $link . $id . '/' . $random);

        $this->email->send();
    }

}
