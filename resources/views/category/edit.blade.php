@extends('layouts.app')

@section('content')
<div class="col-sm-3 sidenav">
	<h4>Edit Category</h4>
	<ul class="list-group">
		<li class="list-group-item"><a href="{{ route('category.index') }}">List Categories</a></li>
	</ul>
	<br>
</div>
<div class="col-sm-9" style="background-color:white">
	<h4>
		<small>
			<h1>Edit Category</h1>
		</small>
	</h4>
	<hr>
	<form method="post" action="{{ route('category.update',$category->id) }}">
		{{  @csrf_field() }}
		@method('PATCH')
		@include('category._form')
	</form>
	<br><br>
</div>
@endsection