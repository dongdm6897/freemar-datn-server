<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\BrandCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function create(Request $request)
    {
//        $brand = new Brand();
//        $brand->name = $request->input('name');
//        $brand->image = $request->input('image');
//        $brand->description = $request->input('description');
//        $brand->save();
//        return response()->json($brand);
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
        ]);

        Brand::create($request->all());

        return redirect()->route('brands.index')
            ->with('success','Brand created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('brands.show',compact('brand'));
    }


    public function destroy(Brand $brand)
    {
//        $brand = Brand::findOrFail($id);
        Schema::disableForeignKeyConstraints();
        $brand->delete();
        Schema::enableForeignKeyConstraints();


//        return redirect()->route('brands.index')
//            ->with('success','Brand deleted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit',compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    { $request->validate([
        'name' => 'required',
        'image' => 'required',
        'description' => 'required',
    ]);

        $brand->update($request->all());

        return redirect()->route('brands.index')
            ->with('success','Brand updated successfully');

    }


    public function index()
    {
        $brands = Brand::query();
        if(request()->ajax())
        {
            return DataTables::eloquent($brands)
                ->addColumn('action', function($data){
                    $button = '<a href="' . route('brands.show', $data->id) . '" class="btn btn-primary btn-sm"> View</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('brands.edit', $data->id) . '" class="edit btn btn-primary btn-sm"> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('brands.index');
    }



}
