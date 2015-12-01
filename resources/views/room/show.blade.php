@extends('app')

@section('content')

<script>
	var isOwner = <?php echo $is_owner ? 'true' : 'false'; ?>;
</script>
	<div class="container" data-token="{{ csrf_token() }}" data-slug="{{ $room->first()->slug }}">
		<div class="content">
			<h2>{{ $room->first()->name }}</h2>

			<div class="search">
				{!! Form::open(array('action' => 'AjaxController@search_videos' ,'id' => 'search')) !!}
					{!! Form::text('search', '', array('placeholder' => 'Enter YouTube URL') )!!}
					{!! Form::submit('Search') !!}
				{!! Form::close() !!}
			</div><!-- /.search -->

			
			<div class="player-wrapper">
				@if($is_owner)
					<div id="player" id="player"></div>
				@endif

				<div class="playlist">
					<h3>Playlist</h3>

					<ol id="playlist" class="{{ empty($playlist) ? '' : '' }}"> 
						@if($playlist)
							@foreach($playlist as $p)
								<li>
									<a href="#" data-videoid="{{$p->video_id}}">{{$p->name}}</a>
								</li>
							@endforeach
						@endif
					</ol>
				</div><!-- /.playlist -->
			</div><!-- /.player-wrapper -->

			<div class="search-results" id="searchResults">
				<h3>Search Results</h3>

				<div class="results-container"></div>
			</div>
		</div>
	</div>
		

	@if($is_owner)
		<p class="text-warning text-center">The following option is irreversible.</p>
		<div class="form-delete-container">
			{!! Form::open(['method' => 'DELETE', 'route' => ['room.destroy', $room->first()->id]]) !!}
				{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
			{!! Form::close() !!}
		</div>
	@endif


	<span class="scroll-top">
		<i class="fa fa-chevron-circle-up"></i>
	</span>
@endsection


@section('notice')
 <div class="notice-playlist">Added To Playlist</div>
@endsection

@if($is_owner)
	@section('playlist-controls')
		<p class="nav navbar-nav current-song"></p>
		<ul class="nav navbar-nav navbar-player-controls">

			<li>
				<span class="prev">
					<i class="fa fa-step-backward"></i>
				</span>
			</li>

			<li>
				<span class="toggle-play">
					<i class="fa fa-play"></i>
					<i class="fa fa-stop"></i>
				</span>
			</li>

			<li>
				<span class="next">
					<i class="fa fa-step-forward"></i>
				</span>
			</li>
		</ul>
	@endsection
@endif