<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Speaker extends CI_Controller {

        public $error = "";
        
    	public function __construct()
	{
            parent::__construct();
            //$this->load->model('speaker_model'); 
        }  
        

        // Redirect naar pagina om onderwerpn toe te voegen
        public function proposeSubject() {
            // Kijken of user ingelogd is en admin is
            $user = $this->authex->getUserInfo();
            if ($user == null) {
                redirect('home/login');
            }

        
            //Titel
            $data['title']  = 'Propose Subject - ICClear';
            
            //Data doorgeven
            $data['error'] = $this->error;
            $data['user'] = $user;
             
             //Conferenties laden om user te laten kiezen bij welke conferentie hij wilt spreken
             $this->load->model('conferentie_model');
             $data['conferenties'] = $this->conferentie_model->getActieveConferenties();
             
             
             //Template
             $partials = array('header' => 'main_header',
                                'content' => 'speaker/subjectProposal',
                                'footer' => 'main_footer');
             $this->template->load('main_master', $partials, $data);
        }
        
        public function viewSubjects() {
            
            // Kijken of user ingelogd is en admin is
            $user = $this->authex->getUserInfo();
            if ($user == null) {
                redirect('home/login');
            }
            
           
            
            $this->load->model('voorstel_model');
            $data['voorstellen'] = $this->voorstel_model->getPerDeelnemer($user->id);
            
            //Navigatiebar 
            $data['user'] = $user;
            $data['title'] = "Summary of Subjects - ICClear";
            

            $partials = array('header' => 'main_header',
                'content' => 'speaker/subjectsSummary',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        //Onderwerp gegevens zijn ingevuld, gegevens toevoegen aan database
        //Na toevoegen terug naar de index pagina
        public function writeSubject() {
            $filename = "";
            $user = $this->authex->getUserInfo();
            
            //Basic upload informatie
            $config['upload_path'] = 'upload/files';
            $config['allowed_types'] = 'pdf';
            //$config['max_size'] = '1000';
            //$config['max_width'] = '1024';
            //$config['max_height'] = '768';
            
            //Kijken of upload path bestaat. Indien niet, aanmaken
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
                
            // Upload library laden
            $this->load->library('upload', $config);

            //Uploaden
            if ($this->upload->do_upload()) {
                //Indien uploaden gelukt is
                $settings = $this->upload->data();
                $filename = $settings['file_name'];
                //Model laden om gegevens in te voegen
                $this->load->model('voorstel_model');
                
                //Gegevens toevoegen
                $voorstel = new stdClass();
                $voorstel->titel = $this->input->post('title');
                $voorstel->deelnemerId = $user->id;
                $voorstel->beschrijving = $this->input->post('summary');
                $voorstel->conferentieId = $this->input->post('conferenceId');
                $voorstel->statusId = 1;
                $voorstel->upload = $filename;

                $this->voorstel_model->insert($voorstel);
                
                
                //niveau aanpassen van user naar spreker
                if($user->niveauId == 3){
                $user->niveauId = 2;
                $this->load->model('user_model');
                $this->user_model->update($user);
                }
                //Navigatiebar 
                $this->viewSubjects();
            } else {
                //Indien uploaden niet gelukt is
                //
                $this->error = $this->upload->display_errors('<p>', '</p>');
                $this->proposeSubject();
            } 
            
        }
        
}