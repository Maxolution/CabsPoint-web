<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model {

  function getUserDetails(){
 
    $response = array();
 
    // Select record
    $this->db->select('name,phone,email');
    $this->db->where('request_from!=','admin');
    $q = $this->db->get('guests');
    $response = $q->result_array();
 
    return $response;
  }

}