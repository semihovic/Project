<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    	public function __construct()
	{
            parent::__construct();
            $this->load->helper('form');
            $this->load->library('email');
            $this->load->helper('email');
        }     
        
        public function nieuw()
	{
            
            //Models laden
            $this->load->model('land_model');
            $this->load->model('aanspreking_model');
            
            //Gegevens doorgeven
            $data['title'] = 'Registration form';
            $data['user']  = $this->authex->getUserInfo();
            $data['landen'] = $this->land_model->getAll();
            $data['aanspreking'] = $this->aanspreking_model->getAll();
            
            
            
            
            $partials = array('header' => 'main_header', 'content' => 'user_nieuw', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        
        private function sendmail($to, $id, $random)
        {
            $this->email->from('r0599013@student.thomasmore.be', 'IC Clearity');
            $this->email->to($to);

            $this->email->subject('IC Clear: activationlink');
            $link = site_url() . '/user/activeer/';
            $this->email->message('You have registered on your website, please click on the following link to activate your account.' . PHP_EOL . $link . $id . '/' . $random);	

            $this->email->send();
        }
        
        public function registreer()
        {
            if($this->input->post("mysubmit") == "Back"){
                redirect("home/login");
            }
            $aanspreking = $this->input->post('aanspreking');
            $naam = $this->input->post('naam');
            $lnaam = $this->input->post('achternaam');
            $adres = $this->input->post('adres');
            $woonplaats = $this->input->post('woonplaats');
            $landId = $this->input->post('land');
            if ($aanspreking == 2 || $aanspreking == 3){
                $geslachtId = 2;
            }
            else {
                $geslachtId = 1;
            }
            $usernaam = $this->input->post('usernaam');
            $email = $this->input->post('email');
            $paswoord = $this->input->post('paswoord');
            $paswoord2 = $this->input->post('paswoord2');
            $random = sha1(mt_rand(10000, 99999) . time() . $email);
            if($paswoord != $paswoord2){
                redirect('/user/fout');
            }
            $id = $this->authex->register($aanspreking, $naam, $lnaam, $adres, $woonplaats, $landId, $geslachtId, $usernaam, $email, $paswoord,$random);

            if ($id != 0) {
                $this->sendmail($email, $id, $random);
                $this->klaar();
            } else {
                $this->bestaat();
            }
        }
 
        public function activeer($id, $random)
        {
           $this->authex->activate($id, $random);
           
           $data['title'] = 'Gebruiker geactiveerd';
           $data['user']  = $this->authex->getUserInfo();
           
           
           
           $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_geactiveerd', 'footer' => 'main_footer');
           $this->template->load('main_master', $partials, $data);
        }
       
        
        public function bestaat()
	{
            $data['title'] = 'User already exists';
            $data['user']  = $this->authex->getUserInfo();
            
            
            
            $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_bestaat', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        
        public function fout(){
               
            $data['title'] = 'Error!';
            $data['user']  = $this->authex->getUserInfo();
            
            
            
            $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_fout', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        
        public function actiefout(){
               
            $data['title'] = 'Fout!';
            $data['user']  = $this->authex->getUserInfo();
            
            
            
            $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_actiefout', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
                
        
        public function klaar()
	{
            $data['title'] = 'User activation';
            $data['user']  = $this->authex->getUserInfo();
            
            
            
            $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_klaar', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        
        public function vergeten()
	{
            $data['title'] = 'Forgot password';
            $data['user']  = $this->authex->getUserInfo();
            
            
            
            $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_vergeten', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }

        public function nieuwwachtwoord() {
            $email = $this->input->post('email');
            $data['user']  = $this->authex->getUserInfo();
            $nieuwwachtwoord = $this->authex->newpassword($email);
            
            $this->stuurnieuw($email, $nieuwwachtwoord);
            $data['title'] = "Password reset";
            
            
            
            $partials = array('header'=>'main_header','menu'=>'main_menu', 'content'=>'user_vergeetklaar', 'footer'=>'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        
        private function stuurnieuw($to, $nieuwwachtwoord){
            $to = $this->input->post('email');
            
            $this->email->from('semih.doksanbir@student.thomasmore.be', 'IC Clearity');
            $this->email->to($to);
            $this->email->subject('IC Clearity: new password');
            $this->email->message('Your new password: ' . $nieuwwachtwoord);	

            $this->email->send();
        }
        
        
        public function aanpassen() {
            $data['user']  = $this->authex->getUserInfo();
            $data['landen'] = $this->user_model->getLanden();
            $data['aanspreking'] = $this->user_model->getAanspreking();
            
            $data['title'] = "Edit Profile - IC Clear";
            
            
            
            $partials = array('header'=>'main_header','menu'=>'main_menu', 'content'=>'user_aanpassen', 'footer'=>'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
        
        public function pasAan() {
            
            $user = new stdClass();
            $user->aansprekingId = $this->input->post('aanspreking');
            $user->voornaam = $this->input->post('naam');
            $user->achternaam = $this->input->post('achternaam');
            $user->username = $this->input->post('usernaam');
            $user->adres = $this->input->post('adres');
            $user->woonplaats = $this->input->post('woonplaats');
            $user->landId = $this->input->post('land');
            if ($this->input->post('aanspreking') == 2 || $this->input->post('aanspreking') == 3){
                $user->geslacht = 2;
            }
            else {
                $user->geslacht = 1;
            }
            $user->username = $this->input->post('usernaam');
            
           
            $this->load->model('user_model');
            $this->user_model->update($user);
            redirect('profile/index');
        }
        
        public function pasEmailAan() {
            $user = $this->authex->getUserInfo();
            
            $email = $this->input->post('email');
            $emailConfirm = $this->input->post('emailConfirm');
            
            //Als email geen valide notatie is
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                redirect('/user/fout');
            } 
            //Als er niet twee keer dezelfde email is doorgegeven
            //Zal ook via jQuery gecontroleerd worden, maar 
            if($email != $emailConfirm){
                redirect('/user/fout');
            }
            
            $paswoord = $this->input->post('paswoord');
            $paswoord2 = $this->input->post('paswoord2');
            //Als er niet twee keer dezelfde paswoord is doorgegeven
            //Zal ook via jQuery gecontroleerd worden, maar 
            if($paswoord != $paswoord2){
                redirect('/user/fout');
            }
            
            //Nieuwe activatielink - omdat email veranderd is
            $random = sha1(mt_rand(10000, 99999) . time() . $email);
            $this->sendmail($email, $user->id, $random);
            
            $newUser = new stdClass();
            $newUser->email = $email;
            $newUser->generatiecode = $random;
            $newUser->geActiveerd = 0;
            
            $this->load->model('user_model');
            $this->user_model->update($newUser);
            redirect('profile/index');
        }
}

/* End of file user.php */
/* Location: ./applications/tvshop/controllers/user.php */