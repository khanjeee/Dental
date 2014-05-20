<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 8/3/13
 * Time: 11:04 PM
 * To change this template use File | Settings | File Templates.
 */

class Notification_Board_Model  extends CI_Model  {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    // Student Noticeboard
    function get_notifications($section_id,$year_id, $count = 10, $offset=0){
        // Group=2 means STUDENT NOTIFICATIONs

        $query = $this->db->query('SELECT nb.*
                                  FROM notification_board as nb
                                  WHERE
                                    nb.group_id = 2
                                    AND nb.status = 1
                                    AND nb.section_id = ?
                                    AND nb.year_id = ?
                                    AND year(nb.created_on) = ?
                                  Order by nb.created_on DESC
                                  LIMIT ?,?', array($section_id,$year_id,date('Y'), $offset, $count));

        $ret = $query->result_array();
        return $ret;
    }
    function get_notifications_count($section_id,$year_id){

        $query = $this->db->query('SELECT nb.id
                                  FROM notification_board as nb
                                  WHERE
                                    nb.group_id = 2
                                    AND nb.status = 1
                                    AND nb.section_id = ?
                                    AND nb.year_id = ?
                                    AND year(nb.created_on) = ?
                                  ', array($section_id,$year_id,date('Y')));

        return $query->num_rows();
    }




    // Teacher Notification -- Last 3 months data
    function get_teacher_notifications(){

        $query = $this->db->query('SELECT nb.*
                                  FROM notification_board as nb
                                  WHERE
                                    nb.group_id = 3
                                    AND nb.status = 1
                                    AND nb.created_on > ?
                                  Order by nb.created_on DESC',
                                    array( date("Y-m-d 00:00",strtotime("-3 Months"))));

        $ret = $query->result_array();
        //var_dump($this->db->last_query());
        return $ret;
    }
}

?>