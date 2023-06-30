
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formvalidation_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
    }
	
	 public function validationdata($key,$validationarray,$data)
	 { 


		 $validationdata = array();
		 if(!empty($key)){
			 if(!empty($validationarray))
			 {

				 foreach($validationarray as $keyname=> $keyvalue)
				 { 
				 	
				 	if($keyname==$key)
				 	{
                      
					 $j=0;
					 foreach($keyvalue as $nameofkey=> $keydata)
					 {
                      
					 if($keydata!="")
						 {
							 if($j==0) 
							 { 
							 	
							 $validationdata[$nameofkey]=$keydata;
							 }
							 if($j==1) 
							 {
                              
							 $validationdata[$nameofkey]=$keydata;
							 }
							 $j++;
						 }
					 }

                     if(isset($validationdata['key_name']))
					 {
					 	
					  $key_name=$validationdata['key_name'];
					 }else
					 {
					  $key_name=$key;
					 }
					
					 $this->form_validation->set_data($data);
					 $this->form_validation->set_rules($key, $key_name,$validationdata['filtervalidate']);
					 $this->form_validation->set_error_delimiters('','');
					 $this->form_validation->set_message('message', 'Enter %s');
					 if ($this->form_validation->run() == FALSE)
					 {
						 if(form_error($key))
						 { 
						 	return $this->errorResp(form_error($key));die;
						 }
					 }
					 if($this->security->xss_clean($data[$key], TRUE) === FALSE)
					 {
					   return $this->errorResp('Script Format Data Is Not Allowed');die;
					 }


					}
				 }
				 
				
			 }
		 }

		 
	 } 
		 public function errorResp($message)
		 {
			 $resp = array(
			 'success' => false,
			 'message' => $message
			 ); 
			 return json_encode($resp);
		 } 
	     public function successResp($data,$message="")
		 {
			 $resp = array(
			 'success' => true,
			 'response' => $data,
			 'message' => $message
			 ); 
			 return json_encode($resp);
		 } 
	 //=============End Validation Funtion===========//
}
