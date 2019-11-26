<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        auth()->user()->givePermissionTo('role-list');
//        auth()->user()->assignRole('admin');
        $role = Role::findById(1);
        $permission = Permission::findById(8);
        $role->givePermissionTo($permission);
//        auth()->user()->removeRole('admin');
        return view('home');
    }
}
