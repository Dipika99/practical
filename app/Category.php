<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable=['name','parent_category_id'];

    public function services()
    {
    	return $this->hasMany('App\Service','id');
    }

    public function scopeParentCategory($query)
    {
        return $query->whereNull('parent_category_id');
    }

    public function scopeChildCategory($query, $parent_category_id = null)
    {   
        if(!empty($parent_category_id)){
            return $query->whereNotNull('parent_category_id')->where('parent_category_id',$parent_category_id);
        }
        
        return $query->whereNotNull('parent_category_id');
    }
    
    public function childOwnCategory()
    {
        return $this->hasMany('App\Category','parent_category_id','id');
    }
    public function parentOwnCategory()
    {
        return $this->belongsTo('App\Category','parent_category_id','id');

    }
}
