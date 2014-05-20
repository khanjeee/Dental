/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.16 : Database - kmdc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kmdc` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `kmdc`;

/*Table structure for table `answers` */

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `answers` */

insert  into `answers`(`id`,`question_id`,`answer`,`is_correct`) values (15,3,'FALSE',0);

/*Table structure for table `assign_course` */

DROP TABLE IF EXISTS `assign_course`;

CREATE TABLE `assign_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `year_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `batch_year` varchar(4) NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `assign_course` */

insert  into `assign_course`(`id`,`course_id`,`assigned_by`,`created_on`,`year_id`,`section_id`,`batch_year`,`is_locked`,`status`,`modified_on`) values (1,25,1,'2013-10-25 07:07:16',1,1,'2013',0,1,'0000-00-00 00:00:00');

/*Table structure for table `assign_course_teacher` */

DROP TABLE IF EXISTS `assign_course_teacher`;

CREATE TABLE `assign_course_teacher` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(20) DEFAULT NULL,
  `assign_course_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `assign_course_teacher` */

insert  into `assign_course_teacher`(`id`,`teacher_id`,`assign_course_id`) values (1,28,1);

/*Table structure for table `attendance` */

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `assign_course_id` int(11) DEFAULT NULL,
  `is_present` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `attendance` */

insert  into `attendance`(`id`,`student_id`,`assign_course_id`,`is_present`,`date`) values (1,23,1,1,'2013-10-30'),(2,26,1,1,'2013-10-30'),(3,23,1,0,'2014-02-22'),(4,26,1,1,'2014-02-22');

/*Table structure for table `content` */

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_desc` text,
  `file_path` text NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `content` */

insert  into `content`(`id`,`content_desc`,`file_path`,`content_type_id`,`created_by`,`created_on`) values (2,NULL,'67195-fullpage.png',2,1,'2013-07-21 09:40:37'),(3,NULL,'d9f9f-Curriculum-Vitae.pdf',2,1,'2013-07-24 10:12:22');

/*Table structure for table `content_types` */

DROP TABLE IF EXISTS `content_types`;

CREATE TABLE `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `type_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `content_types` */

insert  into `content_types`(`id`,`type`,`type_desc`) values (1,'Podcast','Podcast'),(2,'Lecture','Lecture'),(3,'Associated Material','Associated Material'),(4,'Video','Video ');

/*Table structure for table `course_assignments` */

DROP TABLE IF EXISTS `course_assignments`;

CREATE TABLE `course_assignments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `assign_course_id` int(11) NOT NULL,
  `topic` varchar(200) NOT NULL,
  `topic_desc` text NOT NULL,
  `sort_order` tinyint(2) NOT NULL,
  `lecture_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uploaded_file` text NOT NULL,
  `uploaded_audio` text,
  `section_id` int(11) NOT NULL,
  `batch_year` varchar(4) NOT NULL,
  `refer_links` text,
  `tags` varchar(100) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `publish_assestment` tinyint(1) NOT NULL DEFAULT '0',
  `send_email` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `course_assignments` */

/*Table structure for table `course_contents` */

DROP TABLE IF EXISTS `course_contents`;

CREATE TABLE `course_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `course_contents` */

/*Table structure for table `course_lectures` */

DROP TABLE IF EXISTS `course_lectures`;

CREATE TABLE `course_lectures` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `assign_course_id` int(11) NOT NULL,
  `topic` varchar(200) NOT NULL,
  `topic_desc` text NOT NULL,
  `sort_order` tinyint(2) NOT NULL,
  `lecture_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uploaded_file` text,
  `uploaded_audio` text,
  `section_id` int(11) NOT NULL,
  `batch_year` varchar(4) NOT NULL,
  `refer_links` text,
  `tags` varchar(100) DEFAULT NULL,
  `publish_assestment` tinyint(1) NOT NULL DEFAULT '0',
  `send_email` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `course_lectures` */

insert  into `course_lectures`(`id`,`assign_course_id`,`topic`,`topic_desc`,`sort_order`,`lecture_date`,`created_by`,`created_on`,`modified_on`,`uploaded_file`,`uploaded_audio`,`section_id`,`batch_year`,`refer_links`,`tags`,`publish_assestment`,`send_email`) values (1,1,'Science','<p>\r\n	Desc</p>\r\n',0,'2013-10-25',1,'2013-10-25 07:13:53','2013-10-25 07:13:53',NULL,NULL,1,'2013',NULL,NULL,0,0);

/*Table structure for table `courses` */

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `courses` */

insert  into `courses`(`id`,`code`,`name`,`department_id`,`description`,`status`,`section_id`,`year_id`,`created_by`,`created_on`) values (23,'202','Physiology',5,'Physiology Course',1,1,2,1,'2013-08-29 23:05:23'),(24,'301','General Pathology including Microbiology & Parasitology',8,'General Pathology including Microbiology & Parasitology Course',1,1,3,1,'2013-08-29 23:07:08'),(25,'cse 561','Basic Sciences',10,'Basic science is the des',1,1,1,1,'2013-08-30 22:45:24');

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `departments` */

insert  into `departments`(`id`,`name`) values (4,'Anatomy'),(5,'Physiology'),(6,'Biochemistry'),(7,'Pharmacology and Therapeutics'),(8,'Pathalogy and Microbiology'),(9,'Community Health Sciences'),(10,'Basic Sciences');

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

insert  into `groups`(`id`,`name`,`description`) values (1,'admin','Administrator'),(2,'Student','Student Group'),(3,'Teacher','Teacher Group'),(4,'HOD','Head of Department'),(5,'Web Admin','Web Administration'),(6,'bvb','1vc');

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `login_attempts` */

/*Table structure for table `message_recipients` */

DROP TABLE IF EXISTS `message_recipients`;

CREATE TABLE `message_recipients` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `message_recipients` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `body` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `messages` */

/*Table structure for table `notification_board` */

DROP TABLE IF EXISTS `notification_board`;

CREATE TABLE `notification_board` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `news` text NOT NULL,
  `news_desc` text NOT NULL,
  `status` int(11) NOT NULL COMMENT 'publish/draft',
  `section_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `notification_board` */

insert  into `notification_board`(`id`,`news`,`news_desc`,`status`,`section_id`,`year_id`,`group_id`,`created_on`,`modified_on`) values (3,'<p>\n	Eid ul azha</p>\n','<p>\n	Eid Ul Azha planned on 10th oct</p>\n',1,1,1,2,'2013-08-30 23:15:31','0000-00-00 00:00:00');

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lecture_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `type` enum('MCQ','TRUE/FALSE') DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `questions` */

insert  into `questions`(`id`,`lecture_id`,`question`,`created_on`,`created_by`,`type`,`reason`) values (3,1,'<p>\r\n	<span style=\"color: rgb(255, 0, 0); font-family: arial, sans, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of </span><br style=\"color: rgb(255, 0, 0); font-family: arial, sans, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);\" />\r\n	<span style=\"color: rgb(255, 0, 0); font-family: arial, sans, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">letters, as opposed to using &#39;Content here, content here&#39; ?</span></p>\r\n','2013-10-31 03:45:06',1,'TRUE/FALSE','<p>\r\n	becauseit is true</p>\r\n');

/*Table structure for table `schedules` */

DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_course_id` int(11) NOT NULL,
  `start_on` date NOT NULL,
  `end_on` date NOT NULL,
  `time` time NOT NULL,
  `duration` int(11) NOT NULL,
  `room` varchar(20) NOT NULL,
  `day` varchar(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `schedules` */

insert  into `schedules`(`id`,`assign_course_id`,`start_on`,`end_on`,`time`,`duration`,`room`,`day`,`created_by`,`modified_on`,`created_on`) values (7,1,'2013-11-15','2013-11-05','02:10:00',120,'A4324','Wednesday',1,'2013-11-25 03:18:24','2013-11-25 03:17:38'),(8,1,'2013-11-01','2013-11-02','09:00:00',123,'fdsfs','Tuesday',1,'0000-00-00 00:00:00','2013-11-25 03:25:37');

/*Table structure for table `scheduless` */

DROP TABLE IF EXISTS `scheduless`;

CREATE TABLE `scheduless` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_course_id` int(11) NOT NULL,
  `start_on` date NOT NULL,
  `end_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `room` varchar(20) NOT NULL,
  `day` varchar(10) NOT NULL,
  `duration` time NOT NULL DEFAULT '00:00:00',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `scheduless` */

insert  into `scheduless`(`id`,`assign_course_id`,`start_on`,`end_on`,`room`,`day`,`duration`,`created_by`,`created_on`,`modified_on`) values (16,1,'2013-10-11','0000-00-00 00:00:00','dfd','Sunday','02:00:00',1,'2013-10-26 15:42:03','2013-10-26 16:04:13');

/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(100) NOT NULL,
  `section_desc` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `sections` */

insert  into `sections`(`id`,`section`,`section_desc`) values (1,'Medical','Medical Section'),(2,'Dental','Dental Section');

/*Table structure for table `student_assestments` */

DROP TABLE IF EXISTS `student_assestments`;

CREATE TABLE `student_assestments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `student_assestments` */

/*Table structure for table `student_course` */

DROP TABLE IF EXISTS `student_course`;

CREATE TABLE `student_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `assign_course_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `student_course` */

/*Table structure for table `user_question_attempts` */

DROP TABLE IF EXISTS `user_question_attempts`;

CREATE TABLE `user_question_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_answer_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_question_attempts` */

/*Table structure for table `user_student` */

DROP TABLE IF EXISTS `user_student`;

CREATE TABLE `user_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone_father` bigint(12) NOT NULL,
  `phone_home` bigint(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `role_number` varchar(20) DEFAULT NULL,
  `batch_year` varchar(4) DEFAULT NULL COMMENT '2005',
  `section_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `user_student` */

insert  into `user_student`(`id`,`user_id`,`student_id`,`forum_id`,`name`,`dob`,`gender`,`phone_father`,`phone_home`,`email`,`father_name`,`address`,`religion`,`phone`,`role_number`,`batch_year`,`section_id`,`year_id`) values (33,68,'324',109,'aaaa','2014-05-06','male',4534534,45341,'student5@kmdc.edu.pk','fsfsdf','dsfdsfsd','vxcv',423,'3434','2014',1,1);

/*Table structure for table `user_teacher` */

DROP TABLE IF EXISTS `user_teacher`;

CREATE TABLE `user_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `teacher_id` varchar(20) DEFAULT NULL,
  `forum_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_id in forums_user table',
  `name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL COMMENT 'Engineer',
  `institution` varchar(100) NOT NULL,
  `skills` varchar(100) NOT NULL,
  `designation` enum('professor','assistant professor','lab attendant') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Data for the table `user_teacher` */

insert  into `user_teacher`(`id`,`user_id`,`teacher_id`,`forum_id`,`name`,`department_id`,`email`,`phone`,`qualification`,`institution`,`skills`,`designation`) values (23,36,'9001',63,'Dr. Musarrat Nafees',4,'hodanatomy@kmdc.edu.pk',3001122331,'M.B.B.S., M.Phil','UoK','Anatomy Specialist','professor'),(24,37,'9002',64,'Prof. Nargis Anjum ',5,'hodphysiol@kmdc.edu.pk',3331122331,'MBBS,M.Phil','UoK','MBBS,M.Phil','assistant professor'),(25,38,'9003',65,'Prof. Javed I. Qazi',8,'hodpath@kmdc.edu.pk',3001122331,'M.B.B.S., Dip. R.C. Path (London). Ph.D','UoK','M.B.B.S., Dip. R.C. Path (London). Ph.D','professor'),(26,39,'9004',66,'Prof. Sohail Rafi Khan',6,'hodbiochem@kmdc.edu.pk',30001122331,'Ph.D (London)','UoK','Ph.D (London)','professor'),(27,43,'9005',70,'Dr Nadeem Baig',4,'drnadeem@kmdc.edu.pk',33300440,'Dr','UoK','Expert','professor'),(28,44,'T123',71,'Dr Samad',10,'drsamad@gmail.com',1234,'MBBS ','Abbasi shaheed , kmdc','Pharmacy','professor');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`ip_address`,`username`,`password`,`salt`,`email`,`activation_code`,`forgotten_password_code`,`forgotten_password_time`,`remember_code`,`created_on`,`last_login`,`active`,`first_name`,`last_name`,`company`,`phone`,`dob`) values (1,'\0\0','administrator','59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4','9462e8eee0','admin@kmdc.edu.pk','',NULL,NULL,NULL,1268889823,1400539930,1,'Admin','istrator','ADMIN','0','0000-00-00'),(24,'\0\0','humera@gmail.com','b1e94fb1e868b8f7d150295c664cbbbb0f3b665b',NULL,'humera@gmail.com',NULL,NULL,NULL,NULL,1373811185,1385669363,1,'humera','0','uok','545451','0000-00-00'),(30,'\0\0','badi@uok.edu','6ab6c9e4d3801530455b12ebea984199dde7ca48',NULL,'badi@uok.edu',NULL,NULL,NULL,NULL,1374094944,1374094944,1,'Badi',NULL,NULL,'5555555555','0000-00-00'),(31,'\0\0','shakeel@uok.edu','dc8abe963dc3cbb7aafb08b7141100f721e36792',NULL,'shakeel@uok.edu',NULL,NULL,NULL,NULL,1374095013,1374095013,1,'shakeel',NULL,NULL,'44444','0000-00-00'),(36,'ØnÕ\0','hodanatomy@kmdc.edu.pk','5e28555b8821497fce6b05f824f599436d5b292d',NULL,'hodanatomy@kmdc.edu.pk',NULL,NULL,NULL,NULL,1377800354,1400518900,1,'Dr. Musarrat Nafees',NULL,NULL,'0300-7788901','0000-00-00'),(37,'ØnÕ\0','hodphysiol@kmdc.edu.pk','5848b59e5e19f308a1117f9d4559d6c22bbd0719',NULL,'hodphysiol@kmdc.edu.pk',NULL,NULL,NULL,NULL,1377800480,1377800480,1,'Prof. Nargis Anjum ',NULL,NULL,'03331122331','0000-00-00'),(38,'ØnÕ\0','hodpath@kmdc.edu.pk','044cee82a5ea5ef25c1f44fc5e02a24bdc6744bc',NULL,'hodpath@kmdc.edu.pk',NULL,NULL,NULL,NULL,1377800580,1377800580,1,'Prof. Javed I. Qazi',NULL,NULL,'03001122331','0000-00-00'),(39,'ØnÕ\0','hodbiochem@kmdc.edu.pk','0aef23f4261692a00616351a91c62b523310f886',NULL,'hodbiochem@kmdc.edu.pk',NULL,NULL,NULL,NULL,1377800733,1377800733,1,'Prof. Sohail Rafi Khan',NULL,NULL,'030001122331','0000-00-00'),(43,'ØnÕ\0','drnadeem@kmdc.edu.pk','269b572973f93561881cf4dbf3f64770cf1d34c8',NULL,'drnadeem@kmdc.edu.pk',NULL,NULL,NULL,NULL,1377801932,1377801932,1,'Dr Nadeem Baig',NULL,NULL,'033300440','0000-00-00'),(44,'\'0Âa','drsamad@gmail.com','911e1cbcd6f2eaec96bcde5bdda77b868c629076',NULL,'drsamad@gmail.com',NULL,NULL,NULL,NULL,1377884587,1377884587,1,'Dr Samad',NULL,NULL,'1234','0000-00-00'),(60,'\0\0','shoaibkhan105@live.com','16a7e9662ef08054ad3ca25a6caa2ad4f959a194',NULL,'shoaibkhan105@live.com','64f940c1d5ff3d89a2fbec6c91a235f54af1641f',NULL,NULL,NULL,1400532593,1400532593,0,'shoaib','shoaib',NULL,'423432432','0000-00-00'),(68,'\0\0','student5@kmdc.edu.pk','8570ebf2ca8ad2e3df15f234918e0ee0303a1985',NULL,'student5@kmdc.edu.pk',NULL,NULL,NULL,NULL,1400536846,1400539916,1,'aaaa','aaaa',NULL,'423','0000-00-00');

/*Table structure for table `users_groups` */

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

/*Data for the table `users_groups` */

insert  into `users_groups`(`id`,`user_id`,`group_id`) values (48,1,1),(77,24,3),(56,36,3),(57,37,3),(58,38,3),(59,39,3),(61,41,2),(63,43,3),(64,44,3),(72,49,1),(88,56,1),(89,57,1),(90,58,2),(91,59,2),(92,60,2),(94,62,2),(95,63,2),(100,68,2),(102,70,2);

/*Table structure for table `years` */

DROP TABLE IF EXISTS `years`;

CREATE TABLE `years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(10) NOT NULL,
  `year_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `years` */

insert  into `years`(`id`,`year`,`year_desc`) values (1,'1st Year','1st Year'),(2,'2nd Year','2nd Year'),(3,'3rd Year','3rd Year'),(4,'4th Year','4th Year'),(5,'5th Year','5th Year');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
