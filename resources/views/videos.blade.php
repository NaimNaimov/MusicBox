@if ( !empty($videos) )
	@if( is_array($videos) )
		<ol>
			@foreach ($videos as $video)
				<li>
					<a href="#" data-videoId="{{ $video['id']['videoId'] }}">
						<img src="{{ $video['snippet']['thumbnails']['default']['url'] }}" alt="" />
						<span>{{ $video['snippet']['title'] }}</span>
					</a>
				</li>
			@endforeach
		</ol>
	@else
		<div class="error-message">
			<p>Something went wrong! Please try again later.</p>
		</div><!-- /.error-message -->
	@endif
@else
	<p>No Results.</p>
@endif