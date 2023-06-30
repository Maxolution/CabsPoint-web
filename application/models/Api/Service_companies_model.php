
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Service_companies_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array("Api/Check_auth_token","database_model"));
    }

    /*=================Start Service Companies========================*/
	
	public function main()
	{
		$params = $this->input->post();
		$input_array = array("action","access_token","driver_id","type");

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
          /*==============End For required Filed===============*/
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
          if(!empty($params['type'])){
           $this->db->where('service_type',$params['type']);
          }
          $this->db->order_by("isSponsored", "true","desc");
          $result = $this->db->get('service_companies')->result();
          $i=0;
          foreach($result as $val){
          	if($val->isSponsored=="true"){
               $result[$i]->isSponsored = true;
          	}else{
          		$result[$i]->isSponsored = false;
          	}

           $i++;
          }
          if(!empty($result)){
          	echo json_encode(array("status"=>"ok","response"=>$result));die;
          }else{
          	echo json_encode(array("status"=>"error","response"=>$result));die;
          }
          

			 

	}
   /*===========================End Service Companies========================*/





}
