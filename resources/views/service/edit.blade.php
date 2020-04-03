@extends('layouts.app')

@section('content')
<div class="col-sm-3 sidenav">
	<h4>Edit Service</h4>
	<ul class="list-group">
		<li class="list-group-item"><a href="{{ route('service.index') }}">List Services</a></li>
	</ul>
	<br>
</div>
<div class="col-sm-9" style="background-color:white">
	<h4>
		<small>
			<h1>Edit Service</h1>
		</small>
	</h4>
	<hr>
	<form method="post" action="{{ route('service.update',$service->id) }}">
		{{  @csrf_field() }}
		@method('PATCH')
		@include('service._form')
	</form>
	<br><br>
</div>
@endsection