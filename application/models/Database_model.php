
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_model extends CI_Model {

    public function __construct()
    {
         parent::__construct();
         $this->load->database();
    }
	
	public function getdata($tbl_name=false,$get_type=false,$where=false,$where_or=false)

    {
            if(!empty($where)){
                foreach($where as $key=>$val){
                    $this->db->where ($key,$val);
                }
            }
            if(!empty($where_or)){
                $this->db->group_start();
                $i=0;
                foreach($where_or as $key=>$val){
                    
                    if($i==1){
                     $this->db->where($key,$val);   
                     }else{
                     $this->db->or_where($key,$val);   
                     }
                    $i++;
                }
                $this->db->group_end();
            }
            if($get_type=="S"){
                 $query = $this->db->get($tbl_name);
                 $result = $query->row();

            }else if($get_type=="L"){
                $result = $this->db->get($tbl_name)->result();
            }
          
    	
    	return $result;

    }

    public function insertupdate($table=false,$data=false,$where=false){
        $result = $this->db->insert($table, $data);
        return $result;

    }
}
