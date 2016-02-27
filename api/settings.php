<?php 	
error_reporting (E_ALL);
	
	# DB Name
	session_start ();
	
	define('DB_NAME', 'pharmacy');

	# MySQL database username
	define('DB_USER', 'root');

	# MySQL database password
	define('DB_PASSWORD', '');

	# MySQL hostname
	define('DB_HOST', 'localhost');

	# Database Charset to use in creating database tables.
	define('DB_CHARSET', 'utf8');
	
	# MAIN DIRECTORY 
	
	
	define ( 'AUTH_KEY', 'N0ubhTv%T-NCiuCjzxyx=qP2pOApyQrUn5cA5g14A99xfHw2OUDSx6Jw5Etc' );
	define ( 'SECURE_AUTH_SALT', '=86DGa165F^0%hDNbE7pSFSR8%R|%8coA60l86VKPH87SgoYRTNGXX1Xm-wg' );
	define ( 'LOGGED_IN_KEY', '_oMLMMkRx_SNz0CW^c vEyL=cfYV7%%6muC|FsyXQGEtkGQL8A2WBIcxlcLB' );
	
	# TIMEZONE SETUP
	date_default_timezone_set('Africa/Nairobi');
	# load functions



define('ABSPATH',__DIR__."/");
require_once(ABSPATH.'lib/functions.php');
 ?>