<?php
require_once('classes/all_classes.php');

if (isset($_POST['imdb'])) {
	$imdb = $_POST['imdb'];
	$db = new Mysqlidb(DB_DSN, DB_USER, DB_PASS, DB_NAME);
	$regexp = "/[\w\d\.]+\.(com)/";
	if (preg_match($regexp, $imdb)) {
		preg_match_all("/tt\\d{7}/", $imdb, $ids);
		foreach ($ids as $row) {
		$imdb = $row[0];
		}
	}
	//preg_match_all("/tt\\d{7}/", $string, $ids);

	//If imdb id has been passed
	if (substr($imdb, 0, 2) === 'tt'){
		$params = array($imdb);
		//check if the movie is in the database
		$results = $db->rawQuery("SELECT * FROM movies WHERE imdb= ?", $params);
		//if nothing found
		if (empty($results)) {
			$add_db = new add_db();
			$add_db->api_call($imdb);
			$data_return = new data_return();
			$data_return->database_call($imdb);
			return $data_return->return_data();
		//return movie 	
		}  else {
			$data_return = new data_return();
			$data_return->database_call($imdb);
			return $data_return->return_data();
		}	
		//print_r($results);

	//If title has been passed
	}else{
		$params = array($imdb);
		//check if the movie is in the database
		$results = $db->rawQuery("SELECT * FROM movies WHERE title= ?", $params);
		//print_r($results);
		//if nothing found
		if (empty($results)) {
			$add_db = new add_db();
			$add_db->api_call($imdb);
			$data_return = new data_return();
			$data_return->database_call($imdb);
			return $data_return->return_data();
		} else {
			$data_return = new data_return();
			$data_return->database_call($imdb);
			return $data_return->return_data();
		}	
	} 

}

?>