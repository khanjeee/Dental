<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 9/11/13
 * Time: 12:21 AM
 * To change this template use File | Settings | File Templates.
 */
?>
    <div class="featured-jobs">
    <h1>Assessments</h1>
    <ul>
    <?php
        $item = "";
        foreach($last5assessments as $assessment){
            $item .= '<li><h1>' . $assessment['name'] . "</h1><h4>". $assessment['topic'] . "</h4><h4>". date('dS M Y h:ia',strtotime( $assessment['created_on'])) . " | ". $assessment['score']. "</h4></li>";
        }
        if(empty($item)){
            $item = "<li>Attempt assessments to prepare yourself.</li>";
        }
        echo $item;
    ?>
    </ul>
    </div>
    <div class="featured-jobs" style="margin-top: 20px;">
    <h1>Assignments</h1>
        <ul>
            <?php
            $item = "";
            foreach($last5Assignments as $assignment){
                $item .= '<li><a href="'. base_url()."student/courses/assignments/". $assignment['assign_course_id']   .'"><h1>' . $assignment['name'] . "</h1><p>". $assignment['topic'] . "</p><p>". date('d-m-Y h:ia',strtotime( $assignment['created_on'])) . "</p></a></li>";
            }
            if(empty($item)){
                $item = "<li>No assignment available.</li>";
            }
            echo $item;
            ?>
        </ul>
    </div>
