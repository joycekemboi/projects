<?php 
   require_once('../settings.php');
   $results = select_data('users',array('visibility'=>1));
   print json_encode($results);
 ?>