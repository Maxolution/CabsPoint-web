<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CarTypeController extends CI_Controller {

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
              if (!$this->session->userdata('login_status'))
              { 
                  redirect('super_admin');
              }

    }

	
	public function index()
	{
    $data['car_type'] = $this->database_model->getdata('tbl_car_type','L');
    //print_r($data['car_type']);die;
		$this->load->view('super_admin/car-type',$data);
	}

  public function addeditcartype($id=false){
    if($id==""){
      $data['sub_title'] = "Add Car Type";
      $data['button'] = "Submit";
      $data['action_type'] = "";
    }else{
      $data['action_type'] = "edit";
      $where = array("id"=>$id);
      $data['car_type'] = $this->database_model->getdata('tbl_car_type','S',$where);
      /*print_r($data['car_type']);die;*/
      $data['sub_title'] = "Update Car Type";
      $data['button'] = "Update";
    }
    $data['title'] = "Car Type";
    
    $this->load->view('super_admin/ajax/add-edit-car-type',$data);
  }

  public function savecartype()
  {
    $params = $this->input->post();

    /*[car_type] => Testing
    [seater_type] => 1
    [luggages_count] => 2
    [luggages_count_small] => 2*/
    $validationarray = array(
             "car_type" => array(
             "filtervalidate"=>"required|trim","key_name"=>"car type"),
             "seater_type" => array(
             "filtervalidate"=>"required|numeric|trim","key_name"=>"seater type"),
             "luggages_count" => array(
             "filtervalidate"=>"required|numeric|trim","key_name"=>"luggages count"),
             "luggages_count_small" => array(
             "filtervalidate"=>"required|numeric|trim","key_name"=>"luggages count small"),
             );
         /*===========Codeigniter From Validation ===================*/
             foreach($params as $key=>$val)
             { 
                $mejardata=$this->formvalidation_model->validationdata($key,$validationarray,$params);
                 if($mejardata!="")
                 {
                  $datavalid=json_decode($mejardata); 
                  echo json_encode(array("status"=>"error","msg"=>$datavalid->message));die;
                 }
             }
         /*===========End Codeigniter From Validation ============*/
    $documentfile = "";
     $filename = $_FILES['car_icon']['name']; 
     $tempfile = $_FILES['car_icon']['tmp_name'];
     $ext = pathinfo($filename, PATHINFO_EXTENSION);

     $filedata = do_single_upload($filename, $tempfile, FCPATH . '/assets/driver_documents/');
    $documentfile='/assets/driver_documents/thumb/'.$filedata;
    if($ext!="mp4" || $ext!="AVIF")
    {
        create_square_image(FCPATH.'/assets/driver_documents/'.$filedata,FCPATH.'/assets/driver_documents/thumb/'.$filedata,200);
    }
    $params['car_icon'] = $documentfile;
    $where="";
    $query = $this->database_model->insertupdate("tbl_car_type",$params,$where);
    if(!empty($query)){
      echo json_encode(array("status"=>"ok","msg"=>"Record Successfully Saved"));die;
    }else{
      echo json_encode(array("status"=>"error","msg"=>"Some error occured"));die;
    }

    
  }

	
}
