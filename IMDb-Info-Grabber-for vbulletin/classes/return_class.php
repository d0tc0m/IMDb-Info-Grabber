 <?php
 require_once('classes/all_classes.php');

class data_return{
	public function database_call($title){
		$db = new Mysqlidb(DB_DSN, DB_USER, DB_PASS, DB_NAME);
		if (substr($title, 0, 2) === 'tt'){
		$db->where('imdb', $title);
		}else {
		$db->where('title', $title);
		}
		$db_movie = $db->get('movies');
		//print_r($db_movie);
		foreach ($db_movie as $db_movie) {
				$this->movie_id = $db_movie['id'];
				$this->imdb = $db_movie['imdb'];
				$this->movie_title = $db_movie['title'];
				$this->movie_year = $db_movie['year'];
				$this->movie_genre = $db_movie['genre'];
				$this->movie_rating = $db_movie['rating'];
				$this->movie_votes = $db_movie['votes'];
				$this->movie_runtime = $db_movie['runtime'];
				$this->movie_director = $db_movie['director'];
				$this->movie_cast = $db_movie['cast'];
				$this->movie_plot = $db_movie['plot'];
				$this->movie_image = $db_movie['image'];
				$this->movie_trailer = $db_movie['trailer'];
		}

	}
public function return_data(){ ?>
<h3>BBCode:</h3>
<textarea id="txtarea" onClick="SelectAll('txtarea');">
[IMG]<?php echo $this->movie_image ?>[/IMG]

[B]Title:[/B] <?php echo $this->movie_title ?>

[B]Year:[/B] <?php echo $this->movie_year ?>

[B]Genre:[/B]  <?php echo $this->movie_genre ?>

[B]Rating:[/B] <?php echo $this->movie_rating ?> (<?php echo $this->movie_votes ?> votes)
[B]Runtime:[/B] <?php echo $this->movie_runtime ?>

[B]Director:[/B] <?php echo $this->movie_director ?>

[B]Cast:[/B] <?php echo $this->movie_cast ?>

[B]Plot:[/B] 
[CODE]<?php echo $this->movie_plot ?>[/CODE]
[B]Imdb Url:[/B] 
[CODE]http://www.imdb.com/title/<?php echo $this->imdb ?>/[/CODE]
[B]Movie Trailer:[/B] 
[CODE]http://www.youtube.com/watch?v=<?php echo $this->movie_trailer ?>[/CODE]

</textarea>
<br />
<h3> Html: </H3>
<textarea id="txtarea2" onClick="SelectAll('txtarea2');">
<img src="<?php echo $this->movie_image ?>" alt="<?php echo $this->movie_title ?>"/><br/>
<b>Title:</b> <?php echo $this->movie_title ?> <br/>
<b>Year:</b> <?php echo $this->movie_year ?><br/>
<b>Genre:</b>  <?php echo $this->movie_genre ?> <br/>
<b>Rating:</b> <?php echo $this->movie_rating ?> (<?php echo $this->movie_votes ?> votes) <br/>
<b>Runtime:</b> <?php echo $this->movie_runtime ?> <br/>
<b>Director:</b> <?php echo $this->movie_director ?> <br/>
<b>Cast:</b> <?php echo $this->movie_cast ?> <br/>
<b>Plot:</b> <?php echo $this->movie_plot ?> <br/>
<b>Imdb Url:</b> <a href="http://imdb.com/title/<?php echo $this->imdb ?>">http://imdb.com/title/<?php echo $this->imdb ?></a><br />
<b>Movie Trailer:</b> <iframe id="ytplayer" type="text/html" width="450" height="390" src="http://www.youtube.com/embed/<?php echo $this->movie_trailer ?>" frameborder="0"/></iframe>
</textarea>
<br />
<h3> Preview: </h3>
<img src="<?php echo $this->movie_image ?>" alt="<?php echo $this->movie_title ?>"/><br/>
<b>Title:</b> <?php echo $this->movie_title ?> <br/>
<b>Year:</b> <?php echo $this->movie_year ?><br/>
<b>Genre:</b>  <?php echo $this->movie_genre ?> <br/>
<b>Rating:</b> <?php echo $this->movie_rating ?> (<?php echo $this->movie_votes ?> votes) <br/>
<b>Runtime:</b> <?php echo $this->movie_runtime ?> <br/>
<b>Director:</b> <?php echo $this->movie_director ?> <br/>
<b>Cast:</b> <?php echo $this->movie_cast ?> <br/>
<b>Plot:</b> <?php echo $this->movie_plot ?> <br/>
<b>Imdb Url:</b> <a href="http://imdb.com/title/<?php echo $this->imdb ?>">http://imdb.com/title/<?php echo $this->imdb ?></a><br />
<b>Movie Trailer:</b> <iframe id="ytplayer" type="text/html" width="450" height="390" src="http://www.youtube.com/embed/<?php echo $this->movie_trailer ?>" frameborder="0"/></iframe>
<?php }
}
 ?>
