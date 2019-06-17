<?php

	// to verify queries
	function verify_query($result_set){

		global $connection;

		if(!$result_set){
			die("Database query failed!".mysqli_error($connection));
		}
	}

	// to check required fields
	function check_req_fields($req_fields){
		$errors = array();

		foreach ($req_fields as $field) {
			if(empty(trim($_POST[$field]))){
				$errors[] = $field.' is required';
			}
		}

		return $errors;
	}

?>