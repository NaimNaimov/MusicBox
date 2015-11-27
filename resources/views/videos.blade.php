@if ( !empty($videos) )
	@if( is_array($videos) )
		<ul>
			@foreach ($videos as $video)
				<li data-videoId="{{ $video['id']['videoId'] }}">
					<img src="{{ $video['snippet']['thumbnails']['default']['url'] }}" alt="" />
					<p>{{ $video['snippet']['title'] }}</p>    
				</li>
			@endforeach
		</ul>
	@else
		<div class="error-message">
			<p>Something went wrong! Please try again later.</p>
		</div><!-- /.error-message -->
	@endif
@else
	<p>No Results.</p>
@endif