<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Check_auth_token extends CI_Model {

    public function __construct()
    {
         parent::__construct();
    }
    public function checkToken($driver_id=false,$token=false){
	     $wherearray = array("id"=>$driver_id,"token"=>$token);
		 $checktoken = $this->database_model->getdata('driver_tbl','S',$wherearray);
		 if(!empty($checktoken)){
		 	return true;
		 }else{
		 	//return false;
		 	echo json_encode(array("status"=>"error","msg"=>"Invalid access token."));die;
		 }
    }

}
