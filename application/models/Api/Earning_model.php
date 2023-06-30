<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Earning_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array("Api/Check_auth_token","database_model"));
    }
    public function get_earning(){
        $json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
          $input_array = array("action","filter_date","access_token","driver_id");
          foreach($params as $key=> $value)
          {
            if (!in_array($key, $input_array))
            {
               echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
            }
          }

          unset($params['action']);
             /*==============For required Filed===============*/
              $requiredarray =array("filter_date","access_token","driver_id");
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
              /*==============End For required Filed===============*/
              /*===================Check driver======================*/
                 $check_driver = $this->db->get('driver_tbl')->row_array();
                     if(empty($check_driver))
                     {
                       echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
                     }
              /*===================End Check driver======================*/       

              /*==================Check Access Token===================*/
                 $checktoken =$this->Check_auth_token->checkToken($params['driver_id'],$params['access_token']); 
              /*==================End Check Access Token===================*/

              /*===========Codeigniter From Validation ===================*/
              $validationarray = array(
                 /*"filter_date" => array(
                 "filtervalidate"=>"required","key_name"=>"Filter date"),*/
                 "access_token" => array(
                 "filtervalidate"=>"required|trim","key_name"=>"Access token"),
                 "driver_id" => array(
                 "filtervalidate"=>"required|trim","key_name"=>"Driver id"),
                 );
             
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

             /*=================For Flow Chart Data===================*/
             /*SELECT * FROM `tbl_offer_job` where DATE(updated_date) > ('2023-06-16' - INTERVAL 7 DAY);*/
                if(empty($params['filter_date'])){
                  $params['filter_date'] = "'".date('Y-m-d', strtotime(' +1 day'))."'";
                }else{
                   $input_date = date("Y-m-d",strtotime ( '+1 day' , strtotime($params['filter_date'])));
                   $params['filter_date'] = "'".$input_date."'";
                }
                 $flowchart_array = array();
                 $flowchart = $this->db->query('SELECT ab.id,DATE_FORMAT(ab.updated_date,"%Y-%m-%d") as date,SUM(ab.original_price) as total_earning FROM tbl_offer_job ab JOIN driver_tbl ON ab.driver_id = driver_tbl.id WHERE ab.driver_id = '.$params['driver_id'].' AND ab.status = 7 AND ab.updated_date >= date_sub('.$params['filter_date'].', interval weekday('.$params['filter_date'].') day) and ab.updated_date <= '.$params['filter_date'].' GROUP BY date')->result();
                 //echo $this->db->last_query();die;
                 

                 foreach($flowchart as $key=>$val){
                 $this->db->select('original_price as price,id as offer_id');
                 $this->db->where('driver_id',$params['driver_id']);
                 $this->db->like('updated_date',$val->date);
                 $earningdata = $this->db->get('tbl_offer_job')->result();
                   $flowchart[$key]->earning_details = $earningdata;
                 }
               
             /*=================End For Flow Chart Data===================*/

                 $this->db->select('sum(original_price) as total_earning,ab.id as offer_id,driver_tbl.username,driver_tbl.driver_city,count(ab.status) as trip_complete');
                 $this->db->from('tbl_offer_job ab');
                 $this->db->join('driver_tbl','ab.driver_id = driver_tbl.id');
                 $this->db->where('ab.driver_id',$params['driver_id']);
                 $this->db->where('ab.status',"7");
                 if($params['filter_date']!=""){
                    $this->db->like('ab.updated_date', $params['filter_date']); 
                 }
                
                 $earning = $this->db->get()->row();


                 $check_status= $this->db->query('SELECT tbl_order_status.status as id,tbl_offer_status.status as status_name,COUNT(tbl_order_status.status) as count_status FROM `tbl_order_status` RIGHT JOIN tbl_offer_status ON tbl_order_status.status= tbl_offer_status.id WHERE ((tbl_order_status.driver_id ='.$params['driver_id'].' && week(tbl_order_status.updated_date)=week(now())) || tbl_order_status.driver_id IS NULL) && (tbl_offer_status.id=7 || tbl_offer_status.id=8 || tbl_offer_status.id=9) GROUP BY tbl_offer_status.status')->result();
                $totalcount = 0;
                 foreach($check_status as $key=>$value){
                    $totalcount = $totalcount+ $value->count_status;
                 }
                 $earning->check_status = $check_status;
                 $earning->status_count = $totalcount;
                 $earning->flowchart_data = $flowchart;
                 echo json_encode(array("status"=>"ok","msg"=>"","response"=>$earning));die;
             

    }
}