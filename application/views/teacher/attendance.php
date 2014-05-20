<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 10/22/13
 * Time: 10:50 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<!--<script src="--><?php //echo asset_js('../grocery_crud/js/jquery_plugins/ui/jquery-ui-1.9.0.custom.min.js');?><!--"></script>-->
<script src="<?php echo asset_js('date.js');?>"></script>
<script src="<?php echo asset_js('jquery.datePicker.js');?>"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_css('datePicker.css');?>">

<div class="about-profile-people">
    <h1>Attendance</h1>
    <div>
        <p style="padding-top: 5px;"><?php echo $assign_courses; ?></p>
        <p style="padding-top: 5px;"><input type="radio" name="rdo_btn" id="course" checked="checked" value="course"> Cumulative View</p>
        <p style="padding-top: 5px;"><input type="radio" name="rdo_btn" id="daterange" value="daterange"> DateWise View</p>
    </div>
    <div style="float:left;margin-top: 10px;">

    <div style="float:left;padding-top:5px;padding-bottom: 10px; padding-left: 22px;">
    </div>
    </div>
    <div>
        <br/><br/>
        <p><input type="submit" value="Submit" class="btn" onclick="submit();"></p>
        <br/><br/>
    </div>
    <div id="attendanceSheet"></div>
</div>

<script type="text/javascript">

    function submit(){
        var assign_course_id = $("#assign_course").val();
        var rdo_btn = $("input:radio[name=rdo_btn]:checked").val();

        if(rdo_btn == "course"){
            start_date="1-1-1970";
            end_date="1-1-1970";
        }


        $.ajax({
            type: "POST",
            url: "<?php echo site_url('teacher/dashboard/getAttendance'); ?>/"+ rdo_btn +"/"+ assign_course_id  ,
            dataType: "html",
            success: function(data) {
                $('#attendanceSheet').html(data);
            }
        })
    }


</script>