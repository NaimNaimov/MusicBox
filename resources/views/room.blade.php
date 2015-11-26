@extends('layouts.default')

@section('room_styles')
@stop

@section('content')

<div class="container">
	<div class="title">Music Box</div>
	<div class="shell">
		{!! Form::open(array('method' => 'GET')) !!}
			{!! Form::text('search', '', array('placeholder' => 'Search') )!!}
		    {!! Form::submit() !!}
		{!! Form::close() !!}

	</div><!-- /.shell -->

	
	<div class="content">
		<div class="quote">{{ Inspiring::quote() }}</div>
	</div>
</div>

@stop
