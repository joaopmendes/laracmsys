<?php

namespace App\Http\Controllers\backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('checkPermissions:permission');


    }
    public function index()
    {
        $permissions = Permission::all();
        return view('backoffice.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backoffice.permission.create_edt');
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
            'name' => 'required|min:3|max:25|unique:permissions',
            'guard_name' => 'required|min:3|max:25'
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);
        $request->session()->flash('status', 'The Permission was successfully Created');
        return redirect()->route('permission.edit', $permission->id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {

        $permission = Permission::findOrFail($id);
        return view('backoffice.permission.create_edt', compact('permission'));
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
            'name' => 'required|min:3|max:25',
            'guard_name' => 'required|min:3|max:25'
        ]);
        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);
        $request->session()->flash('status', 'The Permission was successfully Updated');
        return redirect()->route('permission.edit', $permission->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        $permission = Permission::findOrFail($id);
        if($permission->name === 'backoffice access'){
            $req->session()->flash('status-error', "The permission {$permission->name} cannot be deleted.");
        }else{
            $permission->delete();
            $req->session()->flash('status-success', "The permission {$permission->name} was successfully deleted.");
        }
        return redirect()->route('permission.index');
    }
}
