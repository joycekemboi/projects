<?php
			$HOST_NAME = ($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'] . '/ghrm/');
			$folders = array (
						'DOMAIN'	=>	$HOST_NAME,
						'LIBRARY'	=>	'lib/',
						'LOGOUT'    => 'lib/logout.php',		
						'TEMPLATES'	=>	'templates/',		
						'CSS'       =>  'css/',
						'ASSETS'	=>	'assets/',		
						'JS'		=>	'js/',
						'INCLUDES'  =>   'includes/',
						'IMAGES'    =>   'images/',
						'MODULES'   =>   'modules/',
						'PLUGINS'	=>	 'plugins/',
						'SYTEM_NAME' => 'Global HRM'
			);
										
			foreach ( $folders as $var=>$folder ):
				define ( $var, $folder );
			endforeach;
			
			//call classes
				spl_autoload_register(function ($class) {
					if(file_exists(ABSPATH . LIBRARY . 'classes/' . $class . '.php')):
						require_once (ABSPATH . LIBRARY . 'classes/' . $class . '.php' );
					endif;
				});

				// require_once (ABSPATH . LIBRARY . 'rbac/autoload.php');				
				
				//call sql functions
				require_once ( ABSPATH . LIBRARY . 'classes/HTMLPurifier.auto.php' );				
				require_once ( ABSPATH . LIBRARY . 'sql.php' );
				require_once ( ABSPATH . LIBRARY . 'html.php' );
					 
				# Current datetime
	#register css functions
	function register_css($css = array())
	{
		$css_links = '';
		if(!empty($css)):
			foreach($css as $link):
				#replace the string in header with these called css
				echo "<link rel='stylesheet' href='{$link}' type='text/css' />\n";			   
			endforeach;
		endif;
	}
	

	function register_js ($js = array())
	{
		$js_links = '';
		if(!empty($js)):
			foreach($js as $link):
				#replace the string in footer with these called js
				echo "<script src='{$link}' type='text/javascript'></script> \n";
			endforeach;
		endif;
	}
	// function to call body
	function load_body($title,$content = false)
	{
		require_once(ABSPATH . TEMPLATES . 'header.php');
		if(empty($title)):
			$title = 'GHRM HOME';			
		endif;
		$site_tags = str_replace('|TITLE|', $title, $site_tags);
		echo  $site_tags;
		echo $header_contents;

		if($content !== false):
			require_once(ABSPATH . TEMPLATES . 'template-body.php');
			$template_body = str_replace('|BODY|', $content, $template_body);
			echo $template_body;			
		endif;

	}
	 function lms_now() {		 
		 $timestamp = time();
		$cur_date = date('Y-m-d H:i:s', $timestamp);
		return $cur_date;
	 }
	 
	# Capture real IP address of visitor
	function real_ip_ad () {
		
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
		# check for ip from shared internet
		$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
		// Check for the Proxy User
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else
		{
		$ip = $_SERVER["REMOTE_ADDR"];
		}
		// This will print user's real IP Address
		// does't matter if user using proxy or not.
		return $ip;
	}
	
	# Browser Detection
	function detectBrowser() {
		try {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];		
		return $useragent;
		} catch (Exception $err) {
		return $err->getMessage();
		}
	}
	
	 # lms password shield 
	function lms_password_shield ( $password ) {
		$salt = lms_salt_generator ();
		
		$options = [
					'cost' => 11,
					'salt' => substr(str_replace('+', $salt, base64_encode(sha1(microtime(false), true))), 0, 22)
					];
		
		$pw = password_hash($password, PASSWORD_BCRYPT, $options);
		return $pw;		
	}
	
	# Unique encryption
		function lms_salt_generator () {
			$hash = mt_rand(10000,100000);
			$salt = substr(str_replace('+', $hash, base64_encode(sha1(microtime(false), true))), 0, 50);		
			return $salt;
		}
		
	# encrypt function 
	function lms_encrypt ( $data ) {
		$key = AUTH_KEY . SECURE_AUTH_SALT . LOGGED_IN_KEY;
		$cipher = new lms_cipher ( $key );
		$encrypted_data = $cipher->encrypt( $data );
		return $encrypted_data;
		$cipher = '';			
		}
			
	# decrypt data 
	function lms_decrypt ( $data ) {				
		$key = AUTH_KEY . SECURE_AUTH_SALT . LOGGED_IN_KEY;
		$cipher = new lms_cipher ( $key );
		$decrypted_data = $cipher->decrypt( $data );
		return $decrypted_data;
		$cipher = '';
		}
	
	# determine current user request 
	function lms_user_request () {
		return 'dashboard';
	}
	# load current user action request 
	function lms_load_request	( $user, $redirect ) {
		if ( $redirect === true ):
			header ( 'Location: ' . $redirect . '' );
		else:
			header ( 'Location: ' .DOMAIN . $user . '' );
		endif;
	}
	
	function login_user () {
		unset ( $_SESSION['ghrm_session_id'] );
		header ( 'Location: login.php' );
	}
	
	function lms_load_user () {
		global $dir;
		if ( ! file_exists ( ABSPATH . USERS . $dir ) ) :
			return false;		
		else :
			return true;
		endif;
	}
	
	function lms_clean_dir_url ( $string ) {
		$string = preg_replace("[0-9><]", "", $string );
		$string = strtolower ( $string );
		$string = str_replace ( ' ', '-', $string );		
	return $string;	
	}
	
	function lms_sanitize_user_action ( $user, $action ) {
		$action = lms_clean_dir_url ( $action );
		if ( ! file_exists ( ABSPATH . USERS . $user . '/templates/' . $action . '.php' ) ):
			return false;
		else:
			return $action;
		endif;
	}
	
	function current_user_can ( $level ) {
		global $user;
		if ( $user === $level ):
			return true;
		else:
			return false;
		endif;
	}
	
	function lms_dashboard_menu () {
		$dashboard = new dashboard_menu;
		return $dashboard->lms_dashboard_menu ();
	}
	
	function lms_user_nav ( $nav ) {
		$nav = new lms_user_nav ( $nav );
		return $nav->lms_user_navigation();
	}
	
	function clean_get_url ( $string ) {
		$string = preg_replace("[0-9><]", "", $string );
		$string = strtolower ( $string );
		$string = str_replace ( ' ', '-', $string );	
		return $string;
	}
	
	function lms_load_module ( $module ) {
		if ( ! file_exists ( ABSPATH . MODULES . $module . '/index.php' ) ):
			$module_name = str_replace ( '-', ' ', $module );
			printf ( '<div class="login-form">%s%s%s%s</div>', lms_er ( 'error', 'Missing <strong>'.ucwords ( $module_name ) .' Module!</strong>' ),
				'<p>The module must first be installed into the system for you to access it.</p>',
				'<a class="btn1 left blue" href="'.USER_DOMAIN.'">Go Back To Dashboard</a>',
				CONTACT_ADMIN );
		else:
			require_once ( ABSPATH . MODULES . $module . '/index.php' );
		endif;
	}
	
	function lms_load_module_template ( $template ) {
		$template = clean_get_url ( $template );
		if ( ! file_exists ( ABSPATH . MODULES . MODULE . '/' . TEMPLATES .  $template .'.php' ) ):
			return false;
		else:
			return true;
		endif;
	}
	
	function checkEven($num, $divider=false){
		if ( ! $divider ):			
			return ($num%2) ? true : false;
		else:
			return ($num%$divider) ? true : false;
		endif;
	}
	
	function lms_gen_unique_id ( $length ) {		
		$id = substr(number_format(time() * mt_rand(),0,'',''),0,$length);
		return $id;
	}
	
	
	/*DATE FORMATS*/
	//pt events start time display (FULL)
	function standard_event_time_full($date) {
	$timestamp = strtotime($date);
	$date=date('l d-m-Y H:i A', $timestamp);
	return $date;
	}


	//time display 
	function standard_time($date) {
	$timestamp = strtotime($date);
	$date=date('H:i', $timestamp);
	return $date;

	}
	//date and time display 
	function standard_date_time($date) {
	$timestamp = strtotime($date);
	$fdate=date('d M, Y H:i A', $timestamp);
	return $fdate;
	}

	//date and time display 
	function standard_date_time2($date) {
	$timestamp = strtotime($date);
	$fdate=date('d M, Y h:i A', $timestamp);
	return $fdate;
	}
	
	//date and time display 
	function standard_date_time3($date) {
	$timestamp = strtotime($date);
	$fdate=date('d-m-Y H:i A', $timestamp);
	return $fdate;
	}


	//date display 
	function standard_date($date) {
	$timestamp = strtotime($date);
	$fdate=date('d F, Y', $timestamp);
	return $fdate;

	}
	function standard_date2($date) {
	$timestamp = strtotime($date);
	$fdate=date('d/m/Y h:i A', $timestamp);
	return $fdate;

	}

	function standard_time2($date) {
	$timestamp = strtotime($date);
	$fdate=date('h:i A', $timestamp);
	return $fdate;

	}
	
	// XML DATA 
	function lms_load_xml_data ( $file ) {
		if ( ! file_exists ( DATA_BANK . $file . '.xml' ) ) :
			return false;
		else:
			return simplexml_load_file( DATA_BANK . $file . '.xml' );
		endif;
	}
	
	function lms_permalink ( $string ) {
		$string = trim ( $string );
		$string = strtolower ( $string );
		
		$chars = "` . ~ ! @ # $ % ^ & * ( ) - + = } { [ ] | \ ? < > : ; . /";
			$c = explode ( ' ', $chars );
			foreach ( $c as $char ) :
				$string = str_replace ( $char, '', $string );
			endforeach;
		
		$string = str_replace ( ' ', '-', $string );
		
		return $string;		
	}
	
	
	function current_userid () {
		if ( ! isset ( $_SESSION['ghrm_session_id'] ) ):
			return false;
		else:
			$session = new lms_user ( $_SESSION['ghrm_session_id'] );
			$current_userid = $session->lms_current_userid ();
			return $current_userid;
		endif;
	}
	
	function current_username () {
		$userid = current_userid ();
		if ( ! $userid ):
			return false;
		else:
			$type = particular_detail( $userid, 'logins', 'userid', 'user_type');
			if ( $type == 'staff' ):
				$tb = 'user';
			elseif ( $type == 'client' ):
				$tb = 'clients';
				
			else:
				$tb = null;
			endif;
			$fname = particular_detail( $userid, $tb, 'user_code', 'fname');
			$lname = particular_detail( $userid, $tb, 'user_code', 'lname');
			
			return ucwords ( $fname . ' ' . $lname );
		endif;
	}
	function find_login_name($id) {
		$login_id = $id;
		$userid = particular_detail( $login_id, 'logins', 'id', 'userid');
		if ( ! $userid ):
			return false;
		else:
			$type = particular_detail( $userid, 'logins', 'userid', 'user_type');
			if ( $type == 'staff' ):
				$tb = 'staff';
			elseif ( $type == 'client' ):
				$tb = 'clients';
			else:
				$tb = null;
			endif;
			$fname = particular_detail( $userid, $tb, 'userid', 'fname');
			$lname = particular_detail( $userid, $tb, 'userid', 'lname');
			
			return ucwords ( $fname . ' ' . $lname );
		endif;
	}

	
	function current_user_type () {
		$userid = current_userid ();
		$type = particular_detail( $userid, 'logins', 'userid', 'type');
		return $type;
	}
	function current_login_id () {
		$userid = current_userid ();
		$id = particular_detail( $userid, 'logins', 'userid', 'id');
		return $id;
	}
	
	# COUNTDOWN 
	function event_countdown ($time, $start_date) {
		$date = strtotime($start_date);
		switch($time) {
		case "day":
		$value = date('d', $date);
		break;

		case "month":
		$value = date('n', $date);
		break;

		case "year":
		$value = date('Y', $date);
		break;

		case "hour":
		$value = date('H', $date);
		break;

		case "minute":
		$value = date('i', $date);
		break;

		case "second":
		$value = date('s', $date);
		break;

		}
		return $value;
	}


	function lms_user_right ( $user, $module, $action ) {

		$rights = particular_detail( $user, 'users_roles', 'user_id', 'user_roles' );
		$rights = json_decode ( $rights, true );
		
		if ( ! array_key_exists ( $module, $rights ) ):
			return false;
		else:
			foreach ( $rights as $mod => $actions ):
				if ( $mod == $module ):
					$package = $actions;
				endif;
			endforeach;
			foreach (  $package as $act => $status):
				if ( $action == $act ) :
					$state = $status;
					break;
				else:
					continue;
				endif;								
			endforeach;
			$status = ( ! isset ( $state ) ) ? false : $state;
			return $status;
		endif;
	}
	
	function lms_change_key( $array, $old_key, $new_key) {

    if( ! array_key_exists( $old_key, $array ) )
        return $array;

    $keys = array_keys( $array );
    $keys[ array_search( $old_key, $keys ) ] = $new_key;

    return array_combine( $keys, $array );
}

function lms_user_name ( $id ) {
	$table = particular_detail( $id, 'logins', 'userid', 'user_type' ); 
	$fname = particular_detail( $id, $table, 'userid', 'fname' );
	$lname = particular_detail( $id, $table, 'userid', 'lname' );
	return ucwords ( $fname . ' ' . $lname );
}

function lms_user_position ( $id ) {
	$table = particular_detail( $id, 'logins', 'userid', 'user_type' );
	if ( $table == 'staff' ):
		$position = particular_detail( $id, $table, 'userid', 'designation' );
	else:
		$position = 'Client';
	endif;
	return ucwords ( $position );
}
		function current_exactId(){

    if (session_status() == PHP_SESSION_NONE) {
    ;
    }
        $userid = current_userid ();
        if ( ! $userid ):
            return false;
        else:
            $type = particular_detail( $userid, 'logins', 'userid', 'user_type');
            if ( $type == 'staff' ):
                $tb = 'staff';
            elseif ( $type == 'client' ):
                $tb = 'clients';
            else:
                $tb = null;
            endif;
            $id = particular_detail( $userid, $tb, 'userid', 'id');
        
            
            return ucwords ( $id );
        endif;
    }

    function breadcrumbs()
    {
    	$menu = '';
    	$menu.= '	
				<ol class="breadcrumb">
    					<li><a href="'.DOMAIN.'"><i class="fa fa-dashboard"></i> Home</a></li>	
    	';

    	if(isset($_GET['module']) || !empty($_GET['module'])):
    		$menu .= '<li><a href = "'.DOMAIN.$_GET['module'].'">'.ucfirst($_GET['module']).'</a></li>';
			if(isset($_GET['page']) || !empty($_GET['page'])):
				$menu.='
					<li class="active">'.ucfirst($_GET['page']).'</li>';
					if(isset($_GET['id']) || !empty($_GET['id'])):
						$menu.='
							<li class="active">'.ucfirst($_GET['id']).'</li>';
					endif;
			endif;
			
    	endif;

    	echo $menu;
    	
    	
    }
	function check($permission)
	{
		global $rbac;
		$return = false;
		$user_role = current_user_type();
		if(!empty($user_role)):
			$user_role_id = $rbac->Roles->returnId($user_role);
			$role_check = $rbac->Permissions->roles($permission);
			// return $role_check;

			if(is_array($role_check)):
				foreach($role_check as $value):
					if($user_role_id == $value):
						$return = true;
						break;
					else:						// return "dont =>" . strcmp($user_role_id, $value) . " =>".$user_role." =>".$value;
						continue;
					endif;
				endforeach;
			endif;
		endif;

		return $return;
	}

	
function select_dropdown($components = null,$prompt=null,$options = null,$nm = null,$val = null,$default=false,$multiple = false)
  {
	$select = '';
	$select .= '<select ';
	if(!empty($components)):
		foreach($components as $key=>$value):
			$select.= $key.'="'.$value.'"';
			if($key == 'required'):
				if($value == true):
					$select.='required ';
				endif;
			endif;
		endforeach;
	endif;
	if($multiple == true):
		$select.=' multiple="" ';
	endif;
	$select.='>';

	if(!empty($prompt)):
		if($default == false):
			$val_def = '';
		else:
			$val_def = $default;
		endif;		
		$select.='<option value="'.$val_def.'" selected="selected">'.$prompt.'</option>';
	endif;

	foreach($options as $index=>$value):
		$select.= '<option value="'.$value[$val].'">'.ucfirst($value[$nm]).'</option>';
	endforeach;

	$select.='</select>';

	echo $select;
}
	?>