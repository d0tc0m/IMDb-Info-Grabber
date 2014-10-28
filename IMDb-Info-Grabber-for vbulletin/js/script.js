$(document).ready(function(){
$('input').bind('keypress', function(e) {
    if(e.keyCode==13){
        submit();
    }
});
$("button").click(function() {
    submit();
});
});  

function submit(){
	if (!$(this).hasClass("wait")) {
	$("#submit").addClass("wait");
	$("#submit").html("Loading");
	var imdb = $('#movie_search').val();
	$.post('imdb.php', { imdb: imdb}, function(data){
		$("#submit").removeClass("wait");
		$("#submit").html("Search");
		$('#result').html(data);
		$('#result').slideDown();
	});
	}
}