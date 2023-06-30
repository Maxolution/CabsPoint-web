
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Job_offer_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array("Api/Check_auth_token","database_model"));
    }

    public function get_all_job_offer()
    {
        $json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
          if ($this->input->post('page') == 0 || $this->input->post('page') == '')
             {
                $start = 0;
                $end = 10;
             } else if ($this->input->post('page') > 0) {
                $start = 10 * ($this->input->post('page'));
                $end = 10;
             }
          $input_array = array("action","access_token","driver_id","page","filter");
          foreach($params as $key=> $value)
          {
            if (!in_array($key, $input_array))
            {
               echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
            }
          }

          unset($params['action']);
          /*==============For required Filed===============*/
              $requiredarray =array("access_token","driver_id");
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
          /*=====================End For required Filed====================*/
          /*=========================Check driver=========================*/
          $this->db->where('id',$params['driver_id']);
             $check_driver = $this->db->get('driver_tbl')->row_array();
                 if(empty($check_driver))
                 {
                   echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
                 }
          /*====================End Check driver==============================*/       

          /*====================Check Access Token========================*/
             $checktoken =$this->Check_auth_token->checkToken($params['driver_id'],$params['access_token']); 
          /*=======================End Check Access Token=======================*/
           if(!empty($params['filter'])){

            //print_r($params['filter']);die;
            $get_all_job_offer = $this->db->query("SELECT tbl_offer_job.*,tbl_car_type.car_type as vehicle_type,tbl_car_type.seater_type,tbl_car_type.luggages_count,table_payment_type.payment_type,tbl_offer_customer.passenger_count,tbl_offer_customer.luggages_count,tbl_offer_customer.bag_count FROM tbl_offer_job INNER JOIN tbl_car_type ON tbl_offer_job.car_type = tbl_car_type.id INNER JOIN table_payment_type ON tbl_offer_job.payment_type = table_payment_type.id INNER JOIN tbl_offer_customer ON tbl_offer_job.id=tbl_offer_customer.offer_id WHERE (tbl_offer_job.status=8 || tbl_offer_job.status=7) && tbl_offer_job.driver_id='".$params['driver_id']."' ORDER BY updated_date DESC LIMIT $start,$end ")->result();

            //echo $this->db->last_query();die;

           }else{

            $get_all_job_offer = $this->db->query("SELECT tbl_offer_job.*,tbl_car_type.car_type as vehicle_type,tbl_car_type.seater_type,tbl_car_type.luggages_count,table_payment_type.payment_type,tbl_offer_customer.passenger_count,tbl_offer_customer.luggages_count,tbl_offer_customer.bag_count FROM tbl_offer_job INNER JOIN tbl_car_type ON tbl_offer_job.car_type = tbl_car_type.id INNER JOIN table_payment_type ON tbl_offer_job.payment_type = table_payment_type.id INNER JOIN tbl_offer_customer ON tbl_offer_job.id=tbl_offer_customer.offer_id WHERE (tbl_offer_job.status!=0 && tbl_offer_job.status!=9 && tbl_offer_job.status!=7) && tbl_offer_job.driver_id='".$params['driver_id']."' LIMIT $start,$end ")->result();

           }
          $i=0;
          foreach($get_all_job_offer as $val){
            $get_all_job_offer[$i]->distance = "42.2 Miles";
            $get_all_job_offer[$i]->journey_duration = "1 Hr 20 Min";
            //$get_all_job_offer[$i]->added_time = date_format(date_create($val->added_date),"H :i");
            //$get_all_job_offer[$i]->added_date =date_format(date_create($val->added_date),"D, M d, Y");
            $where =array("driver_id"=>$params['driver_id'],"job_offer_id"=>$val->id);
            $status_history = $this->database_model->getdata('tbl_order_status','S',$where,$where_or='');

            $where = array("id"=>$val->status);
            $status_name = $this->database_model->getdata('tbl_offer_status','S',$where,$where_or='');
            if(!empty($status_name)){
               $status_name= $status_name->status;
            }else{
                $status_name = "";
            }
            
            $get_all_job_offer[$i]->status_name = $status_name;
            if(!empty($status_history)){
             $get_all_job_offer[$i]->job_status_history = json_decode($status_history->status_history);   
             }else{
                 $get_all_job_offer[$i]->job_status_history= [];
             }

            //print_r($get_all_job_offer[$i]->job_status_history);die;
            $j=0;
            foreach($get_all_job_offer[$i]->job_status_history as $statuskey){
                $where = array("id"=>$statuskey->status_id);
                $status_name = $this->database_model->getdata('tbl_offer_status','S',$where,$where_or='');
                if(!empty($status_name)){
                    $get_all_job_offer[$i]->job_status_history[$j]->status_name = $status_name->status;
                }else{
                    $get_all_job_offer[$i]->job_status_history[$j]->status_name = "";
                } 
                $j++;

            }



            $get_all_job_offer[$i]->job_time = date_format(date_create($val->journey_time),"H :i");
            $get_all_job_offer[$i]->job_date =date_format(date_create($val->journey_time),"D, M d, Y");

          $i++;
          }
          if(!empty($get_all_job_offer)){
            echo json_encode(array("status"=>"ok","msg"=>"Show all job offer","response"=>$get_all_job_offer));die;
          }else{
            echo json_encode(array("status"=>"error","msg"=>"Data not found","response"=>array()));die;
          }


    }
    
    public function no_show_formality()
    {
          $json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
          $input_array = array("action","access_token","driver_id","offer_id","status_id","file_type");
          $requiredarray =array("access_token","driver_id","offer_id","status_id","file_type");
          if($params['status_id']!=8){
            unset($params['file_type']);
            unset($input_array[5]);
            unset($requiredarray[4]);
          }else{
            if(!isset($_FILES['file']['name'])){
             echo json_encode(array("status"=>"error","msg"=>"file key does not exist!"));die;   
            }
          }
          foreach($params as $key=> $value)
          {
            if (!in_array($key, $input_array))
            {
               echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
            }
          }
          unset($params['action']);
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
          /*tbl_order_status*/
          $this->db->where('job_offer_id',$params['offer_id']);
          $this->db->where('driver_id',$params['driver_id']);
          $check_order = $this->db->get('tbl_order_status')->row();
          $params['job_offer_id'] = $params['offer_id'];
          $params['status'] = $params['status_id'];
          $history = array();
          if($params['status_id']!=8){
           $file[] = array("file_type"=>"","file"=>"","file_status"=>"");
          }else
          {

             $documentfile = "";
             $filename = $_FILES['file']['name']; 
             $tempfile = $_FILES['file']['tmp_name'];
             $ext = pathinfo($filename, PATHINFO_EXTENSION);

             $filedata = do_single_upload($filename, $tempfile, FCPATH . '/assets/driver_documents/');
            $documentfile='/assets/driver_documents/thumb/'.$filedata;
            if($ext!="mp4")
            {
                create_square_image(FCPATH.'/assets/driver_documents/'.$filedata,FCPATH.'/assets/driver_documents/thumb/'.$filedata,200);
            }

            $file[] = array("file_type"=>$params['file_type'],"file"=>$documentfile,"file_status"=>"Pending"); 
          }
          
          $history['status_id'] = $params['status_id'];
          $history['status_date'] = date("Y-m-d h:i:s");
          $history['file_data'] = $file;
          unset($params['access_token']);
          unset($params['offer_id']);
          unset($params['status_id']);
          unset($params['file_type']);
          unset($params['file']);
          if(!empty($check_order))
          {
            $status_history=$history;
            $params['status_history'] = json_encode($status_history);
            if(!empty($check_order->status_history))
            {

            /*============Start Manage file type for status history=============*/
               $checkprehistory = json_decode($check_order->status_history);
               $i=0;
               $check_pre_status=array();
               foreach($checkprehistory as $key=> $value){
                 $check_pre_status[] =$value->status_id;
                  if($value->status_id==$history['status_id']){
                    $j=0;
                    $check_pre_file =array();
                    foreach($value->file_data as $file_data)
                    {
                        $check_pre_file[] =$file_data->file_type;
                        if($file_data->file_type==$file[0]['file_type']){
                             $checkprehistory[$i]->file_data[$j]=$file[0];
                        }
                      $j++;
                    }
                    
                    if(!in_array($file[0]['file_type'],$check_pre_file)){
                    $checkprehistory[$i]->file_data[] =(object) $file[0];
                    }
                    $status_history['file_data']=$checkprehistory[$i]->file_data;
                    
                    $checkprehistory[$i]=$status_history;  
                  }
                $i++;
               }
               if(!in_array($history['status_id'],$check_pre_status))
               {
                    $checkprehistory[] =$status_history;
               }
             /*=============End Manage file type for status history=============*/
               $params['status_history'] = json_encode($checkprehistory);
               $driver_id = $params['driver_id'];
               $job_offer_id = $params['job_offer_id'];
               unset($params['driver_id']);
               unset($params['job_offer_id']);
               $params['updated_date'] = date("Y-m-d h:i:s");
               $this->db->where('driver_id',$driver_id);
               $this->db->where('job_offer_id',$job_offer_id);
               $result = $this->db->update('tbl_order_status',$params);
            }


          }else{
            $status_history[]=$history;
            $params['status_history'] = json_encode($status_history);
            $params['added_date'] = date("Y-m-d h:i:s");
            $result = $this->db->insert('tbl_order_status',$params);
          }
          if(!empty($result)){
            $this->db->where('driver_id',$driver_id);
            $this->db->where('id',$job_offer_id);
            $this->db->update('tbl_offer_job',array("status"=>$params['status']));

            echo json_encode(array("status"=>"ok","msg"=>"Data updated successfully"));die;
          }else{
            echo json_encode(array("status"=>"error","msg"=>"An error occurred"));die;
          }
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

      if ($this->input->post('page') == 0 || $this->input->post('page') == '')
             {
                $start = 0;
                $end = 10;
             } else if ($this->input->post('page') > 0) {
                $start = 10 * ($this->input->post('page'));
                $end = 10;
             }
      unset($params['filter_by_airport']);
      unset($params['filter_by_car']);
      unset($params['alert_type']);
      $airport_id =$this->input->post('filter_by_airport');
      $car_type_id =$this->input->post('filter_by_car');
      $alert_type = $this->input->post('alert_type');
      $input_array = array("action","access_token","driver_id","page");
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
             $this->db->where('id',$params['driver_id']);
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
          $alert = "";//For Alert Notification
          if(!empty($alert_type)){
            if($alert_type=="Y"){
                $alert = "&& (tbl_offer_job.added_date between now()-Interval 1 minute and now())";
            }
          }
           //echo $start;die;
          /*======================End Start Filter By=================*/
          $marketplace_offer = $this->db->query("SELECT tbl_offer_job.*,tbl_car_type.car_type as vehicle_type,table_payment_type.payment_type,tbl_offer_customer.phone,tbl_offer_customer.email,tbl_offer_customer.passenger_count,tbl_offer_customer.luggages_count,tbl_offer_customer.bag_count,tbl_offer_customer.flight_name,tbl_offer_customer.city_of_arrival,tbl_offer_customer.meet_after_time,tbl_offer_customer.booker_agency,tbl_airport.airport_name,tbl_airport.airport_code,tbl_airport.airport_area FROM tbl_offer_job INNER JOIN tbl_car_type ON tbl_offer_job.car_type = tbl_car_type.id INNER JOIN table_payment_type ON tbl_offer_job.payment_type = table_payment_type.id INNER JOIN tbl_offer_customer ON tbl_offer_job.id=tbl_offer_customer.offer_id INNER JOIN tbl_airport ON tbl_offer_customer.airport_id= tbl_airport.id WHERE (tbl_offer_job.status=0 || tbl_offer_job.status=9) && tbl_offer_job.driver_id!='".$params['driver_id']."' $airport_id $car_type_id $alert LIMIT $start , $end ")->result();
              //echo $this->db->last_query();die;
              $i=0;
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
                $marketplace_offer[$i]->journey_duration = "1 Hr 20 Min";
                //$marketplace_offer[$i]->added_time = date_format(date_create($val->added_date),"H :i");
                //$marketplace_offer[$i]->added_date = date_format(date_create($val->added_date),"D, M d, Y");

                $marketplace_offer[$i]->job_time = date_format(date_create($val->journey_time),"H :i");
                $marketplace_offer[$i]->job_date =date_format(date_create($val->journey_time),"D, M d, Y");

              $i++;
              }
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

     /*=========================Accept job offer Api============================== */
     public function acceptjoboffer(){

        $json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
          $input_array = array("action","access_token","driver_id","job_offer_id","status_id");
          $requiredarray =array("access_token","driver_id","job_offer_id","status_id");
          foreach($params as $key=> $value)
          {
            if (!in_array($key, $input_array))
            {
               echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
            }
          }
          unset($params['action']);
          /*=========================For required Filed=====================*/
              $requiredarray =array("access_token","driver_id","job_offer_id","status_id");
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
                    }else if($params[$requiredarray]==""){
                        echo json_encode(array("status"=>"error","msg"=>$requiredarray." value required!"));die;
                    }
                }
          /*============================End For required Filed====================*/
          /*===============================Check driver===========================*/
                 $this->db->where('id',$params['driver_id']);
                 $check_driver = $this->db->get('driver_tbl')->row_array();
                     if(empty($check_driver))
                     {
                       echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
                     }
              /*===================End Check driver======================*/       

              /*==================Check Access Token===================*/
                 $checktoken =$this->Check_auth_token->checkToken($params['driver_id'],$params['access_token']); 
          /*=========================End Check Access Token=====================*/
          
          $driver_id = $params['driver_id'];
          $job_offer_id = $params['job_offer_id'];
          $params['status'] = $params['status_id'];
          unset($params['access_token']);
          unset($params['job_offer_id']);
          unset($params['status_id']);
          $this->db->where('id',$job_offer_id);
          $query = $this->db->update("tbl_offer_job",$params);
          if(!empty($query)){
            $datas =$this->generatestatus_history($driver_id,$job_offer_id,$params['status']);
            if($params['status']==2){
                $msg = "Job offer accepted successfully";
            }else{
                $msg = "Status updated successfully";
            }
            echo json_encode(array("status"=>"ok","msg"=>$msg));die;
          }else{
            echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
          }

     }



     /*=======================End Accept job offer Api========================== */

     function generatestatus_history($driver_id=false,$offer_id=false,$status_id=false){
          $this->db->where('job_offer_id',$offer_id);
          $this->db->where('driver_id',$driver_id);
          $check_order = $this->db->get('tbl_order_status')->row();
          $params['job_offer_id'] = $offer_id;
          $params['status'] = $status_id;
          $params['driver_id'] = $driver_id;
          $history = array();
          if($status_id!=8){
           $file[] = array("file_type"=>"","file"=>"","file_status"=>"");
          }else{

             $documentfile = "";
             $filename = $_FILES['file']['name']; 
             $tempfile = $_FILES['file']['tmp_name'];
             $ext = pathinfo($filename, PATHINFO_EXTENSION);

             $filedata = do_single_upload($filename, $tempfile, FCPATH . '/assets/driver_documents/');
            $documentfile='/assets/driver_documents/thumb/'.$filedata;
            if($ext!="mp4")
            {
                create_square_image(FCPATH.'/assets/driver_documents/'.$filedata,FCPATH.'/assets/driver_documents/thumb/'.$filedata,200);
            }

            $file[] = array("file_type"=>$params['file_type'],"file"=>$documentfile,"file_status"=>""); 
          }
          $history['status_id'] = $status_id;
          $history['status_date'] = date("Y-m-d h:i:s");
          $history['file_data'] = $file;


          if(!empty($check_order))
          {

            $status_history=$history;
            $params['status_history'] = json_encode($status_history);
            if(!empty($check_order->status_history))
            {

            /*============Start Manage file type for status history=============*/
               $checkprehistory = json_decode($check_order->status_history);
               $i=0;
               $check_pre_status=array();
               foreach($checkprehistory as $key=> $value){
                 $check_pre_status[] =$value->status_id;
                  if($value->status_id==$history['status_id']){
                    $j=0;
                    $check_pre_file =array();
                    foreach($value->file_data as $file_data)
                    {
                        $check_pre_file[] =$file_data->file_type;
                        if($file_data->file_type==$file[0]['file_type']){
                             $checkprehistory[$i]->file_data[$j]=$file[0];

                        }
                         $checkprehistory[$i]->file_data[$j]['file_status']="";
                      $j++;
                    }
                    
                    if(!in_array($file[0]['file_type'],$check_pre_file)){
                    $checkprehistory[$i]->file_data[] =(object) $file[0];
                    }
                    $status_history['file_data']=$checkprehistory[$i]->file_data;
                    $checkprehistory[$i]=$status_history;  
                  }
                $i++;
               }

               if(!in_array($history['status_id'],$check_pre_status))
               {
                    $checkprehistory[] =$status_history;
               }
             /*=============End Manage file type for status history=============*/
               $params['status_history'] = json_encode($checkprehistory);
               $driver_id = $driver_id;
               $job_offer_id = $offer_id;
               $params['updated_date'] = date("Y-m-d h:i:s");
               $this->db->where('driver_id',$driver_id);
               $this->db->where('job_offer_id',$offer_id);
               $result = $this->db->update('tbl_order_status',$params);
            }else{
                $checkprehistory[] =$history;
                $params['status_history'] = json_encode($checkprehistory);
                $driver_id = $driver_id;
                $job_offer_id = $offer_id;
                $params['updated_date'] = date("Y-m-d h:i:s");
                $this->db->where('driver_id',$driver_id);
                $this->db->where('job_offer_id',$offer_id);
                $result = $this->db->update('tbl_order_status',$params);
            }


          }else{
            $status_history[]=$history;
            $params['status_history'] = json_encode($status_history);
            $params['added_date'] = date("Y-m-d h:i:s");
            //print_r($params);die;
            //return $params;
            $result = $this->db->insert('tbl_order_status',$params);
          }
     }

     function get_all_status(){

        $json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
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
          /*=========================For required Filed=====================*/
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
                    }else if($params[$requiredarray]==""){
                        echo json_encode(array("status"=>"error","msg"=>$requiredarray." value required!"));die;
                    }
                }
          /*=======================End For required Filed===================*/
          /*=========================Check driver===========================*/
                 $this->db->where('id',$params['driver_id']);
                 $check_driver = $this->db->get('driver_tbl')->row_array();
                     if(empty($check_driver))
                     {
                       echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
                     }
            /*=====================End Check driver======================*/       

            /*====================Check Access Token=====================*/
                 $checktoken =$this->Check_auth_token->checkToken($params['driver_id'],$params['access_token']); 
            /*==================End Check Access Token====================*/
              $query = $this->db->get('tbl_offer_status')->result();
              if(!empty($query)){
                echo json_encode(array("status"=>"ok","msg"=>"Show all status","response"=>$query));die;
              }else{
                echo json_encode(array("status"=>"error","msg"=>"Some error occured"));die;
              }



     }
    
}