<?php	
	# USER 
	class lms_user {
		protected $session_id;
		
		function __construct ( $id ) {
			if ( strlen ( $id ) != 15 ) :
				return false;
			else :
			
			$this->session_id = $id;
			
			endif;
			
		}
	# Get session id
	function ghrm_session_id () {
		$session_id = $this->session_id;
		$array = array ( 'session_id'	=>	$session_id, 'status'	=>	'active' );
		$user_results = select_data ( 'session', $array );		
		if ( empty ( $user_results ) ) :
			# no such session 			
			return false;
		else:
			# session exists, 
			foreach ( $user_results as $user ) :
				$s_id = $user['session_id'];
				break;
			endforeach;
			return $s_id;
		endif;			
		
	}
	
	# Get user type from session id 
	function lms_user_type () {
		$session_id = $this->session_id;
		
		$session_data = particular_detail( $session_id, 'session', 'session_id', 'data');
		$sections = explode ( '3184MgGxJ17', $session_data );
		$browser = $sections[0];
		$mix = $sections[1];
		$mixes = explode ( 'AD205', $mix );
		$user_id = ( $mixes[0] );
		
		$user_id=lms_decrypt($user_id);
		$user_type = particular_detail( $user_id, 'logins', 'code', 'type');
		return $user_type;
		
	}
	
	# Encrypted user ID 
	function lms_encrypted_user_id () {
		$session_id = $this->session_id;
		
		$session_data = particular_detail( $session_id, 'session', 'session_id', 'data' );
		$sections = explode ( '3184MgGxJ17', $session_data );
		$browser = $sections[0];
		$mix = $sections[1];
		$mixes = explode ( 'AD205', $mix );
		$encrypted_id = $mixes[0];
		
		return $encrypted_id;
	}
	
	# Decrypted user ID 
	function lms_real_user_id () {
		
		$current_id = $this->lms_encrypted_user_id();
		return lms_decrypt ( $current_id );
	}
	
	function lms_current_userid () {
		$username = $this->lms_real_user_id ();
		$user_id = particular_detail( $username, 'logins', 'code', 'userid');
		return $user_id;
	}
	
	

	}
	
 ?>