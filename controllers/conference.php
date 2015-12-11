<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Conference extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('json');
    }

    public function index() {
        //Index pagina naar conferenties
        //
      

        $this->load->model('land_model');
        $landen = $this->land_model->getAll();

        $this->load->model('conferentie_model');
        foreach ($landen as $land) {
            $land->conferenties = $this->conferentie_model->getAllActiveByCountry($land->id);
            $conferentielanden[] = $land;
        }
        $data["landen"] = $conferentielanden;

        //Titel doorgeven
        $data['title'] = 'Overview Conferences - IC Clear/Clarity';

        //Kijken of er iemand ingelogd is
        $data['user'] = $this->authex->getUserInfo();



        //Template
        $partials = array('header' => 'main_header',
            'content' => 'conference/index',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    //Dagen tonen
    public function schedule($id) {
        if ($id == null) {
            redirect('conference/index');
        } else {
            if (!is_numeric($id)) {
                redirect('conference/index');
            }
        }

        $this->load->model('conferentiedag_model');
        $this->load->model('conferentie_model');
        $this->load->model('hotel_model');
        $this->load->model('download_model');
        $this->load->model('deelnemer_model');
        $data['conferentieDagen'] = $this->conferentiedag_model->getAllByConference($id);
        $data['conferentie'] = $this->conferentie_model->get($id);
        $data['downloads'] = $this->download_model->getPerConference($id);
        $data['speakers'] = $this->deelnemer_model->getAllSpeakers($id);
        $conferentie = $this->conferentie_model->get($id);
        $data['hotels'] = $this->hotel_model->getAllByLocation($conferentie->locatieId);
        $data['title'] = 'Conference - IC Clear/Clarity';

        //Kijken of er iemand ingelogd is
        $data['user'] = $this->authex->getUserInfo();



        //Template
        $partials = array('header' => 'main_header',
            'content' => 'conference/schedule',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function sign($conferenceID) {

        if ($conferenceID == null) {
            redirect('conference/index');
        } else {
            if (!is_numeric($conferenceID)) {
                redirect('conference/index');
            }
        }

        //User ophalen
        $user = $this->authex->getUserInfo();

        //Model laden & methode oproepen
        $this->load->model('conferentiedag_model');
        $this->load->model('conferentie_model');
        $this->load->model('sessie_model');
        $this->load->model('activiteit_model');
        if ($user != null) {
            $conferentieDagen = $this->conferentiedag_model->getAllNotSignedByConference($conferenceID, $user->id);
        } else {
            $conferentieDagen = $this->conferentiedag_model->getAllByConference($conferenceID);
        }


        $data['conferenceDays'] = $conferentieDagen;
        $data['conference'] = $this->conferentie_model->get($conferenceID);
        if ($user != null) {
            $data['activities'] = $this->activiteit_model->getAllUnsignedByConference($conferenceID, $user->id);
        } else {
            $data['activities'] = $this->activiteit_model->getAllActivitiesConference($conferenceID);
        }

        //Kijken of er iemand ingelogd is
        $data['user'] = $user;
        $data['title'] = "Attend - ICClear";



        $partials = array('header' => 'main_header',
            'content' => 'conference/sign',
            'footer' => 'main_footer');

        //Nieuwe pagina laden
        $this->template->load('main_master', $partials, $data);
    }

    public function signin() {
        //Checken of er wel gegevens zijn
        if ($this->session->userdata('inschrijving') == null && $this->input->post('conferentieDagen') == null && $this->input->post('activities') && $this->session->userdata('activities')) {
            redirect('home/index');
        }

        //Kijken of we gegevens uit sessies of uit post gegegevens moeten halen
        if ($this->session->userdata('inschrijving') == null) {
            $dagen = $this->input->post('conferentieDagen');
        } else {
            $dagen = $this->session->userdata('inschrijving');
        }

        if ($this->session->userdata('activities') == null) {
            $activities = $this->input->post('activities');
        } else {
            $activities = $this->session->userdata('activities');
        }

        //User ophalen
        $user = $this->authex->getUserInfo();

        //Kijken of user ingelogd is, anders kan moet hij eerst inloggen voor hij kan registeren
        if ($user == null) {
            $this->session->set_userdata('inschrijving', $this->input->post('conferentieDagen'));
            $this->session->set_userdata('activities', $this->input->post('activities'));
            redirect('home/login');
        }

        //Alles laden
        $rowsAffected = 0;
        $this->load->model('inschrijvingdag_model');
        $this->load->model('betaling_model');
        $this->load->model('inschrijvingactiviteit_model');

        //Prijs al hebben
        $prijs = intval($this->input->post('prijsTotaal'));

        //Arrays maken om dubbele inschrijvingen, prijs ervan omlaag te doen
        //Deze arrays bevatten de IDs van de gekozen activities/dagen, die de gebruiker gekozen heeft
        $activityArray[] = array();
        $dayArray[] = array();
        if ($activities != null && !empty($activities)) {
            foreach ($activities as $ac) {
                $activityArray[] = $ac;
            }
        }
        if ($dagen != null && !empty($dagen)) {
            foreach ($dagen as $dag) {
                $dayArray[] = $dag;
            }
        }

        //Prijs omlaag brengen, indien hij al ingeschreven hiervoor is
        //Reeds ingechreven
        $signedInDays = $this->inschrijvingdag_model->getPerParticipant($user->id);
        $signedInDaysArray[] = array();
        foreach ($signedInDays as $signedInDay) {
            $signedInDaysArray[] = $signedInDay->conferentieDagId;
            if (in_array($signedInDay->conferentieDag->id, $dayArray)) {
                $prijs -= $signedInDay->conferentieDag->prijs;
            }
        }
        //Prijs omlaag doen als hij al reeds voor activiteit is ingeschreven
        $signedInActivities = $this->inschrijvingactiviteit_model->getPerParticipant($user->id);
        $signedInActivitiesArray[] = array();
        foreach ($signedInActivities as $signedInActivity) {
            $signedInActivitiesArray[] = $signedInActivity->activiteitId;
            if (in_array($signedInActivity->activity->id, $activityArray)) {
                $prijs -= $signedInActivity->activity->prijs;
            }
        }


        //Eerst betaling erin zetten om aan id te kunnen
        if ($prijs > 0) {
            //Nieuw object aanmaken om inschrijving in database te schrijven
            //
            //mededeling maken voor betaling
            $mededeling = mt_rand(10000, 99999);
            $betaling = new stdClass();
            $betaling->deelnemerId = $user->id;
            $betaling->herinneringsmail = 1;
            $betaling->aantalPersonen = 1;
            $betaling->prijs = $prijs;
            $betaling->mededeling = "Paymentnr. " . $mededeling;
            $betalingId = $this->betaling_model->insert($betaling);
        }

        //Activiteiten erin steken
        if (!empty($activities) && $betalingId != null) {
            foreach ($activities as $ac) {
                if (!in_array($ac, $signedInActivitiesArray)) {
                    $activity = new stdClass();
                    $activity->deelnemerId = $user->id;
                    $activity->activiteitId = $ac;
                    $activity->betalingId = $betalingId;
                    $rowsAffected += $this->inschrijvingactiviteit_model->insert($activity);
                }
            }
        }

        //Dagen erin steken
        if (!empty($dagen) && $betalingId != null) {
            foreach ($dagen as $dag) {
                if (!in_array($dag, $signedInDaysArray)) {
                    $inschrijving = new stdClass();
                    $inschrijving->deelnemerId = $user->id;
                    $inschrijving->conferentieDagId = $dag;
                    $inschrijving->datum = date('Y-m-d');
                    $inschrijving->betalingId = $betalingId;
                    $rowsAffected += $this->inschrijvingdag_model->insert($inschrijving);
                }
            }
        }



        //Nieuwe pagina laden om gebruiker te notifyen of inschrijving succesvol is of niet
        if ($rowsAffected == 0) {
            //Indien inschrijven niet gelukt is
            //Template
            $data['success'] = false;
            $partials = array('header' => 'main_header',
                'content' => 'conference/signInStatus',
                'footer' => 'main_footer');
        } else {
            //Indien inschrijven gelukt is
            //Template

            $data['prijs'] = $prijs;
            $partials = array('header' => 'main_header',
                'content' => 'conference/signInStatus',
                'footer' => 'main_footer');
            $data['success'] = true;
        }

        //Kijken of er iemand ingelogd is
        $data['user'] = $user;
        $data['title'] = "Status Report - ICClear";


        if ($this->session->userdata('inschrijving') != null) {
            $this->session->unset_userdata('inschrijving');
        }
        if ($this->session->userdata('activities') != null) {
            $this->session->unset_userdata('activities');
        }

        //Nieuwe pagina laden
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
        $this->load->model('statusconferentie_model');
        $this->load->model('stats_model');
        $this->load->model('land_model');

        // ophalen gewenste conferentie
        $data['statussen'] = $this->statusconferentie_model->getAll();
        $data['countUsers'] = $this->stats_model->countAllUsers();
        $data['landen'] = $this->land_model->getAll();

        // Laden Template Partials + View
        $data['user'] = $user;
        $partials = array('header' => 'admin_header',
            'content' => 'admin/add_conference',
            'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function confirmAdd() {
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
        $this->load->model('locatie_model');
        $this->load->model('land_model');

        // insert location
        $locationExplode = explode(',', $this->input->post('location'));
        $locationExplode[1] = str_replace(' ', '', $locationExplode[1]);
        //$land = $this->land_model->getByLand(trim($locationExplode[1]));

        $location = new stdClass();
        $location->naam = $locationExplode[0];
        $location->stad = $locationExplode[1];
        $location->landId = $this->input->post('country');
        $locatieId = $this->locatie_model->insert($location);

        // ophalen gegevens formulier
        $conference = new stdClass();
        $conference->naam = $this->input->post('name');
        $conference->locatieId = $locatieId;
        $conference->landId = $location->landId;
        $conference->startdatum = $this->input->post('startdate');
        $conference->einddatum = $this->input->post('enddate');
        $conference->statusConferentieId = $this->input->post('status');
        $conference->extraInfo = $this->input->post('info');

        // update conferentie
        $this->conferentie_model->insert($conference);

        // methode oproepen Admin-controller
        redirect('admin/index');
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

        // laden models
        $this->load->model('conferentie_model');
        $this->load->model('statusconferentie_model');
        $this->load->model('land_model');

        // ophalen gewenste conferentie
        $data['conferentie'] = $this->conferentie_model->get($id);
        $data['statussen'] = $this->statusconferentie_model->getAll();
        $data['landen'] = $this->land_model->getAll();

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        // Laden Template Partials + View
        $data['user'] = $user;
        $partials = array('header' => 'admin_header',
            'content' => 'admin/modify_conference',
            'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function confirmModify() {
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
        $this->load->model('locatie_model');
        $this->load->model('land_model');

        // update location
        $locationExplode = explode(',', $this->input->post('location'));
        $locationExplode[1] = str_replace(' ', '', $locationExplode[1]);
        $land = $this->land_model->get($this->input->post('country'));

        $locationId = $this->input->post('locationId');
        $locationtest = $this->locatie_model->get($locationId);
        if ($locationExplode[0] != $locationtest->naam || $locationExplode[1] != $locationtest->stad || $land->id != $locationtest->landId) {
            $location = new stdClass();
            $location->naam = $locationExplode[0];
            $location->stad = $locationExplode[1];
            $location->landId = $this->input->post('country');

            $locatieId = $this->locatie_model->insert($location);
        } else {
            $locatieId = $this->input->post('locationId');
        }
        // ophalen gegevens formulier
        $conference = new stdClass();
        $conference->id = $this->input->post('id');
        $conference->naam = $this->input->post('name');
        $conference->locatieId = $locatieId;
        $conference->startdatum = $this->input->post('startdate');
        $conference->einddatum = $this->input->post('enddate');
        $conference->statusConferentieId = $this->input->post('status');
        $conference->extraInfo = $this->input->post('info');

        // update conferentie
        $this->conferentie_model->update($conference);

        // methode oproepen Admin-controller
        redirect('admin/index');
    }

    public function manage($id) {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        $this->session->set_userdata('managing_conference', $id);

        $data['user'] = $user;
        $data['title'] = 'Admin - Manage Conference';

        //Aantal users laden voor header
        $this->load->model('stats_model');
        $data['countUsers'] = $this->stats_model->countAllUsers();

        $partials = array('header' => 'admin_header', 'content' => 'admin/manage_conference', 'footer' => 'admin_footer');

        $this->template->load('admin_master', $partials, $data);
    }

    public function archive($id) {
        // Kijken of user ingelogd is en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null) {
            redirect('home/login');
        }
        if ($user->niveauId != 1) {
            redirect('home/login');
        }

        //Controleren of id valide is //Dit is via ajax, dus hier returnen we gwn
        if ($id == null) {
            return;
        }

        if (!is_numeric($id)) {
            return;
        }

        // laden models
        $this->load->model('conferentie_model');

        // Archiveren
        $this->conferentie_model->archive($id);

        // Redirect naar Admin Index
        redirect('admin/index');
    }

    public function dearchive($id) {
        // kijken of user is ingelogd en admin is
        $user = $this->authex->getUserInfo();
        if ($user == null || $user->niveauId != 1) {
            redirect('home/login');
        }

        // laden models
        $this->load->model('conferentie_model');

        // Archiveren
        $this->conferentie_model->dearchive($id);

        // Redirect naar Admin Index
        redirect('admin/index');
    }

}
