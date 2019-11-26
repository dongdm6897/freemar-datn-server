<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function create(Request $request)
    {

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);
        Category::create($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('categories.show', compact('category'));
    }


    public function destroy(Category $category)
    {
        Schema::disableForeignKeyConstraints();
        $category->delete();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        foreach ($categories as $key => $value) {
            if ($value->id == $category->id) {
                unset($categories[$key]);
                break;
            }

        }

        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');

    }

    public function index()
    {

        $categories = Category::query();
        if(request()->ajax())
        {
            return DataTables::eloquent($categories)
                ->addColumn('action', function($data){
                    $button = '<a href="' . route('categories.show', $data->id) . '" class="btn btn-primary btn-sm"> View</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('categories.edit', $data->id) . '" class="edit btn btn-primary btn-sm"> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('categories.index');

    }



}
