<?php

class Courses_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
    function get_courses_dropdown($value)
    {   
    	
    	$value=(!empty($value))? $value : 1;
    	$arrCourses=array();
    	
    	$this->db->select('id,name');
     	$query = $this->db->get('courses');
     	$result=$query->result();
		foreach ($result as $data ){
			
			$arrCourses[$data->id]=$data->name;
		}
		
		return form_dropdown('course_id', $arrCourses,$value,'id="courses"');
    }

    function get_course($id)
    {
        $query = $this->db->query('SELECT s.*,y.year,sc.section,d.name as department FROM courses s
                                    INNER JOIN years y on y.id = s.year_id
                                    INNER JOIN sections sc on sc.id = s.section_id
                                    INNER JOIN departments d on d.id = s.department_id
                                    WHERE s.id = ? ',array($id));
        $result=$query->result();
        if(!empty($result)){
            return $result[0];
        }else
            return null;
    }
    
    function get_course_by_id($course_id)
    {
    	$query = $this->db->get_where('courses', array('id' => $course_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }

    function get_all_courses($year, $section, $student_id)
    {
        $query = $this->db->query('SELECT s.*,ac.id as assign_course_id, y.year,sec.section,d.name as department FROM student_course sc
                                    INNER JOIN assign_course ac on ac.id = sc.assign_course_id
                                    INNER JOIN courses s on s.id = ac.course_id
                                    INNER JOIN years y on y.id = s.year_id
                                    INNER JOIN sections sec on sec.id = s.section_id
                                    INNER JOIN departments d on d.id = s.department_id
                                    WHERE ac.year_id = ? AND ac.section_id = ? AND sc.student_id = ? ', array($year,$section, $student_id));

        $ret = $query->result_array();
        return $ret;
    }

    function get_all_courses_for_teacher($teacher_id)
    {
        $query = $this->db->query('SELECT s.*,ac.id as assign_course_id, y.year,sec.section FROM assign_course_teacher act
                                    INNER JOIN assign_course ac on ac.id = act.assign_course_id
                                    INNER JOIN courses s on s.id = ac.course_id
                                    INNER JOIN years y on y.id = s.year_id
                                    INNER JOIN sections sec on sec.id = s.section_id
                                    WHERE ac.status = ? AND act.teacher_id = ?
                                    ORDER BY s.code,y.year', array(1 /*1=Active*/ ,$teacher_id));

        $ret = $query->result_array();
        return $ret;
    }

   function get_course_by_batch_section($post_array)
    {	
    	$query=$this->db->query("SELECT a.id,c.name 
				    			FROM assign_course a
				    			INNER JOIN courses c ON a.course_id = c.id
    							WHERE a.section_id={$post_array['section_id']}
    							AND a.batch_year={$post_array['batch_year']}
				    			GROUP BY c.name");
    	
    	
    	
    	//$query = $this->db->get_where('assign_course', array('section_id' => $post_array['section_id'],
    													//	'batch_year' => $post_array['batch_year']));
    	$result=$query->result();
    	if(!empty($result)){
    		return json_encode($result);
    	}
    	
    }
    
    
    function get_courses_by_section($post_array)
    {
    	$query=$this->db->query("SELECT id,name
    							FROM courses 
    							WHERE section_id={$post_array['section_id']}");
    			 
    			 
    			 
    			//$query = $this->db->get_where('assign_course', array('section_id' => $post_array['section_id'],
    					//	'batch_year' => $post_array['batch_year']));
    	$result=$query->result();
    					if(!empty($result)){
    					return json_encode($result);
    }
     
    }
    
    function get_courses_by_year($post_array)
    {	$this->db->select('id, name');
    	$query = $this->db->get_where('courses', array('year_id' => $post_array['year_id']));
    	$result=$query->result();
    					if(!empty($result)){
    					return json_encode($result);
    }
     
    }
    
    function get_year_by_course_id($course_id)
    {
    	$this->db->select('year_id');
    	$query = $this->db->get_where('courses', array('id' => $course_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->year_id;
    	}
    	 
    }
    
    //checks for duplicate entries in db return 1 if exist else 0
    function check_duplicate($course_code,$course_id)
    {	//print_r($row); die;
        $query = $this->db->get_where('courses',array('code' => $course_code));
    	$result=$query->result();
    	if(empty($result) || ($result[0]->id==$course_id)){ //checking course code against own id and if it exists in db or not
    		return 0;
    	}
    
    	else {
    		return 1;
    	}
    	//print_r($result); die;
    	//return (empty($result)|| empty($result2)) ? 0 : 1;
    	//return (empty($result)) ? 0 : 1;
    }
    
    //get department by course_id
    function get_department_by_assign_course_id($assign_course_id){
   
    $this->db->select('departments.name');
    $this->db->from('courses');
    $this->db->join('assign_course', 'assign_course.course_id = courses.id');
    $this->db->join('departments', 'departments.id = courses.department_id');
    $this->db->where('assign_course.id', $assign_course_id);
    
     $query = $this->db->get();
     $result= $query->result();
     return $result[0]->name;
}


}   
    
    
    
		



