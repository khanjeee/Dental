<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teachers extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
                $this->load->helper('common_helper');
                $this->load->helper('language');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->library('phpbb_bridge');
                $this->load->model('Users_Model','users');
		$this->load->model('Departments_Model','departments');
		$this->load->model('Years_Model','years');
		$this->load->model('Teachers_Model','teachers');
		$this->load->model('Groups_Model','groups');
		
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			ci_redirect('/');
		}
		
	}




	function index()
	{
            echo $this->ion_auth->logged_in(); die;
		//$add_forum_user=$this->phpbb_bridge->user_add('shoaibkhan105@live.com','shoaib','khanjee12');
		//$this->pr($add_forum_user);
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}



	function view()
	{		
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('user_teacher');
			$crud->set_subject('Teachers');
			$crud->required_fields('teacher_id','name','phone','qualification','institution','skills','designation');
			
			$crud->columns('teacher_id','name','email','phone','department_id','qualification','institution','skills','designation');
			
			/*used to display fields when adding items*/
			$crud->fields('user_id','name','teacher_id','forum_id','email','password','department_id','phone','qualification','institution','skills','designation');
			$crud->edit_fields('user_id','name','teacher_id','forum_id','password','department_id','phone','qualification','institution','skills','designation');
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			$crud->change_field_type('user_id','hidden');
			$crud->change_field_type('forum_id','invisible');
                        $crud->change_field_type('password','password');
			
                        $crud->set_rules('email', 'Email', 'callback_check_duplicate|valid_email|required');
			$crud->set_rules('password', 'Password', 'required|min_length[8]');
                        
			$crud->callback_add_field('department_id',array($this->departments,'get_departments_dropdown'));
			$crud->callback_edit_field('department_id',array($this->departments,'get_departments_dropdown'));
                        $crud->callback_edit_field('password',array($this,'ion_auth_password'));
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			//$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields*/
			$crud->display_as('teacher_id','Teacher Id');
			$crud->display_as('name','Name');
			$crud->display_as('email','Email');
			$crud->display_as('phone','Phone#');
			$crud->display_as('qualification','Qualification');
			$crud->display_as('skill','Skills');
			$crud->display_as('designation','Designation');
			$crud->display_as('institution','Institution');
			$crud->display_as('department_id','Department');
			
			
			
			//creating a user before creation of teacher
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_before_delete(array($this,'call_before_delete'));
                        $crud->callback_before_update(array($this,'call_before_update'));
			
			
			/*callback for table view */
			$crud->callback_column('department_id',array($this->departments,'get_department_by_id'));
			
			$output = $crud->render();
			//$this->pr($output);

            $content = $this->load->view('admin/teachers.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));



		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
        
        function ion_auth_password($value, $primary_key){
		 
		$ion_auth_uid=$this->users->get_ion_auth_user_id($primary_key,'user_teacher');
		$user=$this->ion_auth->user_by_id($ion_auth_uid); //pass user id get user object
		return "<input type='password' maxlength='50' value='{$user->password}' name='password' >";
	
	}
        function call_before_update($post_array,$student_id){
		
		$user=$this->ion_auth->user_by_id($post_array['user_id']); //ion auh user 
		$id=$user->id;
		
                
                
		$password=$post_array['password'];
		$first_name=$post_array['name'];
		$last_name=$post_array['name'];
		
              if($password != $user->password){
			$data = array('first_name'=>$first_name,'last_name'=>$last_name,'password' =>$password );
			$this->ion_auth->update(strval($id), $data);
	
		}
		else {
			$data = array('first_name'=>$first_name,'last_name'=>$last_name);
			$this->ion_auth->update(strval($id), $data);
		}
		 
		 
		unset($post_array['password']);
		return $post_array;
	}
	

	function call_before_insert($post_array){
		
		
		
		$username = $post_array['email'];
		$password = 'password';
		$email = $post_array['email'];
		$additional_data = array(
				'first_name' => $post_array['name'],
				'phone' => $post_array['phone']
		);
		
		
		/* * using transactions   * * */
		
		$this->db->trans_begin();
		
		//inserts user to forum_users table in PhpBB
		$forum_user_id=$this->phpbb_bridge->user_add($email,$username,$password);
		$group = array('3');
		
		$user_id=$this->ion_auth->register($username, $password, $email, $additional_data, $group);
		
		if( (!empty($user_id) && (!empty($forum_user_id)) ) ){
			$post_array['user_id']=$user_id;
			$post_array['forum_id']=$forum_user_id;
		
			//commit if both transactions above were successfull
			$this->db->trans_commit();
		}
		
		else{
			/*ROlling back transaction*/
			$this->db->trans_rollback();
				
		}
	
		unset($post_array['password']);
		return $post_array;
	
	}
	
	
	function call_before_delete($user_teacher_id){
		
		//getting forums users id 
		$user_teacher_row=$this->teachers->get_teacher_row($user_teacher_id);
		$forum_id=$user_teacher_row->forum_id;
		$user_id=$user_teacher_row->user_id;
		
		if(	(!empty($forum_id)) && (!empty($user_id))	){  //default value of forum id in db is 0
			
			/*deletes the user from phpbb forum*/
			$this->phpbb_bridge->user_delete($forum_id);
			/*deletes user from users table Ion_auth*/
			$this->ion_auth->delete_user($user_id);
		}
		

		
	}
        
        function check_duplicate($value,$row)
	{
		
		 
		$row_id=$this->uri->segment(5);
		//checks for duplicate entries in db return true if exist else false
		if($this->users->check_duplicate_teacher($value,$row_id)){
			//dont validate on edit
			$this->form_validation->set_message('check_duplicate',"Email {$value} already exist");
			return false;
		}
		else{
			return true;
		}
	
	
			
	}
	
	function get_teachers_by_course_id($value='') {
		//header('Content-Type: application/x-json; charset=utf-8');
		echo $this->teachers->get_teachers_by_course_id($value);
		
		
	
	}




}