<?php

class attendance_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   
  
    function check_attendance($post_array) // checks if attendance is already marked for a particular course
    {
    	
    	$query = $this->db->get_where('attendance', array('assign_course_id' => $post_array['assign_course_id'],'date'=>$post_array['date']));
    
    	$result=$query->result();
    	if(!empty($result)){
    		return 0;
    	}
    	else{
    		return 1;
    	}
    }
//return 0 if marked else return 1


    function get_attendance($startDate, $endDate, $student_id){

        $query=$this->db->query("SELECT a.*,c.code,c.name
								FROM attendance a
								INNER JOIN assign_course ac ON a.assign_course_id = ac.id
								INNER JOIN courses c on ac.course_id = c.id
								WHERE a.date >= ? AND a.date <= ? AND a.student_id = ?;", array($startDate,$endDate,$student_id));

        $result=$query->result_array();
        return $result;

    }

    function get_attendanceCourseWise($student_id,$assign_course_id){

        $query=$this->db->query("SELECT a.*,c.code,c.name
								FROM attendance a
								INNER JOIN assign_course ac ON a.assign_course_id = ac.id
								INNER JOIN courses c on ac.course_id = c.id
								WHERE a.assign_course_id= ? AND a.student_id = ?;", array($assign_course_id,$student_id));

        $result=$query->result_array();
        return $result;

    }

    function get_attendanceCourseWiseByTeacherCumulative($teacher_id,$assign_course_id){
        /*
         *  Only assign_course is enough as teacher only got his assigned_course so get the data
         */

        $query=$this->db->query("SELECT us.student_id,us.name,us.role_number, sum(is_present) as present, count(is_present) as total, a.student_id as id,c.code,c.name as course_name
								FROM attendance a
								INNER JOIN assign_course ac ON a.assign_course_id = ac.id
								INNER JOIN courses c on ac.course_id = c.id
                                INNER JOIN user_student us on us.id = a.student_id
								WHERE a.assign_course_id= ?
								GROUP By a.student_id
								;", array($assign_course_id));
        $result=$query->result_array();
        return $result;


    }

    function get_attendanceCourseWiseByTeacher($teacher_id,$assign_course_id){
        /*
         *  Only assign_course is enough as teacher only got his assigned_course so get the data
         */
        $query=$this->db->query("SELECT us.student_id,us.name,us.role_number, a.student_id as id , a.date,is_present,c.code,c.name as course_name
								FROM attendance a
								INNER JOIN assign_course ac ON a.assign_course_id = ac.id
								INNER JOIN courses c on ac.course_id = c.id
                                INNER JOIN user_student us on us.id = a.student_id
								WHERE a.assign_course_id= ?
								ORDER By a.date desc,us.name
								;", array($assign_course_id));
        $result=$query->result_array();
        return $result;


    }
}

