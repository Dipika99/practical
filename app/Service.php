<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable =['name','category_id','sub_category_id','description','activation_start_date', 'activation_end_date'];

    protected $dates = ['activation_start_date', 'activation_end_date'];

    public function category()
    {
    	return $this->belongsTo('App\Category','category_id')->withTrashed();
    }

    public function subCategory()
    {
    	return $this->belongsTo('App\Category','sub_category_id')->withTrashed();
    }

}
