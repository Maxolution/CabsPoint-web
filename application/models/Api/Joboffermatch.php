
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Joboffermatch extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array("Api/Check_auth_token","database_model"));
    }

    

    /*============================Marketplace offer Api============================== */

   public function marketplace_offer(){

     $json = file_get_contents('php://input');
      if(!empty($json))
      {
         $params =  json_decode($json, true);
      }else
      {
         $params = $this->input->post();
      } 
      unset($params['filter_by_airport']);
      unset($params['filter_by_car']);
      $airport_id =$this->input->post('filter_by_airport');
      $car_type_id =$this->input->post('filter_by_car');
      $input_array = array("action","access_token","driver_id");
      $requiredarray =array("access_token","driver_id");
      foreach($params as $key=> $value)
      {
        if (!in_array($key, $input_array))
        {
           echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
        }
      }
      unset($params['action']);
      
      if(!empty($params))
      {
          /*===========================For required Filed================================*/
             
          $paramskey = array();
            foreach($params as $key=> $value)
            {
                $paramskey[] = $key;
            }
            foreach($requiredarray as $requiredarray)
            {

                if (!in_array($requiredarray, $paramskey))
                {
                   echo json_encode(array("status"=>"error","msg"=>$requiredarray." key required!"));die;
                }
            }
          /*=========================End For required Filed========================*/



          $validationarray = array(
             "access_token" => array(
             "filtervalidate"=>"required|trim","key_name"=>"Driver ID"),
             "driver_id" => array(
             "filtervalidate"=>"required|trim","key_name"=>"Driver"),
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

          /*=========================Check driver=========================*/
             $check_driver = $this->db->get('driver_tbl')->row_array();
                 if(empty($check_driver))
                 {
                   echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
                 }
          /*====================End Check driver==============================*/       

          /*====================Check Access Token========================*/
             $checktoken =$this->Check_auth_token->checkToken($params['driver_id'],$params['access_token']); 
          /*=======================End Check Access Token=======================*/
          /*=======================Start filter By=======================*/
          if(!empty($airport_id))
          {
            $airport_id ="&& airport_id in ($airport_id)";
          }
          else
          {
            $airport_id ="";
          }
          if(!empty($car_type_id))
          {
            $car_type_id ="&& tbl_offer_job.car_type in ($car_type_id)";
          }
          else
          {
            $car_type_id ="";
          }
          /*======================End Start Filter By=================*/
          $marketplace_offer = $this->db->query('SELECT tbl_offer_job.*,tbl_car_type.car_type as vehicle_type,table_payment_type.payment_type,tbl_offer_customer.phone,tbl_offer_customer.email,tbl_offer_customer.passenger_count,tbl_offer_customer.luggages_count,tbl_offer_customer.bag_count,tbl_offer_customer.flight_name,tbl_offer_customer.city_of_arrival,tbl_offer_customer.meet_after_time,tbl_offer_customer.booker_agency,tbl_airport.airport_name,tbl_airport.airport_code,tbl_airport.airport_area FROM tbl_offer_job INNER JOIN tbl_car_type ON tbl_offer_job.car_type = tbl_car_type.id INNER JOIN table_payment_type ON tbl_offer_job.payment_type = table_payment_type.id INNER JOIN tbl_offer_customer ON tbl_offer_job.id=tbl_offer_customer.offer_id INNER JOIN tbl_airport ON tbl_offer_customer.airport_id= tbl_airport.id WHERE (tbl_offer_job.status=0 || tbl_offer_job.status=9) && tbl_offer_job.driver_id!='.$params['driver_id'].' '.$airport_id.' '.$car_type_id.'')->result();
              // echo $this->db->last_query();die;
              $i=0;

              $newarray = array();
              foreach($marketplace_offer as $val){
                if($val->status==9 || $val->status==0){
                   $marketplace_offer[$i]->status_name = "Pending";
                }else{
                   $this->db->select('status'); 
                   $this->db->where('id',$val->status);
                   $status_name= $this->db->get('tbl_offer_status')->row();
                   $marketplace_offer[$i]->status_name = $status_name->status; 
                }
                $marketplace_offer[$i]->distance = "42.2 Miles";
                //$marketplace_offer[$i]->journey_duration =$this->convertToHoursMins($val->journey_duration, '%02d Hr %02d Min');// "1 Hr 20 Min";
                //$marketplace_offer[$i]->added_time = date_format(date_create($val->added_date),"H :i");
                //$marketplace_offer[$i]->added_date = date_format(date_create($val->added_date),"D, M d, Y");

                $marketplace_offer[$i]->job_time = date_format(date_create($val->journey_time),"H :i");
                $marketplace_offer[$i]->job_date =date_format(date_create($val->journey_time),"D, M d, Y");
              $newarray[] = $marketplace_offer;
              $i++;
              }
              print_r($newarray);die;
              if(!empty($marketplace_offer)){
                echo json_encode(array("status"=>"ok","msg"=>"Show all marketplace offer","response"=>$marketplace_offer));die;
              }else{
                echo json_encode(array("status"=>"ok","msg"=>"Data Not found","response"=>array()));die;
              }
      }else{
          echo json_encode(array("status"=>"error","msg"=>"Some error occurred","response"=>array()));die;
      }

    }

     /*=========================End Marketplace offer Api========================= */
     /*=====================convertToHoursMins==========================*/
     function convertToHoursMins($time, $format = '%02d:%02d') {
	   		 if ($time < 1) {
	       		 return;
	   		 }
	    		$hours = floor($time / 60);
	    		$minutes = ($time % 60);
	    		return sprintf($format, $hours, $minutes);
			}
	/*=====================End convertToHoursMins==========================*/		

     
}