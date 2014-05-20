<?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>

<link type="text/css" rel="stylesheet" href="<?php echo site_url('/assets/grocery_crud/css/jquery_plugins/jquery-ui-timepicker-addon.css')?>">
<script src="<?php echo site_url('/assets/grocery_crud/js/jquery_plugins/jquery-ui-timepicker-addon.min.js')?>"></script>
<script>
$('#field-time').timepicker();
$('#field-time').css("width","100px");
$('#field-duration').css("width","100px");
$('#field-room').css("width","100px");
$('#field-time').attr("readonly","true");
$('#field-start_on').attr("readonly","true");
$('#field-end_on').attr("readonly","true");
$('#field-end_on').attr("readonly","true");

</script>
