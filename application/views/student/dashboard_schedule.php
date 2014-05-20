 <?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 9/10/13
 * Time: 12:58 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<link rel='stylesheet' href='<?php echo site_url("css/fullcalendar/theme.css");?>' />
<link href='<?php echo site_url("css/fullcalendar/fullcalendar.css");?>' rel='stylesheet' />
<script src='<?php echo site_url("js/fullcalendar/jquery-ui-1.10.2.custom.min.js");?>'></script>
<script src='<?php echo site_url("js/fullcalendar/fullcalendar.min.js");?>'></script>
<script src='<?php echo site_url("assets/js/jquery.qtip.min.js");?>'></script>

<script>

    $(document).ready(function() {

//        var date = new Date();
//        var d = date.getDate();
//        var m = date.getMonth();
//        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            theme: false,
            height: 240,
            titleFormat: '',
            header: {
                left: '',
                center: '',
                right: ''
            },
            allDaySlot: false,
            defaultView:'basicWeek',
            hiddenDays:[0],
            editable: false,
            minTime: 8,
            maxTime: 18,
            events: {
                url: '<?php echo site_url('student/dashboard/get_schedule'); ?>',
                data:{ year_id: $('#year_id').val(), batch_year: $('#batch_year').val() },
                cache: true
            }

        });

    });

</script>
<style>
    #calendar {
        text-align: center;
        font-size: 13px;
        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;

    }
</style>
<h1>Schedule</h1>
<div class='dashboard-schedule'>
<div id='calendar'></div>
</div>
