@extends('app')

@section('content')
	<div class="container">
		<div class="content">
			<div class="title">Online Music Box</div>

			<div class="search">
				{!! Form::open(array('id' => 'search')) !!}
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

			<div class="search-results" id="searchResults"></div>
		</div>
	</div>
@endsection