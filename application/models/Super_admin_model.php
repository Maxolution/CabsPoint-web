
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Super_admin_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
    }
	
	  public function login($email,$password)

    { 

       

    	$result=$this->db->query("SELECT * FROM tbl_admin WHERE (USERNAME='".$email."' OR EMAIL='".$email."') AND PASSWORD='".$password."'")->row_array();

    	return $result;

    }
}
