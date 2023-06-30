<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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

    $data['title'] = "Dashboard";
    $data['page_title'] = "On Boarding Driver";
    $data['all_driver'] =$this->database_model->getdata("driver_tbl","L");
    if(!empty($data['all_driver'])){
      foreach($data['all_driver'] as $keyf=>$val){
           $data['all_driver'][$keyf]->profile_pic = base_url('/'.$val->profile_pic);
          /* ==================Vehicle type===================== */
          $where = array("id"=>$val->vehicle_type);
          $vehicle_type = $this->database_model->getdata("tbl_car_type","S");
          if(!empty($vehicle_type)){
            $data['all_driver'][$keyf]->vehicle_type = $vehicle_type->car_type;
          }

          /* ==================End Vehicle type===================== */


          /*===================check Approved document==================*/
            $this->db->where('driver_id', $val->id);
           $driver_document = $this->db->get('driver_document')->row_array();
           $data['all_driver'][$keyf]->registration_num = "";
           $data['all_driver'][$keyf]->vehicle_color = "";
           if(!empty($driver_document))
           {
            $data['all_driver'][$keyf]->registration_num = $driver_document['registration_num'];
            $data['all_driver'][$keyf]->vehicle_color = $driver_document['vehicle_color'];
            $array_data = array();
            $fordocument=array("driver_license_f","driver_license_b","driver_pco","driver_pco_b","N_I","logbook","rental_agreement","vehicle_pco","driver_photo","M_O_T","insurance");
            foreach($driver_document as $key=> $value){
             if (in_array($key, $fordocument))
              {
                if(!empty($driver_document[$key])){
                 $driver_document[$key] = base_url($value); 
                }else{
                  $array_data[$key] = "";
                }
               
              }


              if($key=="status"){
                if(!empty($driver_document[$key])){
                  $value = json_decode($value);
                  foreach($array_data as $key=>$doc){
                    $value->$key= "Pending";
                  };
                  $value = json_encode($value);
                  
                  $driver_document['file_status'] =json_decode($value);
                  $checkapproved= "";
                  foreach($driver_document['file_status'] as $checkflag){
                    if($checkflag=="Pending"){
                      $checkapproved = $checkflag;
                    }else if($checkflag=="Rejected"){
                      $checkapproved = $checkflag;
                    }
                 }
                 if($checkapproved=="Pending" || $checkapproved=="Rejected"){
                  $data['all_driver'][$keyf]->document_status = "Pending";
                 }else{
                  $data['all_driver'][$keyf]->document_status = "Accepted";
                 }
               }else{
                  $data['all_driver'][$keyf]->document_status = "Pending";
               }
              }

            }
            
            $data['all_driver'][$keyf]->driver_photo = $driver_document['driver_photo'];
           }else{
            $data['all_driver'][$keyf]->document_status = "Pending";
            $data['all_driver'][$keyf]->driver_photo = "";
           }


          /*===================end check Approved document==================*/
      }
    }
  //echo "<pre>";print_r($data['all_driver']);die;

		$this->load->view('super_admin/dashboard',$data);
	}
  public function getdatalist(){
   $data ='{
  "recordsTotal": 5,
  "recordsFiltered": 5,
  "data": [
    {
      "id": 76,
      "examYear": 2020,
      "scholarshipLevelId": 1,
      "candidateTotal": 0,
      "candidateBoy": 0,
      "candidateGirl": 0
    },
    {
      "id": 75,
      "examYear": 2020,
      "scholarshipLevelId": 1,
      "candidateTotal": 0,
      "candidateBoy": 0,
      "candidateGirl": 0
    },
    {
      "id": 74,
      "examYear": 2019,
      "scholarshipLevelId": 2,
      "candidateTotal": 0,
      "candidateBoy": 0,
      "candidateGirl": 0
    },
    {
      "id": 73,
      "examYear": 2019,
      "scholarshipLevelId": 1,
      "candidateTotal": 0,
      "candidateBoy": 0,
      "candidateGirl": 0
    },
    {
      "id": 72,
      "examYear": 2020,
      "scholarshipLevelId": 2,
      "candidateTotal": 0,
      "candidateBoy": 0,
      "candidateGirl": 0
    }
  ]
}';
echo $data;
  }

	
}
