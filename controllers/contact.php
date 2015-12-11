<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('json');
        $this->load->library('email');
        $this->load->helper('email');
    }

//Index pagina naar contactpagina
    public function index() {
        //Titel doorgeven
        $data['title'] = 'Contact - IC Clear/Clarity';

        //Kijken of er iemand ingelogd is
        $data['user'] = $this->authex->getUserInfo();
        //Template
        $partials = array('header' => 'main_header',
            'content' => 'contact/index',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function contacteer() {
        if ($this->input->post("mysubmit") == "Back") {
            redirect("home/index");
        }
        $email = $this->input->post("email");
        $naam = $this->input->post("naam");
        $onderwerp = $this->input->post("onderwerp");
        $bericht = $this->input->post("bericht");
        
        

        $this->email->from($email, $naam);
        $this->email->to('r0458056@student.thomasmore.be');

        $this->email->subject($onderwerp);
        
        $this->email->message('The following person has send you a contactmail on the icclear website' . PHP_EOL . 'Name: ' . $naam  . PHP_EOL . 'Subject: ' . $onderwerp . PHP_EOL . "Message: " . PHP_EOL . $bericht . PHP_EOL . PHP_EOL . "You can directly reply to this email");

        $this->email->send();
        
        //Titel doorgeven
        $data['title'] = 'Mail sent';

        //Kijken of er iemand ingelogd is
        $data['user'] = $this->authex->getUserInfo();
        //Template
        $partials = array('header' => 'main_header',
            'content' => 'contact/bevestiging',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

}
