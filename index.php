<!doctype html>
<?php
	session_start();
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notes App</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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
	<div class="row">
		<div class="page-header">
			<h1>Note Application<small> Built with PHP, Javascript, and MySQL</small></h1>
		</div>
	</div>
	<div class="row">
			<div class="col-md-4">
				<div id="post-note">
					<h4>Add a note:</h4>

					<form class="form-horizontal" role="form" id="add-note" action="process.php" method="post">
						
						<div class="form-group">
						    <label for="title" class="col-lg-2 control-label">Title</label>
						    <div class="col-lg-10">
						     	<input type="text" id="title" class="form-control" name="note-title" placeholder = "Title">
						    </div>
					  	</div>
					  	<div class="form-group">
						    <label for="note-box" class="col-lg-2 control-label">Note</label>
						    <div class="col-lg-10">
						     	<textarea rows="6" class="note form-control" id = "note-box" name="note-text"></textarea>
						    </div>
					  	</div>
					  	<div class="form-group">
						    <label for="send-note" class="col-lg-2 control-label"></label>
						    <div class="col-lg-10">
						     	<input class="btn btn-default" id="send-note" type="submit" />
						    </div>
					  	</div>
						<input type="hidden" name="note-id" value="0">
						
					</form>
				</div>
				<div class="alert alert-info">Tip: Double click note text to edit existing note.</div>
			</div>
	
			<div class="col-md-8">
				<div id="notes">
					<h4>My Notes</h4>
						<div id="results"></div>
				</div>
			</div>
		</div>
		
	</div>
</body>
</html>