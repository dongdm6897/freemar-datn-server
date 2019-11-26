<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $users = User::query();
        if(request()->ajax())
        {
            return DataTables::eloquent($users)
                ->addColumn('action', function($data){
                    $button = '<a href="' . route('users.show', $data->id) . '" class="btn btn-primary btn-sm"> View</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('users.edit', $data->id) . '" class="edit btn btn-primary btn-sm"> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('users.status', $data->id) . '" class="edit btn btn-primary btn-sm"> Status</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Schema::disableForeignKeyConstraints();
        $user->delete();
        Schema::enableForeignKeyConstraints();
    }

    //edit status
    public function status($id){
        $photo_type = null; $photo_font_image_link =null ; $photo_back_image_link = null;
        $user = User::find($id);
        $status = DB::table("master_user_status")->where('id','=',$user->status_id)->select('master_user_status.name')->first();
        $status_name = $status->name;
        $identify_photo_query = DB::table('identify_photo')->where('id','=',$user-> identify_photo_id)->first();
        if($identify_photo_query != null){
            $photo_type = $identify_photo_query->id;
            $photo_font_image_link = $identify_photo_query->font_image_link;
            $photo_back_image_link = $identify_photo_query->back_image_link;
        }


        return view('users.status',compact('user','status_name','photo_type','photo_font_image_link','photo_back_image_link'));
    }

    public function updateStatus(Request $request,$id){
        switch ($request->input('action')) {
            case 'accept':
                $user = User::find($id);
                $user->status_id += 1;
                $user->save();

                break;

            case 'decline':
                $user = User::find($id);
                $user->status_id -= 1;
                $user->identify_photo_id = null;
                $user->save();
                break;

        }
        return redirect()->route('users.status',$id)
            ->with('success','User status updated.');

    }


}
