
<div class="form-group">
	<label for="name">Category Name:<span class="text-danger">*</span></label>
	<input  class="form-control" value="{{ (old('name'))?old('name'):(isset($category)?$category->name:'') }}" required  name="name">
</div>
@php
	if(old('parent_category_id')){
		$old_parent_category_id = old('parent_category_id');
	}elseif (isset($category)) {
		$old_parent_category_id = $category->parent_category_id;
	}else{
		$old_parent_category_id = NULL;
	}
	$dis = '';
	if(isset($category)){
		if($category->childOwnCategory()->count()){
			$dis = 'disabled';
		}
	}
@endphp
<div class="form-group">
	<label for="parent_category_id">Parent Category:</label>
    <select name="parent_category_id" {{ $dis }} class="form-control" id="parent_category_id">
      	<option value="">Select Category</option>
        @foreach($categories as $key=>$value)
        	<option {{ ($old_parent_category_id==$key)? 'selected':'' }} value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
    <p><small>Note:Select parent category to make it sub category.</small></p>
</div>
<input type="submit" class="btn btn-success" value="Submit">