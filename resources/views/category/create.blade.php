@extends('layouts.app')

@section('content')
<div class="col-sm-3 sidenav">
	<h4>Create Category</h4>
	<ul class="list-group">
		<li class="list-group-item"><a href="{{ route('category.index') }}">List Categories</a></li>
	</ul>
	<br>
</div>
<div class="col-sm-9" style="background-color:white">
	<h4>
		<small>
			<h1>Add Category</h1>
		</small>
	</h4>
	<hr>
	<form method="post" action="{{ route('category.store') }}">
		{{  @csrf_field() }}
		@method('POST')
		@include('category._form')
	</form>
	<br><br>
</div>
@endsection