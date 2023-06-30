<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DriverController extends CI_Controller {

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

   public function driver_document($driver_id=false){
    if(!empty($driver_id)){
      $where = array('id'=>$driver_id);
      $data['driver_details'] =$this->database_model->getdata("driver_tbl","S",$where);


      $this->db->where('driver_id', $driver_id);
           $driver_document = $this->db->get('driver_document')->row_array();
           if(!empty($driver_document))
           {
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
                $value = json_decode($value);
                foreach($array_data as $key=>$doc){
                  $value->$key= "";
                }
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
                $$data['driver_details']['flag_screen']= $data['driver_details']['flag_screen'];
               }else{
                 $data['driver_details']->flag_screen = "5";
               }
                
                /*foreach($driver_document['file_status'] as $checkflag){
                 if($checkflag=="Accepted"){// Change there status is remaining
                  $check_driver['flag_screen'] = 5;
                 }else{
                  $check_driver['flag_screen']= 4;
                 }
               }*/

                unset($driver_document['status']);
              }

            }
            if(!empty($driver_document['document_details'])){
              $driver_document['document_details'] = json_decode($driver_document['document_details']);
            }else{
          $driver_document['document_details'] = [];
        }
            $data['driver_details']->driver_document = $driver_document;
           }else{
            $data['driver_details']->driver_document = "";
           }
           $data['driver_details']->driver_id=$data['driver_details']->id;

           /*==============Driver Preferred Shift===============*/
           $this->db->select('all_day,shift_for_all_day,mon,tue,wed,thu,fri,sat,sun');
             $this->db->where('driver_id', $data['driver_details']->id);
         $preferred_shift = $this->db->get('tbl_preferred_shift')->row_array();
         //print_r($preferred_shift);die;
         if(!empty($preferred_shift)){
          if($preferred_shift['all_day']=="yes")
         {
           $preferred_shift['mon'] = $preferred_shift['shift_for_all_day'];
           $preferred_shift['tue'] = $preferred_shift['shift_for_all_day'];
           $preferred_shift['wed'] = $preferred_shift['shift_for_all_day'];
           $preferred_shift['thu'] = $preferred_shift['shift_for_all_day'];
           $preferred_shift['fri'] = $preferred_shift['shift_for_all_day'];
           $preferred_shift['sat'] = $preferred_shift['shift_for_all_day'];
           $preferred_shift['sun'] = $preferred_shift['shift_for_all_day'];
           unset($preferred_shift['shift_for_all_day']);

         }else if($preferred_shift['all_day']=="no"){
          unset($preferred_shift['shift_for_all_day']);
         }

         }else{
           $preferred_shift['mon'] = "";
           $preferred_shift['tue'] = "";
           $preferred_shift['wed'] = "";
           $preferred_shift['thu'] = "";
           $preferred_shift['fri'] = "";
           $preferred_shift['sat'] = "";
           $preferred_shift['sun'] = "";
           unset($preferred_shift['shift_for_all_day']);

         }
         

        $data['driver_details']->preferred_shift=$preferred_shift;
         
      }else{
        $data['driver_details'] = [];
      }
      //echo "<pre>";print_r($data);die;
      $this->load->view('super_admin/driver/driver_document',$data);
   
   }

   public function on_boarding_driver()
   {

    $data['title'] = "On Boarding Driver";
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

    $this->load->view('super_admin/driver/on-boarding-driver',$data);
   }
	
   public function driver_details()
   {
		$this->load->view('super_admin/driver/driver_document');
   }

   
  

	
}
