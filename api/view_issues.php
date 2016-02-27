<?php
   // require_once('settings.php');
   $postdata = file_get_contents("php://input");
   $request = (array) json_decode($postdata);
    // var_dump($request[0]);
   // $results = select_data('users',array('visibility'=>1,'id'=>$request[0]));
   print json_encode($request[0]);
   // var_dump($results);
  ?>