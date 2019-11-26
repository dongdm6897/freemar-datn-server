<?php

namespace App\Http\Controllers\Admin;

use App\Models\MasterCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class MasterCollectionController extends Controller
{
    public function create(Request $request)
    {
        return view('collections.create');

    }




    /**
     * Display the specified resource.
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(MasterCollection $collection)
    {
        return view('collections.show',compact('collection'));
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
            'image' => 'required',
            'description' => 'required',
            'search_keywords' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
        ]);
        $request_data = $request->all();

        $request_data['valid_from'] = Carbon::parse($request->valid_from)->format('Y-m-d H:i:s');
        $request_data['valid_to'] = Carbon::parse($request->valid_to)->format('Y-m-d H:i:s');
        MasterCollection::create($request_data);
        return redirect()->route('collections.index')
            ->with('success', 'Collection created successfully.');
    }


    public function destroy(MasterCollection $collection)
    {
//        $brand = Brand::findOrFail($id);
        Schema::disableForeignKeyConstraints();
        $collection->delete();
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterCollection $collection)
    {
        return view('collections.edit',compact('collection'));
    }

    public function update(Request $request, MasterCollection $collection)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'search_keywords' => 'required',
        ]);
        $request_data = $request->all;
        $request_data['valid_from'] = Carbon::parse($request->valid_from)->format('Y-m-d H:i:s');
        $request_data['valid_to'] = Carbon::parse($request->valid_to)->format('Y-m-d H:i:s');


        $collection->update($request_data);

        return redirect()->route('collections.index')
            ->with('success','Brand updated successfully');

    }


    public function index()
    {
        $collections = MasterCollection::query();
        if(request()->ajax())
        {
            return DataTables::eloquent($collections)
                ->addColumn('action', function($data){
//                    $button = '<a href="' . route('collections.show', $data->id) . '" class="btn btn-primary btn-sm"> View</a>';
//                    $button .= '&nbsp;&nbsp;';
                    $button = '<a href="' . route('collections.edit', $data->id) . '" class="edit btn btn-primary btn-sm"> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('collections.index');
    }
}
