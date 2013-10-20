<!doctype html>
<?php
	session_start();
	// require('connection.php')
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notes App</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/notes.css">
	<script type="text/javascript">
		$(document).ready(function(){
			//delete notes when x is clicked
			$('#results').on('click', '.delete', function(){
        		var noteID = $(this).attr('id');
        		$("input[name='note-id']").val(noteID);
        	$('#add-note').submit();});

        	//edit notes when note-text div is clicked
        	$('#results').on('dblclick', '.note-text', function(){
        		var current = $(this).text();
        		var noteID = $(this).attr('id');
        		$(this).empty();
        		$(this).html("<form id='edit-note' action='process.php' method='post'><input type='hidden' name='edit-note-id' value='"+noteID+"'><textarea rows='6' cols='20' class='note' id='edit-note' name='edit-note-text'>"+current+"</textarea><input type='submit'>");
        		
        	});

			//When submit is clicked, send post to database, display posts
			$('#add-note').submit(function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('#results').html(data.html);
					},
					"json"
				);
				$('.note').val('');
				$('#title').val('');
				return false;
				
			});

			$(document).on('submit', '#edit-note', function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('#results').html(data.html);
					},
					"json"
				);
				return false;
				
			});


		$('#add-note').submit();});
	</script>
</head>
<body>
	<div id="container">
		<div id="notes">
			<h1>My Notes</h1>
				<div id="results"></div>
		</div>

		<div id="post-note">
			<h4>Add a note:</h4>
			<form id="add-note" action="process.php" method="post">
				<input type="hidden" name="note-id" value="0">
				<p>Title:<input type="text" id="title" name="note-title"></p>
				<textarea rows="6" cols="20" class="note" name="note-text"></textarea>
				<input type="submit" />
			</form>
		</div>
	</div>
</body>
</html>