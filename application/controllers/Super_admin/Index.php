<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	 public function __construct()
    {
      parent::__construct();
              $this->load->helper(array("file", "url","document_upload_helper"));
              $this->load->library(array("session", "encryption","form_validation"));
              $this->load->model(array("formvalidation_model","Super_admin_model"));
              $config = Array(
                  'protocol' => 'sendmail',
                  'mailtype' => 'html',
                  'charset' => 'utf-8',
                  'wordwrap' => TRUE
              );
              $this->load->library('email', $config);
              $this->load->database();
              /*$this->load>helper("document_upload_helper");*/
    }

	public function index()
	{
		$this->load->view('super_admin/login');
	}
    public function login()
    {
          $email=$this->input->post('EMAIL');
          $password=$this->input->post('PASSWORD');
          $response=$this->Super_admin_model->login($email,$password);
          if(($response['USERNAME']!=null || $response['EMAIL']!=null) && $response['PASSWORD']!=null)
          {
              $data['status']="ok";
              $newdata = array(
                       'admin_id'  => $response['ID'],
                       'email'     => $response['EMAIL'],
                       'login_status' => 'Login'
                    );
                   
                $this->session->set_userdata($newdata);


          }else
          {
             $data['status']="error";
             $data['msg']="Invalid Username or Password!";
          }
           
          echo json_encode($data);

    }
    public function logout(){        
            $this->session->sess_destroy();
            header('location:'.base_url('super_admin'));
    }
    public function profile_setting(){ 
            $data['title'] = "Profile Setting";
            $data['button'] = "Update";
            $admin_id = $this->session->userdata('admin_id');
            $this->db->where('id', $admin_id);
            $data['admin_details'] = $this->db->get('tbl_admin')->row_array(); 

            $this->load->view('super_admin/profile-setting',$data);
    }
    public function update_profile_setting(){ 
            $data = $this->input->post();
            if(!empty($data)){
              $this->db->where('id!=', $data['id']);
              $this->db->where('USERNAME', $data['username']);
              $checkusername = $this->db->get('tbl_admin')->row_array();
              if(!empty($checkusername)) {
                echo json_encode(array("status"=>"error","msg"=>"Username already exists."));die;
              }

              $this->db->where('id!=', $data['id']);
              $this->db->where('EMAIL', $data['email']);
              $checkemail = $this->db->get('tbl_admin')->row_array();
              if(!empty($checkemail)) {
                echo json_encode(array("status"=>"error","msg"=>"Email already exists."));die;
              }

              $updatedata = array("NAME"=>$data['name'],"USERNAME"=>$data['username'],"EMAIL"=>$data['email'],"PASSWORD"=>$data['password']);
              $this->db->where('id=', $data['id']);
              $result = $this->db->update('tbl_admin', $updatedata);
              if(!empty($result)){
                echo json_encode(array("status"=>"ok","msg"=>"Records updated successfully."));
              }else{
                echo json_encode(array("status"=>"ok","msg"=>"Some error occured."));
              }
              
            }else{
              echo json_encode(array("status"=>"error","msg"=>"Some error occured."));
            }
    }
}
?>
