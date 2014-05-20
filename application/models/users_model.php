<?php

class Users_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('ion_auth');
    }
    
    function get_users_dropdown($value)
    {   
    	$value=(!empty($value))? $value : 1;
    	$arrUsers=array();
    	
    	$this->db->select('id,first_name');
     	$query = $this->db->get('users');
       
		foreach ($query->result() as $data ){
			
			$arrUsers[$data->id]=$data->first_name;
		}
		
		return form_dropdown('user_id', $arrUsers,$value);
    }
    
    //returns first_name of the uid passed
    function get_user_by_id($user_id)
    {
    	$query = $this->db->get_where('users', array('id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->first_name;
    	}
    }
    
    //returns first_name of the uid passed
    function get_ion_auth_user_id($user_id)
    {
    	$query = $this->db->get_where('user_student', array('id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->user_id;
    	}
    }
    
    //returns user id off the logged in user
    function get_user_id() {
    	return $this->ion_auth->user()->row()->id;
    
    }
    
    //checks for duplicate entries in db return 1 if exist else 0
    function check_duplicate($value,$row_id)
    {
    	$query_1 = $this->db->get_where('user_student',array('id' => $row_id));
    	$result_1=$query_1->result();
    	$user_id_1=$result_1[0]->user_id;
    	
    	$query_2 = $this->db->get_where('users',array('email' => $value));
    	$result_2=$query_2->result();
    	//echo"<pre>"; print_r($result[0]->user_id); echo"</pre>"; die;
    	
    	if(empty($result_2) || ($result_2[0]->id==$user_id_1)){ // if it exists in db return 1 else 0
    		return false;
    	}
    	else{
    		return true;
    	}
    }
    
    
    
		
}


