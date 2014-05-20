<?php

/**
* Change password
*
* @param string $username
* @param string $newPassword
* @return boolean
*/
function user_edit($username, $newPassword)
{
 global $db, $user, $auth, $config, $phpbb_root_path, $phpEx;

 if (empty($username) || empty($newPassword))
 {
   return false;
 }

 $sql = 'UPDATE ' . USERS_TABLE . ' SET user_password=\'' . $db->sql_escape(md5($newPassword)) . '\' WHERE username = \''.$db->sql_escape($username).'\'';
 $db->sql_query($sql);

 return true;
}

?>