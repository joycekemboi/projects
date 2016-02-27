<?php
	# SQL TEMPLATES 
	# Query table 

	function insert_data ( $table, $array ) {
		$len = count ( $array );
		$count = 0;
		$fields = '';
		$params = '';
		foreach ( $array as $key=>$value ):
			$count++;
			if ( $count == $len ):
				$fields .= $key;
			else:
				$fields .= $key . ', ';
			endif;
		endforeach;
		$num = 0;
		foreach ( $array as $key=>$value ):
			$num++;
			if ( $num === $len ):
				$params .= ':' . $key;
			else:
				$params .= ':' . $key . ', ';
			endif;
		endforeach;
		
			$conn = new connection;
			$stmt =$conn->prepare ( "INSERT INTO $table ($fields) VALUE ($params)" );
			foreach ( $array as $key=>$value ):
				${$key} = $value;
				$stmt->bindParam (':'.$key.'', ${$key});
			endforeach;
			$stmt->execute();
			$conn = null;
			return true;
	}
	function return_last_id()
	{
		
		$id = $conn->lastInsertId();
		return $id;
	}

	function last_insert_id()
	{
		$conn = new connection;
		$id = $conn->lastInsertId();
		return $id;
	}

	
	function update_data ( $table, $array, $where ) {
		$length = count ( $array );
		$count = 0;
		$params = '';
		foreach ( $array as $key=>$value ):
			$count++;
			${$key} = $value;
			if ( $count == $length ):
				$params .= $key . "='" . ${$key} . "'";
			else:
				$params .= $key . "='" . ${$key} ."', ";
			endif;
		endforeach;
		
		$w_len = count ( $where );
		$w_count = 0;
		$w_params = '';
		foreach ( $where as $key=>$value ):
			$w_count++;
			${$key} = $value;
			if ( $w_count == $w_len ):
				$w_params .= $key . "='" . ${$key} . "'";
			else:
				$w_params .= $key . "='" . ${$key} . "' AND ";
			endif;
		endforeach;
		$conn = new connection;
		$sql = "UPDATE $table SET $params WHERE $w_params";
		$stmt = $conn->prepare ( $sql );
		$stmt->execute();
		$conn = null;
		return true;
	}
		function findall($table)
	{
		$conn = new connection;
		$qry = "SELECT * FROM $table";
		$stmt = $conn->prepare ( $qry );
		$stmt->execute();
		$result = $stmt->setFetchMode ( PDO::FETCH_ASSOC );
		$result = $stmt->fetchAll();
		return $result;

	}
	
	function select_data ( $table, $array ) {
		$len = count ( $array );		
		$counter = 0;
		$argms = '';
		foreach ( $array as $field=>$value ):
			$counter++;
			if ( $counter === $len ):
				$argms .= $field . "='" . $value."'";
			else:
				$argms .= $field . "='" . $value . "' AND ";
			endif;
		endforeach;
		$conn = new connection;
		$qry = "SELECT * FROM $table WHERE $argms";
		$stmt = $conn->prepare ( $qry );
		$stmt->execute();
		$result = $stmt->setFetchMode ( PDO::FETCH_ASSOC );
		$result = $stmt->fetchAll();
		return $result;
	}

	
	
	function delete_data ( $table, $array ) {
		$len = count ( $array );		
		$counter = 0;
		$argms = '';
		foreach ( $array as $field=>$value ):
			$counter++;
			if ( $counter === $len ):
				$argms .= $field . "='" . $value."'";
			else:
				$argms .= $field . "='" . $value . "' AND ";
			endif;
		endforeach;
		try {
			$conn = new connection;
			$sql = "DELETE FROM $table WHERE $argms LIMIT 1";
			$conn->exec( $sql );
		}
		catch ( PDOException $e ) {
			
		}
		
	}
	
	
	
	function particular_detail( $id, $table, $field, $detail ) {		
		$c = new connection;
		$stmt = $c->prepare ( "SELECT * FROM $table WHERE $field='$id' LIMIT 1" );
		$stmt->execute();
		$results = $stmt->setFetchMode ( PDO::FETCH_ASSOC );
		$results = $stmt->fetchAll();
		if ( empty ( $results ) ) :
			# No results 
			return null;
		else :
			# Check if multiple rows were returned. 
			if ( count ( $results ) == 1 ) :
				foreach ( $results as $row ) :
					return $row[$detail];
				endforeach;
			else :
				return null;
			endif;
		endif;
	}
	
	# Availability 
	function data_availability ( $table, $array ) {
		$results = select_data ( $table, $array );
		if ( empty ( $results ) ) :
			return false;
		else :
			return true;
		endif;		
	}
	function findBySql($sql)
	{
		$conn = new connection;		
		$stmt = $conn->prepare ($sql);
		$stmt->execute();
		$result = $stmt->setFetchMode ( PDO::FETCH_ASSOC );
		$result = $stmt->fetchAll();
		return $result;
	}

	
 ?>