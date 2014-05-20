<div class="featured-jobs">
    <h1>Teacher Profile</h1>
    <ul style="float:left;width:160px;">
        <li style="float:left;">
            <span style="height:60px;width:80px;"><img src="<?php echo asset_img('student_male.png');?>"/></span>
        </li>
    </ul>
    <ul>
        <li>
            <h1>Name</h1>
            <?php echo $teacher->name;?>
        </li>
        <li>
            <h1>Designation</h1>
            <?php echo $teacher->designation;?>
        </li>
        <li>
            <h1>Faculty</h1>
            <?php echo $teacher->department;?>
        </li>
        <li>
            <h1>Email</h1>
            <?php echo $teacher->email;?>
        </li>
        <li>
            <h1>Phone</h1>
            <?php echo $teacher->phone;?>
        </li>
    </ul>
</div>


