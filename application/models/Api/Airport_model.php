<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Airport_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array("Api/Check_auth_token","database_model"));
	}

	public function getairport(){
		$json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
          $input_array = array("action","access_token","driver_id");
          foreach($params as $key=> $value)
          {
            if (!in_array($key, $input_array))
            {
               echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
            }
          }
          unset($params['action']);
          /*==============================For required Filed=====================*/
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
                    }else if($params[$requiredarray]==""){
                       	echo json_encode(array("status"=>"error","msg"=>$requiredarray." value required!"));die;
                    }
                }
          /*============================End For required Filed====================*/

          /*===============================Check driver===========================*/
                 $check_driver = $this->db->get('driver_tbl')->row_array();
                     if(empty($check_driver))
                     {
                       echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
                     }
              /*===================End Check driver======================*/       

              /*==================Check Access Token===================*/
                 $checktoken =$this->Check_auth_token->checkToken($params['driver_id'],$params['access_token']); 
          /*=============================End Check Access Token=======================*/

          $query = $this->db->get('tbl_airport')->result();
          if(!empty($query)){
          	echo json_encode(array("status"=>"ok","msg"=>"Show all Airport","response"=>$query));die;
          }else{
            echo json_encode(array("status"=>"error","msg"=>"Some error occured"));die;
          }
	}
}
?>