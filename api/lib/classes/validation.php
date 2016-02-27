	<?php
		class validation {
			public $data;
			protected $type;
			
			
			public function check_data ( $data, $type ) {
				return $this->clean_data ( $data, $type );
			}
			
			
			protected function clean_data ( $data, $type ) {
				if ( $type == 'PURIFY' ):
					return $this->clean_xss ( $data );
				endif;
				if ( $type == 'INT' ):
					if ( preg_match ( "/^\d+$/", $data ) ):
						return true;
					else:
						return false;
					endif;
				else:
					$data = $this->clean_xss ( $data );
				endif;
				if ( ! function_exists ( 'validate_' . strtolower ( $type ) ) ) :
					return 'undefined function';
				else:
					switch ( $type ):
					case $type:
						return call_user_func_array ( 'validate_' . strtolower ( $type ) . '', array ($data ) );
						break;
					default:
						return $data;
				endswitch;
				endif;
			}
			
			
			
			protected function clean_xss ( $data ) {
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier( $config );
				$string = $purifier->purify( $data );
				#$string = trim ( $string );
				#$string = stripslashes ( $string );
				#$string = htmlspecialchars ( $string );
				return $string;
			}
			
		}
		
		function validate_email ( $data ) {
			if ( filter_var( $data , FILTER_VALIDATE_EMAIL) ):
				return true;
			else:
				return false;
			endif;
		}
		
		function validate_phone ( $data ) {
			# remove dashes
			if ( strpos ( $data, '-' ) !== false ):
				$data = str_replace ( '-', '', $data );
			else:
				$data = $data;
			endif;
			# remove spaces 
			if ( strpos ( $data, ' ' ) !== false ):
				$data = str_replace ( ' ', '', $data );
			else:
				$data = $data;
			endif;
			# remove brackets 
			if ( strpos ( $data, '(' ) !== false ):
				$data = str_replace ( '(', '', $data );
			elseif ( strpos ( $data, ')' ) !== false ):
				$data = str_replace ( ')', '', $data );
			else:
				$data = $data;
			endif;
			
			if( !preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $data ) ) :
				return false;
			else:
				return true;
			endif;
			
		}
		
		function validate_numeric ( $data ) {
			if ( ! is_numeric ( $data ) ):
				return false;
			else:
				return true;
			endif;
		}
		
		function validate_int ( $data ) {
			if ( ! is_int ( $data ) ):
				return false;
			else:
				return true;
			endif;
		}
		
		function validate_url ( $data ) {
			if (!filter_var($data, FILTER_VALIDATE_URL)):
				return false;
			else:
				return true;
			endif;
		}
		
		function validate_date ( $data ) {
			if ( strpos ( $data, '-' ) !== false ):
				$parts = explode ( '-', $data );
				$len = count ( $parts );
				if ( $len !== 3 ) :
					return false;
				else:
					$year 	= (int)$parts[2];
					$month 	= (int)$parts[1];
					$day 	= (int)$parts[0];
					if ( ! checkdate ( $month, $day, $year ) ):
						return false;
					else:
						return true;
					endif;
				endif;
			else:
				return false;
			endif;
		}
		
		function validate_ip ( $data ) {
			if (! filter_var($data, FILTER_VALIDATE_IP) === false):
				return true;
			else:
				return false;
			endif;
		}
		
		function validate_name ( $data ) {
			$chars = "` ~ ! @ # $ % ^ & * ( ) - + = } { [ ] | \ ? < > : ; 0 1 2 3 4 5 6 7 8 9/";
			$c = explode ( ' ', $chars );
			foreach ( $c as $char ) :
				if ( strpos ( $data, $char ) !== false ):
					return false;
					break;
				else :
					continue;
				endif;
			endforeach;
			if ( strlen ( $data ) < 3 ):
				return false;
			else:
				if ( strpos ( $data, ' ' ) !== false ):
					return false;
				else:
					return true;
				endif;
			endif;
		}
		
		function validate_string ( $data ) {
			if ( ! filter_var($data, FILTER_SANITIZE_STRING) === false):
				return true;
			else:
				return false;
			endif;
		}
		
		function validate_cleanname ( $data ) {
			$chars = "` ~ ! @ # $ % ^ & * ( ) - + = } { [ ] | \ ? < > : ; 0 1 2 3 4 5 6 7 8 9/";
			$c = explode ( ' ', $chars );
			foreach ( $c as $char ) :
				if ( strpos ( $data, $char ) !== false ):
					return false;
					break;
				else :
					continue;
				endif;
			endforeach;
			if ( strlen ( $data ) < 3 ):
				return false;
			else:
				return true;
			endif;
		}
		function validate_purify ( $data ) {
			
		}
		
		
		/*
		$v = new validation;
		
		$d = $v->check_data ( $input_data, FORMAT );
		var_dump ( $d );
		return true or false
		
		*/
		
	?>