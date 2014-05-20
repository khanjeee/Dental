<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 10/19/13
 * Time: 11:46 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<?php
if(!empty($assignments)){
    foreach($assignments as $lecture)
    {
        $lec_file = "";
        if(!empty($lecture->uploaded_file)) {
            $lec_file = "<a href='".site_url(UPLOAD_LECTURES_FILE.'/'. $lecture->uploaded_file)."'>". $lecture->uploaded_file ."</a>";
        }
        $lec_audiofile = "";
        if(!empty($lecture->uploaded_audio)){
            $lec_audiofile = "<a href='".site_url(UPLOAD_LECTURES_AUDIO.'/'. $lecture->uploaded_audio)."'>". $lecture->uploaded_audio ."</a>";
        }
        ?>
    <div class="resent-job-inner">
        <h2><?php echo $lecture->topic;?></h2>
        <ul>
            <li class="first"><span>Posted: <?php echo $lecture->lecture_date;?></span> </li>
            <li> PPT: <?= $lec_file;?> </li>
            <li> Audio: <?= $lec_audiofile;?> </li>
        </ul>
        <?php echo $lecture->topic_desc;?>
        <p>Referal Link:<?php echo $lecture->refer_links;?></p>
    </div>
    <?php
    }
}else{
    ?>
<div class="resent-job-inner">
    No assignment uploaded.
</div>

<?php    }
?>