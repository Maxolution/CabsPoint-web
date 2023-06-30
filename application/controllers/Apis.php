<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apis extends CI_Controller {

	 public function __construct()
    {
        parent::__construct();
              $this->load->helper(array("file", "url","document_upload_helper"));
              $this->load->library(array("session", "encryption","form_validation"));
              $this->load->model(array("formvalidation_model","database_model"));
              $config = Array(
                  'protocol' => 'sendmail',
                  'mailtype' => 'html',
                  'charset' => 'utf-8',
                  'wordwrap' => TRUE
              );
              $this->load->library('email', $config);
              $this->load->database();
              /*$this->load>helper("document_upload_helper");*/

    }
    public function index()
    {
    	if ($_REQUEST["token"] != '') 
        {
    	 	 if($_REQUEST["token"] == $this->config->item('api_token')) 
             {
              $json = file_get_contents('php://input');
                  if(!empty($json)){
                     $data = json_decode($json);
                     $action = $data->action;
                  }else{
                     $data = $this->input->post();
                     $action = $data['action'];
                  }
    	 	 	switch ($action) {
                    case "driver_login":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->driver_login();
                         break;
                    case "driver_logout":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->driver_logout();
                         break;     
                    case "driver_signup":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->signup_driver();
                         break;
                         /*new changes*/
                    case "add_vehicle_type":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->add_vehicle_type();
                         break;
                         /*new changes*/
                     case "add_driver_address":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->driver_address();
                         break; 
                     case "upload_driver_document":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->driver_document();
                         break; 
                     case "get_driver_details":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->get_driver_details();
                         break;
                     case "vehicle_type":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->getcartype();
                         break;
                     case "forgot_password":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->forgotpassword();
                         break;
                     case "change_password":
                         $this->load->model('Api/driver_model');
                         $this->driver_model->changepassword();   
                     case "verified_otp":
                          $this->load->model('Api/driver_model');
                          $this->driver_model->verified_otp();
                          break; 
                    /*==============Earning Screen==============*/ 
                    case "get_earning":
                          $this->load->model('Api/earning_model');
                          $this->earning_model->get_earning();
                          break;
                    case "get_all_job_offer":
                          $this->load->model('Api/job_offer_model');
                          $this->job_offer_model->get_all_job_offer();
                          break;                
				    case "no_show_formality":
						  $this->load->model('Api/job_offer_model');
						  $this->job_offer_model->no_show_formality();
						  break;
                    case "marketplace_offer":
                          $this->load->model('Api/job_offer_model'); 
                          $this->job_offer_model->marketplace_offer();
                          break;
                    case "marketplace_offer_demo":
                          $this->load->model('Api/joboffermatch'); 
                          $this->joboffermatch->marketplace_offer();
                          break;        
                    case "get_airport":
                          $this->load->model('Api/airport_model'); 
                          $this->airport_model->getairport();
                          break; 
                    case "accept_job_offer":
                          $this->load->model('Api/job_offer_model'); 
                          $this->job_offer_model->acceptjoboffer();
                          break;
                    case "get_all_status":
                          $this->load->model('Api/job_offer_model'); 
                          $this->job_offer_model->get_all_status();
                          break;       
                    case "service_companies":
                          $this->load->model('Api/service_companies_model'); 
                          $this->service_companies_model->main();
                          break;
                    case "update_driver_profile":
                          $this->load->model('Api/driver_model');
                          $this->driver_model->update_driver_profile();
                          break;
                    case "save_vehicle_information":
                          $this->load->model('Api/driver_model');
                          $this->driver_model->save_vehicle_information();
                          break;                               
                    default:
                        echo json_encode(array("msg" => "Api action is wrong"));
                        die;
                        break;
                    }
    	 	 }else
    	 	 {
    	 	 	echo json_encode(array("msg" => "Token Is Wrong!!"));
            die;
    	 	 }
    	 
        } else 
        {
            echo json_encode(array("msg" => "Token Is Missing!!"));
            die;
        }
    
	
   }
}
