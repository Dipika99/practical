@section('page-css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

<div class="form-group">
	<label for="name">Service Name:<span class="text-danger">*</span></label>
	<input  class="form-control" value="{{ (old('name'))?old('name'):(isset($service)?$service->name:'') }}" required  name="name">
</div>
@php
	if(old('category_id')){
		$old_category_id = old('category_id');
	}elseif (isset($service)) {
		$old_category_id = $service->category_id;
	}else{
		$old_category_id = NULL;
	}

	if(old('sub_category_id')){
		$old_sub_category_id = old('sub_category_id');
	}elseif (isset($service)) {
		$old_sub_category_id = $service->sub_category_id;
	}else{
		$old_sub_category_id = NULL;
	}
@endphp
<div class="form-group">
	<label for="category_id">Category:<span class="text-danger">*</span></label>
    <select name="category_id" required class="form-control" id="category_id">
      	<option value="">Select Category</option>
        @foreach($categories as $key=>$value)
        	<option {{ ($old_category_id==$key)? 'selected':'' }} value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
	<label for="sub_category_id">Sub Category:<span class="text-danger">*</span></label>
	<select name="sub_category_id" required="" class="form-control" id="sub_category_id">
		<option value="">Select Sub Category</option>
    </select>
</div>
<div class="form-group">
	<label for="activation_start_date">Activation Start Date:<span class="text-danger">*</span></label>
	<input  class="form-control" id="start_date" value="{{ (old('activation_start_date'))?old('activation_start_date'):(isset($service)?$service->activation_start_date->format('m/d/Y'):'') }}"  required  name="activation_start_date">
</div>
<div class="form-group">
	<label for="activation_end_date">Activation End Date:<span class="text-danger">*</span></label>
	<input  class="form-control" required id="end_date"  value="{{ (old('activation_end_date'))?old('activation_end_date'):(isset($service)?$service->activation_end_date->format('m/d/Y'):'') }}"  name="activation_end_date">
</div>
<div class="form-group">
	<label for="description">Description:<span class="text-danger">*</span></label>
	<textarea  required class="form-control datepicker" style="resize:vertical" name="description">{{ (old('description'))?old('description'):(isset($service)?$service->description:'') }}</textarea>
</div>
<input type="submit" class="btn btn-success" value="Submit">

@section('page-script')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
		$(document).ready(function () {
			reloadSubcategories();

			var dateFormat = "mm/dd/yy",
				from = $("#start_date")
				.datepicker({
					changeMonth: true,
					changeYear: true,
				})
				.on("change", function () {
					to.datepicker("option", "minDate", getDate(this));
				}),
				to = $("#end_date").datepicker({
					changeMonth: true,
					changeYear: true,
				})
				.on("change", function () {
					from.datepicker("option", "maxDate", getDate(this));
				});

			function getDate(element) {
				var date;
				try {
					date = $.datepicker.parseDate(dateFormat, element.value);
				} catch (error) {
					date = null;
				}

				return date;
			}

			$('body').on('change', '#category_id', function () {
				reloadSubcategories();
			});

			function reloadSubcategories(){
				var category_id = $('#category_id').val();
				if (category_id != '') {
					var url = "{{ route('service.get-sub-categories') }}"
					var data = {
						category_id: category_id
					}
					$.ajax({
						type: 'POST',
						url: url,
						data: data,
						success: function (data) {
							if (data.result) {

								var categories = data.sub_categories;
								var options = '<option value="">Select Sub Category</option>';

								Object.keys(categories).forEach(function (key) {
									options += '<option value="' + key + '">' + categories[key] + '</option>';

								});

								$('#sub_category_id').empty();
								$('#sub_category_id').html(options);

								@if(!empty($old_sub_category_id))
									var sub_category_id = {!! $old_sub_category_id !!};
									$('#sub_category_id option[value="' + sub_category_id + '"]').attr("selected", "selected");
								@endif
							}
						},
						error: function (err, data) {
							console.log(err);
						}
					});
				}
			}
		});
    </script>
@endsection