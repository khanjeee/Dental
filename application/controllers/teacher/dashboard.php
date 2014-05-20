<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('ion_auth');
        $this->load->library('grocery_CRUD');
		$this->load->model('Teachers_Model','teachers');
        $this->load->model('Notification_Board_Model','notifications');
        $this->load->model('Student_Assestments_Model', 'student_assestments');
        $this->load->model('attendance_Model', 'attendance');
        $this->load->model('Schedules_Model','schedules');
        $this->load->model('Assign_Course_Model','assign_courses');
        $this->load->model('Course_Assignments_Model', 'course_assignments');

        if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
	}

	function index()
	{
	    $user = $this->ion_auth->user()->row();

        $teacher = $this->teachers->get_row_by_userid($user->id);
        $teacherInfo = $this->load->view('teacher/teacherinfo', array('teacher'=> $teacher), true);

        $content = $this->load->view('teacher/schedule', array(),true);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['teacher_id'] = $teacher->id;

        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['teacherInfo'] = $teacherInfo;

        $this->load->view('teacher/master_inner', $data);
		
	}


    function profile(){

        $user_id = $this->uri->segment(5);
        $user = $this->ion_auth->user()->row();
        $teacher = $this->teachers->get_row_by_userid($user->id);

        if($teacher->id != $user_id){
            ci_redirect('teacher/dashboard');
        }

        try{

            $crud = new grocery_CRUD();

            $crud->set_theme('flexigrid');
            $crud->set_table('user_teacher');
            $crud->set_subject('Update Profile');
            $crud->unset_add();
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_delete();
            $crud->unset_back_to_list();
            $crud->unset_list();

            $crud->required_fields('name','email','phone','qualification','institution','skills');
            $crud->columns('name','email','phone','qualification','institution','skills');

            /*used to display fields when adding items*/
            $crud->fields('user_id','name','forum_id','email','phone','qualification','institution','skills');

            /*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
            $crud->change_field_type('user_id','invisible');
            $crud->change_field_type('forum_id','invisible');

            //$crud->display_as('teacher_id','Teacher Id');
            $crud->display_as('name','Name');
            $crud->display_as('email','Email');
            $crud->display_as('phone','Phone#');
            $crud->display_as('qualification','Qualification');
            $crud->display_as('skill','Skills');
            $crud->display_as('designation','Designation');
            $crud->display_as('institution','Institution');

            $output = $crud->render();

            $content = $this->load->view('admin/teachers.php',$output,true);
            $teacherInfo = $this->load->view('teacher/teacherinfo', array('teacher'=> $teacher), true);

            $data = array();
            $header = array();
            $footer = array();
            $header['user'] = $user;
            $header['teacher_id'] = $teacher->id;

            $data['header'] = $header;
            $data['footer'] = $footer;
            $data['content'] = $content;
            $data['teacherInfo'] = $teacherInfo;

            $this->load->view('teacher/master_inner', $data);


        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());

        }

    }


    function get_schedule(){
        $start = date("Y-m-d 00:00:00",$_GET['start']);
        $end = date("Y-m-d 00:00:00",$_GET['end']);

        $timeStamp = strtotime($start);

        $user = $this->ion_auth->user()->row();
        $teacher = $this->teachers->get_row_by_userid($user->id);
        $result = $this->schedules->get_schedulesForTeacher($start,$end, $teacher->id);

        $returnArr = array();
        foreach($result  as $item){

            switch(strtolower($item['day'])){
                case 'sunday':{

                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+6, date("Y",$timeStamp));
                    break;
                }
                case 'monday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp), date("Y",$timeStamp));
                    break;
                }
                case 'tuesday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+1, date("Y",$timeStamp));
                    break;
                }
                case 'wednesday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+2, date("Y",$timeStamp));
                    break;
                }
                case 'thursday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+3, date("Y",$timeStamp));
                    break;
                }
                case 'friday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+4, date("Y",$timeStamp));
                    break;
                }
                case 'saturday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+5, date("Y",$timeStamp));
                    break;
                }
            }
            $startDateTime = date('Y-m-d H:i:s', strtotime(date('Y-m-d', $dayDate).' '. date('H:i:s', strtotime($item['time']))));
            $endDateTime = date('Y-m-d H:i:s', strtotime(date('Y-m-d', $dayDate)));

            $km = array(
                'id' => $item['id'],
                'title' => $item['code']."\n". $item['course_name'],
                'start' => $startDateTime,
                'end'   => $endDateTime,
                'allDay' => false
            );

            $returnArr[] = $km;
        }

        echo json_encode($returnArr);
    }

    function noticeboard(){

        $user = $this->ion_auth->user()->row();
        $teacher = $this->teachers->get_row_by_userid($user->id);
        $teacherInfo = $this->load->view('teacher/teacherinfo', array('teacher'=> $teacher), true);

        $notifications = $this->notifications->get_teacher_notifications();
        $content = $this->load->view('teacher/noticeboard',array('notifications'=>$notifications),true);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['teacher_id'] = $teacher->id;

        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['teacherInfo'] = $teacherInfo;

        $this->load->view('teacher/master_inner', $data);
    }

    function attendance(){

        $user = $this->ion_auth->user()->row();
        $teacher = $this->teachers->get_row_by_userid($user->id);
        $teacherInfo = $this->load->view('teacher/teacherinfo', array('teacher'=> $teacher), true);

        if($teacherInfo == null){
            ci_redirect('teacher/dashboard');
        }

        $courseDDL = $this->assign_courses->get_AssignCoursesDDLForTeacher($teacher->id);
        $content = $this->load->view('teacher/attendance',array('assign_courses' => $courseDDL),true);

        // Pass to the master view

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['teacher_id'] = $teacher->id;

        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['teacherInfo'] = $teacherInfo;

        $this->load->view('teacher/master_inner',$data);

    }

    function getAttendance($rdo_btn,$assign_course_id) {
        // Get Lectures
        $user = $this->ion_auth->user()->row();
        $teacher = $this->teachers->get_row_by_userid($user->id);

        if($rdo_btn=="daterange")
            $attendanceRecords = $this->attendance->get_attendanceCourseWiseByTeacher($teacher->id,$assign_course_id);
        else
            $attendanceRecords = $this->attendance->get_attendanceCourseWiseByTeacherCumulative($teacher->id,$assign_course_id);

        $this->load->view('teacher/attendanceList', array('attendanceRecords' => $attendanceRecords, 'rdo_btn' => $rdo_btn));


    }

}