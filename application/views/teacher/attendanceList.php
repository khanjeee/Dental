<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 10/23/13
 * Time: 12:17 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<style>

</style>

<?php

$html="";

if($rdo_btn == "daterange"){

$html =  "<br/>
            <table class='border_table' cellspacing='10' cellpadding='10'>";

if(count($attendanceRecords) > 0){
    $date="";
    foreach($attendanceRecords as $item){
        if($date != $item['date']){
            $date = $item['date'];
            $html .=  "<tr style='text-align:left;background-color: lightgray;font-size:14px;'><td colspan='4'><b>Date: ". date("d-M-Y", strtotime($date)) ."</b></td></tr>".
                "<tr class='th_id'><td>Student ID</td><td>Name</td><td>Role Number</td><td>Attendance</td></tr>";
        }
        if($item['is_present']==0){
            $html .= "<tr class='red'><td>". $item['student_id'] ."</td><td>".$item['name'] ."</td><td>".$item['role_number']."</td><td> Absent </td></tr>";
        }else {
            $html .= "<tr class='green'><td>". $item['student_id'] ."</td><td>".$item['name'] ."</td><td>".$item['role_number']."</td><td> Absent </td></tr>";
        }
    }
}else {
    $html .= "<tr><td colspan='4'>No record found.</td></tr>";
}

$html .= "</table>";

}else {
//student_id 	name 	role_number 	present 	total 	student_id 	code 	name
    $present=0;

    $html =  "<br/>
            <table class='border_table' cellspacing='10' cellpadding='10'>".
        "<tr class='th_id'>
        <td>Student ID</td><td>Name</td><td>Role Number</td><td>Attendance</td></tr>";

    if(count($attendanceRecords) > 0){
        foreach($attendanceRecords as $item){
                $html .= "<tr><td>". $item['student_id'] ."</td><td>".$item['name'] ."</td><td>".$item['role_number']."</td><td>".$item['present']." / ".$item['total']."</td></tr>";
        }
    }else {
        $html .= "<tr><td colspan='4'>No record found.</td></tr>";
    }

    $html .= "</table>";

}
echo $html;
?>

<td></td>

