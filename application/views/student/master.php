<?php $this->load->view('student/header',$header);?>
<div class="content">
    <div class="wrapper">
        <!-- Left Colum -->
        <div class="left-col">

            <?php echo $studentInfo; ?>


        </div>
        <!-- Left Colum -->
        <!-- Mid Colum -->
        <div class="mid-col">
            <div class="job-listing">
                <?php echo $content;?>
            </div>
        </div>
        <!-- Mid Colum -->
        <!-- Right Colum -->
        <div class="right-col">
            <?php
            echo $right;
            ?>
        </div>
        <!-- Right Colum -->

    </div>
</div>

<?php $this->load->view('footer',$footer);?>
