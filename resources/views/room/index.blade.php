@extends('app')

@section('content')
	<div class="container">
		<div class="content">
			<div class="title">
				<h1>Rooms</h1>
			</div>

			<div class="rooms">
				@if( !$user_rooms->isEmpty() || !$user_public_rooms->isEmpty() || !$public_rooms->isEmpty() )

					@if(! $user_rooms->isEmpty() )
						<div class="room">
							<h3 class="room-cat">
								My Rooms
								<div class="actions">
									<i class="fa fa-minus"></i>
									<i class="fa fa-plus"></i>
								</div>
							</h3>

							<ul>
								@foreach($user_rooms as $room)
									<li>{!! link_to_route('room.show', $room->name, $room->slug) !!}</li>
								@endforeach
							</ul>
						</div>
					@endif

					@if(! $user_public_rooms->isEmpty() )
						<div class="room">
							<h3 class="room-cat">
								My Public Rooms
								<div class="actions">
									<i class="fa fa-minus"></i>
									<i class="fa fa-plus"></i>
								</div>
							</h3>
							
							<ul>
								@foreach($user_public_rooms as $room)
									<li>{!! link_to_route('room.show', $room->name, $room->slug) !!}</li>
								@endforeach
							</ul>
						</div>
					@endif

					@if(!$public_rooms->isEmpty() )
						<div class="room">
							<h3 class="room-cat">
								Public Rooms

								<div class="actions">
									<i class="fa fa-minus"></i>
									<i class="fa fa-plus"></i>
								</div>
							</h3>

							<ul>
								@foreach($public_rooms as $room)
									<li>{!! link_to_route('room.show', $room->name, $room->slug) !!}</li>
								@endforeach
							</ul>
						</div>
					@endif
				@else 
					<h3>There are no rooms.</h3>
					{!! link_to_route('room.create', 'Create Room', '', array('class' => 'btn btn-primary btn-lg btn-block'  ) ) !!}
				@endif
			</div>
		</div>
	</div>
@endsection