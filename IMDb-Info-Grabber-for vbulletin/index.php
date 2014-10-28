<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>IMDB</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="js/script.js"></script>
	<script>
	function SelectAll(id){
    		document.getElementById(id).focus();
    		document.getElementById(id).select();
	}
	</script>
</head>
<body>
<h3>IMDB Grabber</h3>
<div id="searchbox" class="clearfix">
	<input id="movie_search" type="text" placeholder="IMDB Title/ID/URL" name="movie"><button id="submit" type="submit">Search</button>
</div>	
<div id="result">

</div>	
</body>
</html>