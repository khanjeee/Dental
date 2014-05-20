<?php
$html =  "<br/><br/>
            <table class='border_table' cellspacing='10' cellpadding='10'>".
            "<tr class='th_id'><td style='width:60px;'>Code</td><td>Course</td><td style='width:60px;'>Section</td><td style='width:60px;'>Year</td><td style='width:60px;'>Course Detail</td><td style='width:60px;'>Assignments</td></tr>";

//y.year,sec.section,d.name as department
if(count($list) > 0){
    foreach($list as $item){
        $html .= "<tr><td>".$item['code']. "</td><td>".$item['name']."</td><td>". $item['section'] ."</td><td>". $item['year'] ."</td><td style='text-decoration: none;
                color: #007fda;'>". anchor('teacher/courses/view/'. $item['assign_course_id'] , 'view')."</td>".
                "<td style='text-decoration: none;
                color: #007fda;'>". anchor('teacher/courses/assignments/'. $item['assign_course_id'] , 'view')."</td>
            </tr>";
    }
}else {
    $html .= "<tr><td colspan='6'>No record found.</td></tr>";
}

    $html .= "</table>";
    echo $html;
?>

