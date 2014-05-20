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
            <table class='border_table' cellspacing='10' cellpadding='10'>".
    "<tr class='th_id'><td style='width:100px;'>Code</td><td>Course</td><td style='width:100px;'>Date</td><td style='width:100px;'>Attendance</td></tr>";

if(count($attendanceRecords) > 0){
    foreach($attendanceRecords as $item){
        if($item['is_present']==0){
            $html .= "<tr class='red'><td>".$item['code']. "</td><td>".$item['name']."</td><td >". $item['date'] ."</td>".
                "<td>Absent</td></tr>";
        }else {
            $html .= "<tr class='green'><td>".$item['code']. "</td><td>".$item['name']."</td><td >". $item['date'] ."</td>".
                "<td>Present</td></tr>";
        }
    }
}else {
    $html .= "<tr><td colspan='4'>No record found.</td></tr>";
}

$html .= "</table>";

}else {

    $present=0;

    $html =  "<br/>
            <table class='border_table' cellspacing='10' cellpadding='10'>".
        "<tr class='th_id'>
        <td style='width:200px;'>Date</td><td style='width:100px;'>Attendance</td></tr>";

    if(count($attendanceRecords) > 0){
        foreach($attendanceRecords as $item){
            if($item['is_present']==0){
                $html .= "<tr class='red'><td >". $item['date'] ."</td>". "<td>Absent</td></tr>";
            }else {
                $html .= "<tr class='green'><td >". $item['date'] ."</td>"."<td>Present</td></tr>";
                $present++;
            }
        }
        $html .= "<tr class='th_id'><td>Total</td>"."<td>". $present . " out of ". count($attendanceRecords) ."</td></tr>";

    }else {
        $html .= "<tr><td colspan='2'>No record found.</td></tr>";
    }

    $html .= "</table>";

}
echo $html;
?>

