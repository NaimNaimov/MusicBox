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
				{!! Form::open(array('id' => 'create-room')) !!}
					{!! Form::text('room-name', '', array('placeholder' => 'Enter Room Name') )!!}
					
					<div class="room-status">
						{!! Form::label('status', 'Room Status') !!}
						{!! Form::radio('status', 'private', true); !!}
						{!! Form::radio('status', 'public'); !!}
					</div><!-- /.room-status -->

					{!! Form::submit('Create') !!}
				{!! Form::close() !!}
			</div><!-- /.search -->
		</div>
	</div>
</body>
</html>
