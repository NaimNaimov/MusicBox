<html>
<head>
	<title>Laravel</title>
	
	<link href='//fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/functions.js"></script>
</head>
<body>
	<div class="container">
		<div class="content">
			<div class="title">Online Music Box</div>

			<div class="search">
				{!! Form::open(array('method' => 'GET')) !!}
					{!! Form::text('search', '', array('placeholder' => 'Enter YouTube URL') )!!}
					{!! Form::submit('Search') !!}
				{!! Form::close() !!}
			</div><!-- /.search -->
			
			<div class="player-wrapper">
				<div id="player" id="player"></div>

				<div class="playlist">
					<h3>Playlist:</h3>

					<ol id="playlist"></ol>
				</div><!-- /.playlist -->
			</div><!-- /.player-wrapper -->
		</div>
	</div>
</body>
</html>
