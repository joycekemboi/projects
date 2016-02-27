	<?php
		class lms_login {
			protected $username;
			protected $password;
			protected $ip;
			protected $browser;
			protected $tb;			
			
			function __construct ( $username, $password, $tb ) {
				$this->username = $username;
				$this->password = $password;
				$this->ip = real_ip_ad ();
				$this->browser = md5 ( detectBrowser() );
				$this->tb = $tb;							
			}
			
			# Hash variables 
			protected function hash_pw () {
				
				return lms_password_shield ( $this->password );
			}
			
			# Hash browser 
			protected function hash_browser () {
				
				return lms_password_shield ( $this->browser );
			}
			
			# Session ID generator 
			protected function ghrm_session_id () {
				
				$id = substr(str_replace('+', '', base64_encode(sha1(microtime(false), true))), 0, 15);
				return $id;
			}
			
			public function lms_login_status () {
				$status = $this->lms_login ();
				if ( $status === false ):
					return $this->lms_login_error ();
				else:
					return true;
				endif;				
			}
			protected function lms_login () {
				# handle login process
				$array = array ( 'code' => $this->username );
				$result = select_data ( $this->tb, $array );
				if ( empty ( $result ) ):
					return false;
				else:
					foreach ( $result as $row ):
						$db_pw = $row['password'];
						$user_name	= $row['code'];
					endforeach;
					if ( password_verify( $this->password, $db_pw )) :
							if ( $this->username === $user_name ):
								# create session ID 
								$date = lms_now();
								$session_id = $this->ghrm_session_id ();
								# Prepare session data 
								$browser = $this->hash_browser ();
								$user_id = lms_encrypt ( $user_name );
								
								$ip = md5 ( $this->ip );
								$data = $browser . '3184MgGxJ17' . $user_id . 'AD205' . $ip;
								# create session 
								$_SESSION['ghrm_session_id']	= $session_id;
								# update session table 
								$array = array (
										'login_time'	=>	$date,
										'session_id'	=>	$session_id,
										'data'			=>	$data,
										'status'		=>	'active'
								);
								insert_data ( 'session', $array );
								
								return true;
							else:
								return false;
							endif;
					else:
						return false;
					endif;
				endif;
			}
			
			protected function lms_login_error () {
				# handle login errors
				$status = $this->account_availability ();
				if ( $status === false ):
					$er = 'unregistered';
				else:
					# Check if account is blocked 
					$e = particular_detail( $this->username, $this->tb, 'code', 'account_status' );
					if ( $e == 'active' ):
						$reg_e = particular_detail( $this->username, $this->tb, 'code', 'confirmation' );
						if ( $reg_e === 0 ):
							# account pending confirmation 
							$er = 'unconfirmed';
						else:
							# account is confirmed, check other problems with the account 
							# Verify password.
							$er = 'general';
						endif;
					else:
						$er = particular_detail( $this->username, $this->tb, 'code', 'account_status' );
					endif;						
				endif;
				switch ( $er ):
					case 'unregistered':
						return gams_er('warning','Incorrect username or Password.');
						break;
					case 'unconfirmed':
						return gams_er('warning','The provided account has not been confirrmed yet.');
						break;
					case 'suspended':
						return gams_er('warning','This account has been suspended by the management.');
						break;
					case'blocked':
						return gams_er('warning','This account has been blocked.');
						break;
					case 'general':
						return gams_er('warning','The provided login details are invalid.');
					default:
						return '';
				endswitch;
				
			}
			
			protected function account_availability () {
				$array = array ( 'code' => $this->username );
				$result = select_data ( $this->tb, $array );
				if ( empty ( $result ) ):
					return false;
				else:
					return true;
				endif;
			}
			
			
			
			
		}
	?>