<?php
/**
*	lms DATABASE CLASS
*
*	This class establishes database connection for the lms application
*	It fully depends on the setup-config to run thus the db connection can only
*	be established after successful installation of the lms application
*	If the setup-config file is missing, then the application has not been 
*	installed. 
*
*/

class connection extends PDO {


	private $host      	= DB_HOST;
    private $user      	= DB_USER;
    private $pass      	= DB_PASSWORD;
    private $dbname    	= DB_NAME;
	private $charset	= DB_CHARSET;
    private $error		= 'Connection failed!';
	
	

	public function __construct ( ) {
	
	$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' .$this->charset;
	
	/**
	*	Once the required details for DB connection is set, 
	*	Try to connect to the database using PDO 
	*
	*/
	
        try{
		
         parent::__construct ( $dsn, $this->user, $this->pass );
		 
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
        // Disable emulated prepared statement when using the MySQL driver
		// This will enable lms to use prepared statements 
		
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			
        }
		
		
        /**
		*	If connection failed, stop accessing the lms database and throw
		*	error.
		*
		*
		*/
		
        catch(PDOException $e){
		
		 
		echo $this->error = $e->getMessage();
			
        }
   }


    
}



 ?>