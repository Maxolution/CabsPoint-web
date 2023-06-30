
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*==============Developed By Rajan Singh Raghuvanshi==================*/
class Driver_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array("Api/Check_auth_token","database_model"));
    }

    /*=================Start Signup Api's========================*/
	
	public function signup_driver()
	{
		$params = $this->input->post();
		$input_array = array("action","driver_name","gender","mobile","password","referral_code","email_address");

			foreach($params as $key=> $value)
			{
				  if (!in_array($key, $input_array))
				  {
				   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
				  }
			 }
			 unset($params['action']);
      

		/*==============For required Filed===============*/
          $requiredarray =array("gender","mobile","driver_name","password","email_address");
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

			 $validationarray = array(
				 "email_address" => array(
				 "filtervalidate"=>"required|valid_email|is_unique[driver_tbl.email_address]","key_name"=>"Email Address"),
				 "mobile" => array(
				 "filtervalidate"=>"required|trim|is_unique[driver_tbl.mobile]","key_name"=>"Mobile Number"),
				 "driver_name" => array(
				 "filtervalidate"=>"required|trim","key_name"=>"Driver Name"),
				 "password" => array(
				 "filtervalidate"=>"required|trim","key_name"=>"Password"),
				 );
           /*===================From Validation===================*/
			 foreach($params as $key=>$val)
			 { 
			 	$mejardata=$this->formvalidation_model->validationdata($key,$validationarray,$params);
				 if($mejardata!="")
				 {
				 $datavalid=json_decode($mejardata);
				  echo json_encode(array("status"=>"error","msg"=>$datavalid->message));die;
				 }
			 }
			/*===================End From Validation===================*/
			
             $params['username'] = $this->generate_unique_username($params['driver_name'], $rand_no = 2000);
			 $params['added_date'] = date("Y-m-d h:i:sa");
			 $params['flag_screen'] = 1;
			 $result = $this->db->insert('driver_tbl', $params);
			 $driver_id = $this->db->insert_id();

			 if(!empty($result))
			 {
			 	$driver_details= $this->db->get_where('driver_tbl',array('id'=>$driver_id))->row_array();
			 	$driver_details['driver_id']= $driver_details['username'];
			 	$driver_details['edit_profile_status'] = json_decode($driver_details['edit_profile_status']);
			 	unset($driver_details['username']);
                 echo json_encode(array("status"=>"ok","msg"=>"Congratulations, your account has been successfully created.","response"=>$driver_details));die;
			 }else
			 {
                 echo json_encode(array("status"=>"error","msg"=>"Some error occured","response"=>array()));die;
			 }

	}
   /*===========================End Signup Api's========================*/




   /*=========================Add Vehicle Type===========================*/

   public function add_vehicle_type(){
   	$params =  $this->input->post();
		$input_array = array("action","car_type_id","driver_id");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		 }
		 /*==============For required Filed===============*/
          $requiredarray =array("car_type_id","driver_id");
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
							  if($params[$requiredarray]==""){
							  	echo json_encode(array("status"=>"error","msg"=>$requiredarray." value required!"));die;
							  }
						 }
		        /*==============End For required Filed===============*/
		         unset($params['action']);
		         $this->db->where('id', $params['driver_id']);
		         $check_driver = $this->db->get('driver_tbl')->row_array();
		         if(empty($check_driver))
		         {
		           echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
		         }
		        $driver_id = $params['driver_id'];
		        $params['vehicle_type'] = $params['car_type_id'];
		        unset($params['driver_id']);
		        unset($params['car_type_id']);
		        if($check_driver['flag_screen']!=2 && $check_driver['flag_screen']==1){
                    	$params['flag_screen'] = 2;
                    }
		        
				$this->db->where('id', $driver_id);
				$result = $this->db->update('driver_tbl', $params);
				if(!empty($result))
				{
				  $driver_details= $this->db->get_where('driver_tbl',array('id'=>$driver_id))->row_array();
		                 echo json_encode(array("status"=>"ok","msg"=>"Data updated successfully.","response"=>$driver_details));die;	
				}else
				{
					 echo json_encode(array("status"=>"error","msg"=>"Some error occured","response"=>array()));die;
				}
        


   }


   /*==========================End Vehicle Type===========================*/








	/*==================Start Add Driver Address Api's==================*/

	public function driver_address()
	{

		$params =  $this->input->post();
		$input_array = array("action","driver_city","city_lat","city_long","driver_id","preferred_sift","preferred_sift_day","all_day");

		//print_r($params['preferred_sift']);die;
		
		foreach($params as $key=> $value)
		{

			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		 }
       
       /*==============For required Filed===============*/
          $requiredarray =array("driver_city","driver_id","preferred_sift","preferred_sift_day","all_day");

          if($params['all_day']=="yes"){
         	 unset($requiredarray[3]);
         	}
        
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

		 
		 unset($params['action']);
		 $validationarray = array(
			 "driver_city" => array(
			 "filtervalidate"=>"required|trim","key_name"=>"Driver City"),
			 "city_lat" => array(
			 "filtervalidate"=>"required","key_name"=>"City Lat"),
			 "city_long" => array(
			 "filtervalidate"=>"required","key_name"=>"City Long"),
			 "driver_id" => array(
			 "filtervalidate"=>"required","key_name"=>"Driver Id"),
			 "preferred_sift[]" => array(
			 "filtervalidate"=>"required","key_name"=>"Preferred Shift"),
			 "preferred_sift_day[]" => array(
			 "filtervalidate"=>"required","key_name"=>"Preferred Shift Day"),
			 );
		 /*===================From Validation===================*/
			 foreach($params as $key=>$val)
			 { 
			 	$mejardata=$this->formvalidation_model->validationdata($key,$validationarray,$params);
				 if($mejardata!="")
				 {
				  $datavalid=json_decode($mejardata); 
				  echo json_encode(array("status"=>"error","msg"=>$datavalid->message));die;
				 }
			 }
		 /*===================End From Validation===================*/

		/*=======================For Set data for preferred Shift====================*/
         if($params['all_day']=="yes"){
         	$preferred_shift['shift_for_all_day'] = $params['preferred_sift'][0];
         	$preferred_shift['all_day'] = $params['all_day'];
         }else{
         	//print_r($params['preferred_sift_day']);die;
         	$i=0;
         	foreach($params['preferred_sift_day'] as $day){
         		$preferred_shift[$day] = $params['preferred_sift'][$i];
         		$i++;
         	}
         	
         	/*$preferred_shift[$params['preferred_sift_day']] = $params['preferred_sift'];*/
         	$preferred_shift['all_day'] = $params['all_day'];
         	
         }
		/*================End For Set data for preferred Shift=================*/ 
		 unset($params['preferred_sift']);
		 unset($params['preferred_sift_day']);
		 unset($params['all_day']);
		 $preferred_shift['driver_id'] = $params['driver_id'];
		 $this->db->where('id', $params['driver_id']);
         $check_driver = $this->db->get('driver_tbl')->row_array();
         if(empty($check_driver))
         {
           echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
         }
        $driver_id = $params['driver_id'];
        if($check_driver['flag_screen']!=3 && $check_driver['flag_screen']==2){
                    	$params['flag_screen'] = 3;
         }
        
        unset($params['driver_id']);
		$this->db->where('id', $driver_id);
		$result = $this->db->update('driver_tbl', $params);
		if(!empty($result))
		{
	 /*==============================For preferred Shift=============================*/
	  $driver_details= $this->db->get_where('driver_tbl',array('id'=>$driver_id))->row_array();
		 $this->db->where('driver_id', $driver_id);
		 $check_driver = $this->db->get('tbl_preferred_shift')->row_array();
		 if(empty($check_driver))
		 {
		 $preferred_shift['added_date']	= date("Y-m-d h:i:sa");
	 	 $result = $this->db->insert('tbl_preferred_shift', $preferred_shift);
	 	 $preferred_shift_id = $this->db->insert_id();
		 $this->db->where('id', $driver_id);
	     $this->db->update('driver_tbl', array("preferred_shift_id"=>$preferred_shift_id));
	     $driver_details['preferred_shift_id'] = $preferred_shift_id;

		 }else
		 {
		 	unset($preferred_shift['driver_id']);
		 	$preferred_shift['updated_date'] = date("Y-m-d h:i:sa");
		 	$this->db->where('driver_id', $driver_id);
		 	$this->db->update('tbl_preferred_shift', $preferred_shift);

		 }
	  /*=======================End For preferred Shift============================*/
	           $this->db->select('all_day,shift_for_all_day,mon,tue,wed,thu,fri,sat,sun');
               $this->db->where('driver_id', $driver_id);
			   $preferred_shift = $this->db->get('tbl_preferred_shift')->row_array();
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
			   $driver_details['preferred_shift']=$preferred_shift;
	           
                 echo json_encode(array("status"=>"ok","msg"=>"Data updated successfully.","response"=>$driver_details));die;	
		}else
		{
			 echo json_encode(array("status"=>"error","msg"=>"Some error occured","response"=>array()));die;
		}
	
      /*==================End Add Driver Address Api's==================*/
    }






/*==================Upload Driver Documents Api's==================*/
	public function driver_document()
	{
		$params =  $this->input->post();
		$input_array = array("action","driver_id","file","type");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		}
          /*==============For required Filed===============*/
          $requiredarray =array("driver_id","type");
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
		 unset($params['action']);
		 $validationarray = array(
			 "driver_id" => array(
			 "filtervalidate"=>"required|trim","key_name"=>"driver id"),
			 "type" => array(
			 "filtervalidate"=>"required","key_name"=>"type"),
			 );
		 /*===================From Validation===================*/
		 foreach($params as $key=>$val)
		 { 
		 	$mejardata=$this->formvalidation_model->validationdata($key,$validationarray,$params);
			 if($mejardata!="")
			 {
			  $datavalid=json_decode($mejardata); 
			  echo json_encode(array("status"=>"error","msg"=>$datavalid->message));die;
			 }
		 }
		 $this->db->where('id', $params['driver_id']);
         $check_driver = $this->db->get('driver_tbl')->row_array();
         if(empty($check_driver))
         {
           echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
         }
		 /*===================End From Validation===================*/
		 
		 if(empty($_FILES['file']['name']))
		 {
		 	echo json_encode(array("status"=>"error","msg"=>"File field is required"));die;
		 }
		$documentfile = "";
		
         $filename = $_FILES['file']['name']; 
         $tempfile = $_FILES['file']['tmp_name'];
         $ext = pathinfo($filename, PATHINFO_EXTENSION);

         $file = do_single_upload($filename, $tempfile, FCPATH . '/assets/driver_documents/');
	        $documentfile='/assets/driver_documents/thumb/'.$file;
	        if($ext!="mp4"){
		        create_square_image(FCPATH.'/assets/driver_documents/'.$file,FCPATH.'/assets/driver_documents/thumb/'.$file,200);
		    }
	
		 $this->db->where('driver_id', $params['driver_id']);
		 $check_driver_documents = $this->db->get('driver_document')->row_array();

		 $column = $this->getdocumentcolumn($params['type']);
		 
         if(empty($check_driver_documents))
         {
           $statusfile =array($column=>"Pending");
           $savedata = array("driver_id"=>$params['driver_id'],$column=>$documentfile,"status"=>json_encode($statusfile));
				$savedata['added_date'] = date("Y-m-d h:i:sa");
				//print_r($savedata);die;
	         $result = $this->db->insert('driver_document', $savedata);
	         if(!empty($result))
                 {
                    $data['status']="ok";
                    $data['msg']="Document uploaded sucessfully";
                    if($check_driver['flag_screen']!=4 && $check_driver['flag_screen']==3){
                    	$flag_array['flag_screen'] =4;
                    	$this->db->where('id', $params['driver_id']);
	     	            $this->db->update('driver_tbl', $flag_array);
                    }

                 }else
                 {
                     $data['status']="error";
                     $data['msg']="Some error occured.";

                 }

         }else
         {
         	$file_status =array($column=>"Pending");
         	foreach($file_status as $key=>$value){
         		$file_type =$key;
         		$file_status_val =$value;
         	}

         	//print_r($check_driver_documents['status']);die;
         	if(!empty($check_driver_documents['status'])){
         		$statusfile = json_decode(json_encode(json_decode($check_driver_documents['status'])),"true");
         		$i=0;
         		$pre_status_key = array();
         		foreach($statusfile as $key=>$value){
         			$pre_status_key[] =$key;
                  if($key==$file_type){
                  	$statusfile[$key] =$file_status_val;
                  }
                  $i++;
         		}

         		if(!in_array($file_type,$pre_status_key)){
                    $statusfile[$column] ="Pending";
               }
              
         	}else{
         	 $statusfile =array($column=>"Pending");	
         	}
         	

         	$this->db->where('driver_id', $params['driver_id']);
         	$savedata = array($column=>$documentfile,"status"=>json_encode($statusfile));
				  $savedata['updated_date'] = date("Y-m-d h:i:sa");
	        $result = $this->db->update('driver_document', $savedata);
	        

		echo json_encode($data);
	 }
	}
/*==================End Upload Driver Documents Api's==================*/





/*=========================Start Login===============================*/

	public function driver_login()
	{
		$json = file_get_contents('php://input');
          if(!empty($json))
          {
             $params =  json_decode($json, true);
          }else
          {
             $params = $this->input->post();
          }
         

          $input_array = array("action","email","password");
          foreach($params as $key=> $value)
          {
						if (!in_array($key, $input_array))
						{
						   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
						}
		 		  }
			 unset($params['action']);
			 /*==============For required Filed===============*/
	          $requiredarray =array("email","password");
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
	       $validationarray = array(
				 "email" => array(
				 /*"filtervalidate"=>"required|valid_email","key_name"=>"Email Address"),*/
				 "filtervalidate"=>"required|trim","key_name"=>"Driver ID"),
				 "password" => array(
				 "filtervalidate"=>"required|trim","key_name"=>"Password"),
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
			 $this->db->select('id, driver_name,username, email_address,mobile,referral_code,vehicle_type,driver_city,city_lat,city_long,flag_screen');
			   $this->db->group_start();
			   $this->db->where('email_address', $params['email']);
			   $this->db->or_where('username', $params['email']);
			   $this->db->group_end();
	         $checkemail = $this->db->get('driver_tbl')->row_array();
	         if(empty($checkemail))
	         {
	           echo json_encode(array("status"=>"error","msg"=>"Driver Id does not exits"));die;
	         }
	         $this->db->group_start();
			     $this->db->where('email_address', $params['email']);
			     $this->db->or_where('username', $params['email']);
			     $this->db->group_end();
	         $this->db->where('password', $params['password']);
	         $checkpassword = $this->db->get('driver_tbl')->row_array();
	         if(empty($checkpassword))
	         {
	           echo json_encode(array("status"=>"error","msg"=>"Password does not exits"));die;
	         } 
	         $token = $this->gettoken();

           /*===================check Approved document==================*/
           	$this->db->where('driver_id', $checkemail['id']);
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
                $checkemail['flag_screen']= $checkemail['flag_screen'];
               }else{
                 $checkemail['flag_screen'] = "5";
               }
						  	
						  	
						  }

	         	}
	         	
		         
		       }


          /*===================end check Approved document==================*/

	         $this->db->where('id',$checkemail['id']);
	         $this->db->update('driver_tbl',array('token'=>$token));
	         $checkemail['token']=$token;
	         $checkemail['driver_id']=$checkemail['id'];
	         unset($checkemail['id']);
             $driver_details = $checkemail;
             echo json_encode(array("status"=>"ok","msg"=>"login successful","response"=>$driver_details));die;
	}

/*=========================End Login===============================*/


/*=========================Start Logout===============================*/
public function driver_logout(){

	$json = file_get_contents('php://input');
	  if(!empty($json))
	  {
	     $params =  json_decode($json, true);
	  }else
	  {
	     $params = $this->input->post();
	  }

	  $input_array = array("action","driver_id","access_token");
	  foreach($params as $key=> $value)
    {
			if (!in_array($key, $input_array))
			{
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			}
		}

		unset($params['action']);
    /*=========================For required Filed=====================*/
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
    //print_r($params);die;
    $this->db->where('id',$params['driver_id']);
    $query=  $this->db->update('driver_tbl',array("login_status"=>"0"));
    if(!empty($query)){
        echo json_encode(array("status"=>"ok","msg"=>"Logout successfully"));die;
    }else{
    		echo json_encode(array("status"=>"error","msg"=>"Some error occured"));die;
    }


}



/*=========================End Logout===============================*/


/*=====================Start Driver Details Api's======================*/
public function get_driver_details()
{
	$json = file_get_contents('php://input');
	  if(!empty($json))
	  {
	     $params =  json_decode($json, true);
	  }else
	  {
	     $params = $this->input->post();
	  }

	  $input_array = array("action","driver_id");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		}
		 	unset($params['action']);
			/*==============For required Filed===============*/
	          $requiredarray =array("driver_id");
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
	         $this->db->where('id', $params['driver_id']);
	         $check_driver = $this->db->get('driver_tbl')->row_array();
	         if(!empty($check_driver['profile_pic'])){
	         	 $check_driver['profile_pic']= base_url($check_driver['profile_pic']);
	         }
	         if(empty($check_driver))
	         {
	           echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
	         }
	         $this->db->where('driver_id', $params['driver_id']);
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
                $check_driver['flag_screen']= $check_driver['flag_screen'];
               }else{
                 $check_driver['flag_screen'] = "5";
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
	         	$check_driver['driver_document'] = $driver_document;
	         }else{
	         	$check_driver['driver_document'] = "";
	         }
	         $check_driver['driver_id']=$check_driver['id'];

	         /*==============Driver Preferred Shift===============*/
	         $this->db->select('all_day,shift_for_all_day,mon,tue,wed,thu,fri,sat,sun');
	           $this->db->where('driver_id', $check_driver['id']);
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
			   

			   $check_driver['preferred_shift']=$preferred_shift;
			   $check_driver['edit_profile_status'] = json_decode($check_driver['edit_profile_status']);

	         /*==============End Driver Preferred Shift=============*/
	         unset($check_driver['id']);
             $driver_details = $check_driver;
             echo json_encode(array("status"=>"ok","msg"=>"","driver_details"=>$driver_details));die;


}

/*=====================End Driver Details Api's======================*/






/*====================Car Type Apis======================*/
public function getcartype()
{
	$json = file_get_contents('php://input');
      if(!empty($json))
      {
         $params =  json_decode($json, true);
      }else
      {
         $params = $this->input->post();
      }

      $input_array = array("action");
      $cartype_array = array("status"=>'1');
      $car_type = $this->database_model->getdata('tbl_car_type','L',$cartype_array);
      
      if(!empty($car_type)){
      	echo json_encode(array("status"=>"ok","vehicle_type"=>$car_type));die;
      }else{
      	echo json_encode(array("status"=>"error","vehicle_type"=>array()));die;
      }
          

}

/*====================End Car Type Apis======================*/





/*===================Forgot Password Apis=======================*/
function forgotpassword(){
	  $json = file_get_contents('php://input');
	  if(!empty($json))
	  {
	     $params =  json_decode($json, true);
	  }else
	  {
	     $params = $this->input->post();
	  }

	  $input_array = array("action","mobile");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		}
		 unset($params['action']);


		 /*==============For required Filed===============*/
	          $requiredarray =array("mobile");
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

		 $wherearray = array("mobile"=>$params['mobile']);
		 $checkmobile = $this->database_model->getdata('driver_tbl','S',$wherearray);
		 if(!empty($checkmobile)){
		 	$six_digit_otp = rand(100000, 999999);
		 	$this->db->where('id',$checkmobile->id);
	        $this->db->update('driver_tbl',array('otp_number'=>$six_digit_otp));
	        echo json_encode(array("status"=>"ok","msg"=>"Otp is sent to your mobile number."));die;

		 }else{

		 	echo json_encode(array("status"=>"error","msg"=>"Mobile number does not exist."));die;

		 }

}

/*===================End Forgot Password Apis===================*/




/*===================Verified Otp===================*/

function verified_otp()
{
	$json = file_get_contents('php://input');
	  if(!empty($json))
	  {
	     $params =  json_decode($json, true);
	  }else
	  {
	     $params = $this->input->post();
	  }
	  $input_array = array("action","mobile","otp");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		}
		 unset($params['action']);
		 /*==============For required Filed===============*/
	      $requiredarray =array("mobile","otp");
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
	      $wherearray = array("mobile"=>$params['mobile']);
		  $checkmobile = $this->database_model->getdata('driver_tbl','S',$wherearray);
		  if(empty($checkmobile)){
	        echo json_encode(array("status"=>"error","msg"=>"Mobile number does not exist."));die;
		  }
		  $wherearray = array("mobile"=>$params['mobile'],"otp_number"=>$params['otp']);
		  $checkotp = $this->database_model->getdata('driver_tbl','S',$wherearray);
		  if(!empty($checkotp)){
		  	    $driver_details = array("driver_id"=>$checkotp->id);
		  		echo json_encode(array("status"=>"ok","msg"=>"Verified Completed","response"=>$driver_details));die;
		  }else{
		  	echo json_encode(array("status"=>"error","msg"=>"Your otp is wrong"));die;
		  }

}

/*===================End Verified Otp===================*/




/*==================Change password=====================*/

function changepassword()
{
	$json = file_get_contents('php://input');
	  if(!empty($json))
	  {
	     $params =  json_decode($json, true);
	  }else
	  {
	     $params = $this->input->post();
	  }

	  $input_array = array("action","driver_id","password","confirm_password");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		}
		 unset($params['action']);
		 /*==============For required Filed===============*/
          $requiredarray =array("driver_id","password","confirm_password");
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
	      if($params['password']!=$params['confirm_password']){
	      	echo json_encode(array("status"=>"error","msg"=>"Password and confirm password does not match"));die;
	      }
		   $this->db->where('id',$params['driver_id']);
	     $result = $this->db->update('driver_tbl',array('password'=>$params['password']));
	     if(!empty($result)){
	     	echo json_encode(array("status"=>"ok","msg"=>"Password has been changed successfully!"));die;
	     }else{
	     	echo json_encode(array("status"=>"error","msg"=>"Some error occured"));die;
	     }


}


/*==================End Change password=====================*/





/*====================Generate Token=======================*/
function getRandomToken($length = 16)
{
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pieces = [];
    $max = mb_strlen($stringSpace, '8bit') - 1;
    for ($i = 0; $i < $length; ++ $i) {
        $pieces[] = $stringSpace[rand(0, $max)];
    }
    return implode('', $pieces);
}

function gettoken()
{
	$token = $this->getRandomToken(50);
	 $this->db->where('token', $token);
	 $checktoken = $this->db->get('driver_tbl')->row_array();
	 if(!empty($checktoken)){
	 	return $this->gettoken($this->getRandomToken(50));
	 }else{
	 	return $token;
	 }

}


/*====================End Generate Token=======================*/


/*====================Generate User Name Unique=========================*/
    
//Generate a unique username using Database
function generate_unique_username($string_name="auto name", $rand_no = 2000){
	while(true){
		//echo strlen($string_name);
		$username_parts = array_filter(explode(" ", strtolower(substr($string_name,0,2)))); //explode and lowercase name
		$username_parts = array_slice($username_parts, 0, 1); //return only first two arry part
	
		$part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
		$part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
		$part3 = ($rand_no)?rand(0, $rand_no):"";
		
		$username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
		
		$username_exist_in_db = $this->username_exist_in_database($username); //check username in database
		if(!$username_exist_in_db){
			return $username;
		}
	}
}


function username_exist_in_database($username){
        $username = $username;
        $this->db->select('count(username) as count');
	    $this->db->where('username',$username);
	    $result = $this->db->get('driver_tbl')->row();
	    if(!empty($result)){
			
			return $result->count;
		}
	   
		
}

/*======================End Generate User Name Unique=====================*/

function update_driver_profile()
{
	$json = file_get_contents('php://input');
	  if(!empty($json))
	  {
	     $params =  json_decode($json, true);
	  }else
	  {
	     $params = $this->input->post();
	  }

	  $input_array = array("action","driver_id","access_token","driver_name","mobile","mobile_type","driver_city","city_lat","city_long","vehicle_type","profile_pic");
		
		foreach($params as $key=> $value)
		{
			if (!in_array($key, $input_array))
			  {
			   echo json_encode(array("status"=>"error","msg"=>$key." key does not exist!"));die;
			  }
		}
		 unset($params['action']);
		 /*==============For required Filed===============*/
	      $requiredarray =array("driver_id","access_token","driver_name","mobile","mobile_type","driver_city","city_lat","city_long","vehicle_type");
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

	   /*==============End For required Filed===============*/
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

      /*==================Check Mobile Number====================*/
        $this->db->where('id!=',$params['driver_id']);
        $this->db->where('mobile',$params['mobile']);
        $check_mobile = $this->db->get('driver_tbl')->row_array();
        if(!empty($check_mobile)){
        	echo json_encode(array("status"=>"error","msg"=>"Mobile number already exits"));die;
        }

      /*==================Check Mobile Number====================*/

      $edit_profile_status = json_decode($check_driver['edit_profile_status'],true);
      if(empty($edit_profile_status)){
      	$edit_profile_status = array("driver_name"=>"Pending","mobile"=>"Pending","mobile_type"=>"Pending","address"=>"Pending","vehicle_type"=>"Pending");
      }
      //print_r($edit_profile_status);die;
      if($params['driver_name']!=$check_driver['driver_name']){
      	$edit_profile_status['driver_name'] = "Pending";
      }else if(empty($check_driver['driver_name'])){
      	$edit_profile_status['driver_name'] = "Pending";
      }

      if($params['mobile']!=$check_driver['mobile']){
      	$edit_profile_status['mobile'] = "Pending";
      }else if(empty($check_driver['mobile'])){
      	$edit_profile_status['mobile'] = "Pending";
      }

      if($params['mobile_type']!=$check_driver['mobile_type']){
      	$edit_profile_status['mobile_type'] = "Pending";
      }else if(empty($check_driver['mobile_type'])){
      	$edit_profile_status['mobile_type'] = "Pending";
      }

      if($params['driver_city']!=$check_driver['driver_city']){
      	$edit_profile_status['address'] = "Pending";
      }else if(empty($check_driver['driver_city'])){
      	$edit_profile_status['address'] = "Pending";
      }

      if($params['vehicle_type']!=$check_driver['vehicle_type']){
      	$edit_profile_status['vehicle_type'] = "Pending";
      }else if(empty($check_driver['vehicle_type'])){
      	$edit_profile_status['vehicle_type'] = "Pending";
      }
      $params['edit_profile_status'] = json_encode($edit_profile_status);

      $driver_id =$params['driver_id'];
      unset($params['driver_id']);
      unset($params['access_token']);
      $params['profile_pic'] = $check_driver['profile_pic'];
      if(!empty($_FILES['profile_pic']['name']))
			 {
			 	$filename = $_FILES['profile_pic']['name']; 
         $tempfile = $_FILES['profile_pic']['tmp_name'];
         $ext = pathinfo($filename, PATHINFO_EXTENSION);

         $file = do_single_upload($filename, $tempfile, FCPATH . '/assets/driver_profile/');
	        $params['profile_pic']='/assets/driver_profile/thumb/'.$file;
		        create_square_image(FCPATH.'/assets/driver_profile/'.$file,FCPATH.'/assets/driver_profile/thumb/'.$file,200);
		    
			 }
      $this->db->where('id',$driver_id);
      $query = $this->db->update('driver_tbl', $params);
      if(!empty($query)){
      	echo json_encode(array("status"=>"ok","msg"=>"Records updated successfully"));
      }else{
      	echo json_encode(array("status"=>"error","msg"=>"Super error occurred"));
      }
}


/*===================Vehicle Information===========================*/
	public function save_vehicle_information()
	{
		$json = file_get_contents('php://input');
    if(!empty($json))
    {
       $params =  json_decode($json, true);
    }else
    {
       $params = $this->input->post();
    }
    $input_array = array("action","driver_id","registration_num","vehicle_company","vehicle_model","vehicle_color");
    $requiredarray =array("driver_id","registration_num","vehicle_company","vehicle_model","vehicle_color");
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
    /*============================End For required Filed====================*/
	   /*=========================Check driver===========================*/
       $this->db->where('id',$params['driver_id']);
       $check_driver = $this->db->get('driver_tbl')->row_array();
           if(empty($check_driver))
           {
             echo json_encode(array("status"=>"error","msg"=>"Driver does not exits"));die;
           }
    /*=====================End Check driver======================*/
    $this->db->where('driver_id',$params['driver_id']);
    $check_document = $this->db->get('driver_document')->row_array();
    if(!empty($check_document)){
    	$driver_id = $params['driver_id'];
    	   unset($params['driver_id']);
         $this->db->where('driver_id',$driver_id);
         $result = $this->db->update('driver_document', $params);
    }else{
    		$result = $this->db->insert('driver_document', $params);
    }
    if(!empty($result)){
    	echo json_encode(array("status"=>"ok","msg"=>"Records save successfully!"));
    }else{
    	echo json_encode(array("status"=>"error","msg"=>"Some error occured!"));
    }
    

	}
/*===================End Vehicle Information=======================*/





/*=================Start Get Document Column=========================*/
	public function getdocumentcolumn($type)
	{
		switch ($type) {
	    case "DL_F":
	        return "driver_license_f";
	        break;
	    case "DL_B":
	        return "driver_license_b";
	        break;    
	    case "DPCO_F":
	        return "driver_pco";
	        break;
	    case "DPCO_B":
	        return "driver_pco_b";
	        break;    
	    case "NIN":
	        return "N_I";
	        break;
	    case "LB":
	        return "logbook";
	        break; 
	    case "RA":
	        return "rental_agreement";
	        break; 
	    case "VPCO":
	        return "vehicle_pco";
	        break; 
	    case "D_PHOTO":
	        return "driver_photo";
	        break; 
	    case "M_O_T":
	        return "M_O_T";
	        break;
	    case "INSURANCE":
	        return "insurance";
	        break;                            
	    default:
        return "unknown";
        break;
       }

	}
/*=================End Get Document Column=========================*/




}
