<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $categories = Category::paginate(5);

        return  view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::ParentCategory()->pluck('name','id')->toArray();
        return  view('category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        
        $data = $request->all();
        unset($data['_token']);
        $category = Category::create($data);
        if($category){
            return redirect()->back()->with('success', 'Service updated successfully.');
        }
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        
        $categories = Category::ParentCategory()->pluck('name','id')->toArray();
        return  view('category.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        
        $data = $request->all();
        unset($data['_token']);
        if($category->update($data)){
            return redirect()->back()->with('success', 'Category updated successfully.');
        }
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {   
        if($category->delete()){
            return redirect()->back()->with('success', 'Category deleted successfully.');
        }
        return redirect()->back()->with('success', 'Category can not be deleted.');
    }
}
