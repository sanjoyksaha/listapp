<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $request['slug'] =Str::slug($request->name);
        Category::create($request->all());

        return response()->json(['success' => 'Category Created Successfull.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $request['slug'] =Str::slug($request->name);
        $category->update($request->all());

        return response()->json(['success' => 'Category Updated Successfull.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category Deleted Successfull.']);
    }

    public function deleteSelected($ids)
    {
        $all_id = explode(',', $ids);

        foreach ($all_id as $key => $id) {
            Category::findOrFail($id)->delete();
        }

        return response()->json(['success' => 'Categories Deleted Successfully.']);
    }
}
