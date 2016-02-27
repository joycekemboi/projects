<?php
   require_once('../settings.php');
   $postdata = file_get_contents("php://input");
   $request = (array) json_decode($postdata);
	
if($_SERVER['REQUEST_METHOD'] == 'POST'):
	if(isset($request) || !empty($request)):
      $add_data = array(
		    'fname'           => 'STRING|First Name|Please enter fname in the correct format',
		    'mname'           => 'STRING|Middle Name|Please enter mname in the correct format',
		    'lname'           => 'STRING|Last Name|Please enter lname in the correct format',
		    'username'        => 'STRING|username|Please enter username in the correct format',
		    'email'           => 'STRING|email|Please enter email in the correct format',
		    'phone'           => 'INTEGER|phone|Please enter phone in the correct format',
           );
	    $v = new validation;
	    // var_dump($request['fname']);
	    $arr = [];
    
         foreach($add_data as $key => $contents):
	    	list($validator,$label,$message) = explode("|", $contents);
	    	if(!isset($request[$key]) || empty($request[$key])):
	    		$input_error['error_'.$key] = gams_er('error',$label.' field must be filled');
	    		$input_data[$key] = '';
	    		// echo $input_error['error_'.$key];
	    	else:
	    		$data = $v -> check_data($request[$key],$validator);
	    		if($data == false):
	    			$input_error['error_'.$key] = gams_er('error',$message);
	    		else:
	    			$input_data[$key] = $v -> check_data($request[$key],'PURIFY');
	    			$input_error['error_'.$key] = false;
	    		endif;	
	    	endif;
	    endforeach;
	     if(isset($input_data))
	    	extract($input_data);
	    if(isset($input_error))
	    	extract($input_error);
	    $allowed = true;
	    foreach($input_error as $key => $err):
	    	if($input_error[$key] !== false ):
	    		$allowed = false;
	    		break;
	    	else:
	    		continue;
	    	endif;
	    endforeach;

	    if($allowed):
	    	#insert all your data
	    	//echo $lname;
	    $exists = array(
               	 	'fname'   => $fname,
               	 	'mname'  => $mname,
               	 	'lname'    => $lname,
               	 	'email'    => $email,
               	 	'phone'    => $phone,
               	 	'visibility'  => 1
               	 	);
	      $d_exists = data_availability('users',$exists);
	      $username_exists = data_availability('users',array('username'=>$username,'visibility'=>1));

	      if($d_exists):
	    	  echo gams_er('error','This user already exists');

	       else:
            if($username_exists):
	    	  	echo gams_er('error','This username has been taken');
             else:
             	// insert
             	 $insert = array(
               	 	'fname'   => $fname,
               	 	'mname'  => $mname,
               	 	'lname'   => $lname,
               	 	'email'    => $email,
               	 	'username'=> $username,
               	 	'phone'    => $phone,
               	 	'visibility'  => 1
               	 	);
             	$insert_data = insert_data('users',$insert);
             	if($insert_data):
	    	     	echo gams_er('success','User added successfully');

             	endif;
                 
            endif;
	      endif;
	     else:
	    	echo $input_error;
	    endif;
	 else:
		echo "<br class='clear-fix'><div class='error'>We could not process your request</div>";	

	endif;
	
endif;
 

	  // echo gams_er('error','This Period already exists!!');
 
?>
