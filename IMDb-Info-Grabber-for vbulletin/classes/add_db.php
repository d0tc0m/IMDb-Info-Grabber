<?php
class add_db{

	public function api_call($search_movie){
		$movie = rawurlencode($search_movie);
		//echo $movie;
		if (substr($search_movie, 0, 2) === 'tt'){
			$endpoint = 'http://omdbapi.com/?i='. $movie .'&t=';
		}else {	
			$endpoint = 'http://omdbapi.com/?i=&t='.$movie;
		}
		$session = curl_init($endpoint);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($session);
		curl_close($session);

		$search_results = json_decode($data);
		//print_r($search_results);
		$this->movie = $search_results;
		if ($this->movie->Response === "False") {
			echo "Movie not found :(";
			die();
		} else {
			$this->addDatabase();
			//echo $this->movie->Response;
		}

	}

	public function addDatabase(){
		$db = new Mysqlidb(DB_DSN, DB_USER, DB_PASS, DB_NAME);
		$db_movie = $this->movie;

				$insertData = array(
				    'imdb' => $db_movie->imdbID,
				    'title' => $db_movie->Title,
				    'year' => $db_movie->Year,
				    'genre' => $db_movie->Genre,
				    'rating' => $db_movie->imdbRating,
				    'votes' => $db_movie->imdbVotes,
				    'runtime' => $db_movie->Runtime,
				    'director' => $db_movie->Director,
				    'cast' => $db_movie->Actors,
				    'plot' => $db_movie->Plot,
				);

				if ( $db->insert('movies', $insertData) );


				//save image
				$db->where('title', $db_movie->Title);
				$results = $db->get('movies');
				foreach($results as $results)
    				{
    					$db_movie_id = $results['id'];
    					$cover = $db_movie->Poster;
    					$this->imgur_upload($cover, $db_movie_id);
    					$this->get_youtube($db_movie->Title, $db_movie_id);
    				}

	}


	public function imgur_upload($cover, $db_movie_id){

			//echo urlencode($cover);
			$ch = curl_init("http://api.imgur.com/2/upload.json?key=f70eef9f324f0af4a31e6db1495eabba&image=".$cover);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			//$response = curl_exec($ch);
			$xml_raw = curl_exec($ch);
			$xmlsimple = new SimpleXMLElement($xml_raw);
			$uploaded_image = $xmlsimple->links->original;

			$db = new Mysqlidb(DB_DSN, DB_USER, DB_PASS, DB_NAME);
			$updateData = array(
			    'image' => "$uploaded_image",
			);
			$db->where('id', $db_movie_id);
			$results = $db->update('movies', $updateData);
			
	}

	public function get_youtube($db_movie_title, $db_movie_id){
			$youtube = urlencode($db_movie_title);
			$ch = curl_init("https://gdata.youtube.com/feeds/api/videos?q=".$youtube."+trailer&max-results=10");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			//$response = curl_exec($ch);
			$xml_raw = curl_exec($ch);
			$xmlsimple = new SimpleXMLElement($xml_raw);
			//print_r($xmlsimple);
			$youtube_trailer = $xmlsimple->entry->link[0]['href'];
			
			// get the youtube watch id
			parse_str( parse_url( $youtube_trailer, PHP_URL_QUERY ), $youtubeurl );
			$youtube_watch =  $youtubeurl['v'];    

			$db = new Mysqlidb(DB_DSN, DB_USER, DB_PASS, DB_NAME);
			$updateData = array(
			    'trailer' => "$youtube_watch",
			);
			$db->where('id', $db_movie_id);
			$results = $db->update('movies', $updateData);
	}

}
?>