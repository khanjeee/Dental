<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->model('Sections_Model','sections');
		$this->load->model('Departments_Model','departments');
		$this->load->model('assign_Course_Model','assign');
		$this->load->model('Courses_Model','courses');
		$this->load->helper('common_helper');
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			ci_redirect('');
		}
		
	}




	function index()
	{  $tmp=strtotime("2013-10-27 09:32:21");
		echo $tmp.'<br>';
		$d = new DateTime( date("Y-m-d H:i:s",$tmp) );
		echo $d->format("l");
		
	}



	function view()
	{		
		
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('schedules');
			$crud->set_subject('Schedule');
			$crud->required_fields('start_on','room','day','duration','time');
			
			$crud->columns('assign_course_id','start_on','end_on','time','duration','room','day');
			
			$crud->set_rules('end_on','End Time','callback_check_dates');
			/*Generating dropdwons for year section and course status*/
			
			$crud->callback_add_field('assign_course_id',array($this->assign,'get_assigned_course_dropdown'));
			$crud->callback_edit_field('assign_course_id',array($this->assign,'get_assigned_course_dropdown'));
			
			$crud->field_type('day','dropdown',
					array('Monday' => 'Monday',
							'Tuesday' => 'Tuesday',
							'Wednesday' => 'Wednesday',
							'Thursday' => 'Thursday',
							'Friday' => 'Friday',
							'Saturday' => 'Saturday',
							'Sunday' => 'Sunday',
							  ));
			
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_before_update(array($this,'call_before_update'));
				
			/*callback for table view */
			$crud->callback_column('assign_course_id',array($this->assign,'get_assigned_course_by_id'));
		
			/*used to display fields when adding items*/
			$crud->fields('assign_course_id','start_on','end_on','time','duration','room','day','created_by','created_on','modified_on');
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			$crud->change_field_type('created_by','invisible');
			$crud->change_field_type('created_on','invisible');
			$crud->change_field_type('modified_on','invisible');
		
			//	$crud->change_field_type('day','invisible');
			//$crud->change_field_type('duration','invisible');
			
			$crud->display_as('assign_course_id','Course');
			
			//$this->pr($crud); 
			//die;
			$output = $crud->render();
			//$this->pr($output);

            $content = $this->load->view('admin/schedules.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		
		$user = $this->ion_auth->user()->row();
		$post_array['created_by']=$user->id;
		$post_array['created_on']= date("Y-m-d H:i:s");
		
		
		/*
		$start=str_replace('/', '-', $post_array['start_on']);
		$start_arr=explode(' ',$start);
		
		//calculating day
		$date_time_stamp=strtotime($start);
		$date_object = new DateTime( date("Y-m-d H:i:s",$date_time_stamp) );
		$post_array['day']= $date_object->format("l"); // Monday
		
		
		$end= $start_arr[0].' '.$post_array['end_on'].':00'; //complete with date appended from start date
		$start  = new DateTime($start);
		$end    = new DateTime($end);
		$diff = $start->diff($end);
		//print_r($diff); die;
		$post_array['duration']=$diff->h.':'.$diff->i; //combination hour and minute

		*/

		
		return $post_array;
		
	
	}
	function call_before_update($post_array,$schedule_id){
		/*
		$query = $this->db->get_where('schedules',array('id'=>$schedule_id ));
		$result=$query->result();
		 
		if(!empty($result)){
	// calculating day only if startdate date is changed	
		if($result[0]->start_on !=$post_array['start_on']){
//
			$date_time_stamp=strtotime($post_array['start_on']);
			$date_object = new DateTime( date("Y-m-d H:i:s",$date_time_stamp) );
			$post_array['day']= $date_object->format("l"); // Monday
			
		}
		// calculating duration only if end date is changed 
		if($result[0]->end_on!=$post_array['end_on']){ 
			
			$start=str_replace('/', '-', $post_array['start_on']);
			$start_arr=explode(' ',$start);
			$end= $start_arr[0].' '.$post_array['end_on'].':00'; //complete with date appended from start date
			$start  = new DateTime($start);
			$end    = new DateTime($end);
			$diff = $start->diff($end);
			//print_r($diff); die;
			$post_array['duration']=$diff->h.':'.$diff->i; //combination hour and minute
			
		}
			
		}
		*/
		$post_array['modified_on']= date("Y-m-d H:i:s");
		return $post_array;
	
	
	}
	
	
	public function check_dates($end_time)
	{
		$start_on=$_POST['start_on'];
		$end_on=$_POST['end_on'];
		/* $start_date_arr=explode(' ', $start_date);
		$start_time=$start_date_arr[1];
		$end_time=(!empty($end_time)) ? $end_time.':00' : null; */
		
		if(empty($end_on)){
			$this->form_validation->set_message('check_dates', "End time is required");
			return FALSE;
		}
		
	
		if ($start_on < $end_on)
		{
			//$this->form_validation->set_message('check_dates', "start  {$start_time} end {$end_time}");
			return true;
		}
		else
		{
			$this->form_validation->set_message('check_dates', "Start time should  be less than End time");
			return FALSE;
		}
	}

function format_end_on($value){
	
	$value_arr=explode(':', $value);
	unset($value_arr[2]);
	$value=join(':',$value_arr);
	return '<input id="field-end_on" type="text"    class="hasDatepicker"   value="08:00:00" name="end_on" style="width: 100px;" >';
	
}
	
	

	




}