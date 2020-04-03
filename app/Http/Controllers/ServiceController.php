<?php

namespace App\Http\Controllers;

use Response;
use App\Service;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceStoreRequest;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fieldValues = [
            'category_id'=>NULL,
            'sub_category_id'=>NULL,
            'date'=>NULL,
            'search_text'=>NULL,
        ];

        $services = new Service;

        if($request->has('category_id') && $request->category_id <> ''){
            $services = $services->where('category_id',$request->category_id);
            $fieldValues['category_id'] = $request->category_id;
        }

        if($request->has('sub_category_id') && $request->sub_category_id <> ''){
            $services = $services->where('sub_category_id',$request->sub_category_id);
            $fieldValues['category_id'] = $request->category_id;
        }

        if($request->has('date') && $request->date <> ''){
            $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
            $services = $services->where('activation_start_date', '<=', $date)->where('activation_end_date', '>=', $date);
            $fieldValues['date'] = $request->date;

        }

        if($request->has('search_text') && $request->search_text <> ''){
            $search_text = trim($request->search_text);
            $services = $services->where(function($query) use ($search_text){
                $query->where('name', 'LIKE', '%' . $search_text . '%')->orWhere('description', 'LIKE', '%' . $search_text . '%');
            });
            $fieldValues['search_text'] = $request->search_text;

        }

        $services = $services->paginate(5);

        $categories = Category::ParentCategory()->pluck('name','id')->toArray();
        $sub_categories = Category::ChildCategory()->pluck('name','id')->toArray();

        return  view('service.index',compact('services','categories','sub_categories','fieldValues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::ParentCategory()->pluck('name','id')->toArray();
        $sub_categories = Category::ChildCategory()->pluck('name','id')->toArray();

        return  view('service.create',compact('categories','sub_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['activation_start_date'] = Carbon::createFromFormat('m/d/Y', $request->activation_start_date)->format('Y-m-d');
        $data['activation_end_date'] = Carbon::createFromFormat('m/d/Y', $request->activation_end_date)->format('Y-m-d');
        $service = Service::create($data);
        if($service){
            return redirect()->back()->with('success', 'Service stored successfully.');
        }
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        
        $categories = Category::ParentCategory()->pluck('name','id')->toArray();
        $sub_categories = Category::ChildCategory()->pluck('name','id')->toArray();

        return  view('service.edit',compact('service','categories','sub_categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        
        $data = $request->all();
        unset($data['_token']);
        $data['activation_start_date'] = Carbon::createFromFormat('m/d/Y', $request->activation_start_date)->format('Y-m-d');
        $data['activation_end_date'] = Carbon::createFromFormat('m/d/Y', $request->activation_end_date)->format('Y-m-d');
        
        if($service->update($data)){
            return redirect()->back()->with('success', 'Service updated successfully.');
        }
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if($service->delete()){
            return redirect()->back()->with('success', 'Service deleted successfully.');
        }
        return redirect()->back()->with('success', 'Service can not be deleted.');
    }

    public function getSubCategory(Request $request){
        if($request->has('category_id')){
            $category_id = $request->category_id;
            $sub_categories = Category::ChildCategory($category_id)->pluck('name','id')->toArray();
            
            return response()->json(['result'=>true,'sub_categories'=>$sub_categories],200);
        }
        return response()->json(['result'=>false,'sub_categories'=>'Category id not found.'],200);

    }
}
