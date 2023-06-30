<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offerjobs extends CI_Controller {

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
              if (!$this->session->userdata('login_status'))
              { 
                  redirect('super_admin');
              }

    }
	public function index()
	{
		$this->load->view('super_admin/offer-jobs');
	}

  public function addeditofferjobs($id=false)
  {
    $data['title'] = "Add Offer Jobs";
    $data['button'] = "Submit";
    $data['car_type'] = $this->database_model->getdata('tbl_car_type','L');
    $payment_type_array = array("status"=>'1');
    $data['payment_type'] = $this->database_model->getdata('table_payment_type','L',$payment_type_array);
    
    $this->load->view('super_admin/ajax/add-edit-offer-jobs',$data);
  }
}
