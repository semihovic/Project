<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp extends CI_Controller {


    	public function __construct()
	{
            parent::__construct();
            //$this->load->model('speaker_model'); 
            $this->load->helper('json_helper');
        }  
        
        public function prijsVerandering() {
            $dagId = $this->input->get('dagId');
            
            $this->load->model('conferentiedag_model');
            
            $data = $this->conferentiedag_model->get($dagId);
            
            echo json_encode($data);
        }
}