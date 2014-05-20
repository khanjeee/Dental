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
        <p><input type="radio" name="rdo_btn" id="course" checked="checked" value="course"> View by Course</p>
        <p style="padding-left: 20px;padding-top: 5px;"><?php echo $assign_courses; ?></p>
    </div>
    <div style="float:left;margin-top: 10px;">
        <p><input type="radio" name="rdo_btn" id="daterange" value="daterange"> View by Date</p>

    <div style="float:left;padding-top:5px;padding-bottom: 10px; padding-left: 22px;">
        <p>From Date</p><input name="start-date" id="start-date" class="date-pick dp-applied" disabled="disabled">
        <p>To Date</p><input name="end-date" id="end-date" class="date-pick dp-applied" disabled="disabled">
    </div>
    </div>
    <div>
        <br/><br/>
        <p><input type="submit" value="Submit" class="btn" onclick="submit();"></p>
        <br/><br/>
    </div>
    <div id="attendanceSheet"></div>
</div>

<?php
$format = 'Y-m-d';
$date = date ( $format );
$startDate= date ($format, strtotime ( '-90 day' . $date ));
$endDate=date($format, time());
?>

<script type="text/javascript">

    $(function()
    {
        Date.firstDayOfWeek = 0;
        Date.format = 'yyyy-mm-dd';

//        $('.date-picker').datePicker({startDate:'<?php echo $startDate ; ?>',endDate:'<?php echo $endDate ; ?>'});
    });


$('.date-pick').datePicker({
    startDate: '01/01/1970',
    endDate: (new Date()).asString()
});
$('#start-date').bind(
        'dpClosed',
        function(e, selectedDates)
        {
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $('#end-date').dpSetStartDate(d.asString());//addDays(1).
            }
        }
);
$('#end-date').bind(
        'dpClosed',
        function(e, selectedDates)
        {
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $('#start-date').dpSetEndDate(d.asString()); //addDays(-1)
            }
        }
);


    function submit(){
        var start_date = $('#start-date').val();
        var end_date = $('#end-date').val();
        var assign_course_id = $("#assign_course").val();
        var rdo_btn = $("input:radio[name=rdo_btn]:checked").val();

        console.log(assign_course_id);
        console.log(rdo_btn);

        if((start_date=="" || end_date=="") && (rdo_btn=="daterange")){
            alert('Please select the date range.');
            return;
        }

        if(rdo_btn == "course"){
            start_date="1-1-1970";
            end_date="1-1-1970";
        }


        $.ajax({
            type: "POST",
            url: "<?php echo site_url('student/dashboard/getAttendance'); ?>/"+ rdo_btn +"/"+ assign_course_id + "/" + start_date +"/"+end_date  ,
            dataType: "html",
            success: function(data) {
                $('#attendanceSheet').html(data);
            }
        })
    }


</script>