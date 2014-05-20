<?php

class Course_Assignments_Model  extends CI_Model  {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getAssignments($assignCourseId){

        $query = $this->db->get_where('course_assignments', array('assign_course_id' => $assignCourseId));
        $result=$query->result();

        if(!empty($result)){
            return $result;
        }else
            return null;
    }

    function getAssignmentByStudentId($studentId, $count=0){
        $limit = "";
        if($count> 0){
            $limit = "LIMIT ". $count;
        }

        $query=$this->db->query("
            SELECT c.name, ca.*
            FROM assign_course ac
            INNER JOIN course_assignments ca on ac.id=ca.assign_course_id
            INNER JOIN user_student s on s.section_id = ac.section_id
            INNER JOIN courses as c on c.id = ac.course_id
            AND ac.year_id = s.year_id
            WHERE s.id = ?
            ORDER BY ca.lecture_date DESC
          " . $limit, array($studentId));

        return $query->result_array();
    }

}