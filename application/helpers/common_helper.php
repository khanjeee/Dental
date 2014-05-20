<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{
    function Dropdown_years($var = '')
    {
    	$CI =& get_instance();
    	
    	$CI->load->helper('form');
    	$CI->load->model('Years_Model','years');
    	
    	return  form_dropdown('year_id', $CI->years->get_years_dropdown(''));
       
    }   
    
    
    function pr($data = '')
    {
    	echo '<pre>'; print_r($data); echo'</pre>';
    	 
    }
    
    
    function send_mail ($email,$password,$subject){
    	$CI =& get_instance();
    	$CI->load->helper('email');
    	
    	$data=array('email'=>$email,'password'=>$password);
    	$CI->email->initialize(array(	'mailtype' => 'html','validate' => TRUE));
    	
    	$mail_content = $CI->load->view('email/template_user.php',$data,TRUE);
    	$CI->email->from('admin@kmdc.edu.pk', 'KMDC|Admin');
    	$CI->email->to($email);
    	$CI->email->subject($subject);
    	$CI->email->message($mail_content);
    	$CI->email->send();
    }
    
}