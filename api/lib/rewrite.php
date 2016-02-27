	<?php
	
	if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
	{
		// allow access....
		$mod_dir = str_replace("/ghrm/", "", $_SERVER['REQUEST_URI']);
		echo ABSPATH . $mod_dir; exit();
	} else {
		// ignore....
		$server_request = $_SERVER['REQUEST_URI'];
		$server_gets = explode ( '/', $server_request );
		foreach ( $server_gets as $get_index=>$server_get ):
			if ( strlen ( $server_get ) == 0 ):
				continue;
			elseif ( $server_get == 'ghrm' ):
			else:
				$server_urls[] = $server_get;
			endif;
		endforeach;
		$count_url_gets = 0;
		if ( ! isset ( $server_urls ) ):
			# skip rewriting.
		else:
			foreach ( $server_urls as $server_get_value ):
			$count_url_gets++;
			if ( $count_url_gets == 1 ):
				$_GET['module'] = $server_get_value;
			elseif ( $count_url_gets == 2 ) :
				$_GET['page'] = $server_get_value;
			elseif ( $count_url_gets == 3 ) :
				$_GET['id'] = $server_get_value;						
			endif;
		endforeach;
		endif;
	
	}
	
		
	 ?>