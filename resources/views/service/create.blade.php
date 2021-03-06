@extends('layouts.app')

@section('content')
<div class="col-sm-3 sidenav">
	<h4>Create Service</h4>
	<ul class="list-group">
		<li class="list-group-item"><a href="{{ route('service.index') }}">List Services</a></li>
	</ul>
	<br>
</div>
<div class="col-sm-9" style="background-color:white">
	<h4>
		<small>
			<h1>Add Service</h1>
		</small>
	</h4>
	<hr>
	<form method="post" action="{{ route('service.store') }}">
		{{  @csrf_field() }}
		@method('POST')
		@include('service._form')
	</form>
	<br><br>
</div>
@endsection