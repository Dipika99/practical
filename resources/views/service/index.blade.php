@extends('layouts.app')
@section('page-css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<div class="col-sm-12"  style="background-color:white;">
	<h4>
		<small>
			<h1>Services</h1>
		</small>
		<a href="{{ route('service.create') }}"><button class="btn btn-primary">Add Service</button></a>
	</h4>
	
	<div class="card">
		<div class="card-body" >
			<form class="form-inline" action="" method="get">
				<div class="form-group">
					<label for="category_id">&nbsp;</label>
					<select name="category_id" class="form-control" id="category_id">
						<option value="">Select Category</option>
						@foreach($categories as $key=>$value)
						<option {{ ($fieldValues['category_id']==$key)? 'selected':'' }} value="{{ $key }}">{{ $value }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="sub_category_id">&nbsp;</label>
					<select name="sub_category_id" class="form-control" id="sub_category_id">
						<option value="">Select Sub Category</option>
						@foreach($sub_categories as $key=>$value)
						<option {{ ($fieldValues['sub_category_id']==$key)? 'selected':'' }}  value="{{ $key }}">{{ $value }}</option>
						@endforeach        
					</select>
				</div>
				<div class="form-group">
					<label for="date">&nbsp;</label>
					<input type="text" value="{{ $fieldValues['date'] }}" class="form-control" id="date" placeholder="Select Date" name="date">
				</div>
				<div class="form-group">
					<label for="email">&nbsp;</label>
					<input type="text" value="{{ $fieldValues['search_text'] }}" class="form-control" name="search_text" placeholder="Search">
				</div>
				<div class="form-group">
					<label for="email">&nbsp;</label>
					<button type="submit" class="btn btn-sm btn-success">Search</button>&nbsp;
					<button type="button" id="clear-search" class="btn btn-sm btn-danger">Clear</button>
				</div>
			</form>
		</div>
	</div>
	<br>
	<div class="card">
		<div class="card-body" >
			<div class="table-responsive">
				<table width="100%" class="table table-striped table-bordered responsive">
					<thead>
						<tr>
							<th> Service Name </th>
							<th> Category </th>
							<th> Sub Category </th>
							<th> Description </th>
							<th> Activation Start Date </th>
							<th> Activation End Date </th>
							<th> Action </th>
						</tr>
					</thead>
					<tbody>
						@forelse($services as $service)
						<tr>
							<td>{{ $service->name }}</td>
							<td>{{ ($service->category)?$service->category->name:'' }}</td>
							<td>{{ ($service->subCategory)?$service->subCategory->name:'' }}</td>
							<td>{{ $service->description }}</td>
							<td>{{ $service->activation_start_date->format('m/d/Y') }}</td>
							<td>{{ $service->activation_end_date->format('m/d/Y') }}</td>
							<td>
		                       	<form action="{!! route('service.destroy', $service->id) !!}" onsubmit="return confirm('Are you sure you want to delete this service?');" method="POST">
					                {{ csrf_field() }}
					                {!! method_field('DELETE') !!}
		                        	<a href="{{ route('service.edit', $service->id) }}"><button type="button" class="btn btn-primary btn-xs">Update</button></a>

			                        <button type="submit" class="btn delete btn-danger btn-xs">Delete</button>
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
		<li class="list-group-item">{{ $services->appends($fieldValues)->links() }}</li>
	</ul>
</div>
@endsection
@section('page-script')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

			$("#date").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd',
			});

			$('body').on('click', '#clear-search', function(e) {
				updateLocation();
	          	location.reload(true);
	      	});

	      	function updateLocation(){
      			var update_location = window.location.href.split('?')[0];
      			window.history.replaceState("", "", update_location);
	      	}
	});
</script>
@endsection