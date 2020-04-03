@extends('layouts.app')
@section('content')
<div class="col-sm-12"  style="background-color:white;">
	<h4>
		<small>
			<h1>Categories</h1>
		</small>
		<a href="{{ route('category.create') }}"><button class="btn btn-primary">Add Category</button></a>
	</h4>
	<br>
	<div class="card">
		<div class="card-body" >
			<div class="table-responsive">
				<table width="100%" class="table table-striped table-bordered responsive">
					<thead>
						<tr>
							<th> Category Name </th>
							<th> Type </th>
							<th> Parent Category Name </th>
							<th> Action </th>
						</tr>
					</thead>
					<tbody>
						@forelse($categories as $category)
						<tr>
							<td>{{ $category->name }}</td>
							<td>{{ (!empty($category->parent_category_id))?'Sub Category':'Parent Category' }}</td>
							<td>{{ ($category->parentOwnCategory)?$category->parentOwnCategory->name:'' }}</td>
							<td>
		                       	<form action="{!! route('category.destroy', $category->id) !!}" onsubmit="return confirm('Are you sure you want to delete this category?');" method="POST">
					                {{ csrf_field() }}
					                {!! method_field('DELETE') !!}
		                        	<a href="{{ route('category.edit', $category->id) }}"><button type="button" class="btn btn-primary btn-xs">Update</button></a>

			                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
		                    	</form>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="7" align="center"> No data available </td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<ul class="list-group">
		<li class="list-group-item">{{ $categories->links() }}</li>
	</ul>
</div>
@endsection