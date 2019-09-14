<?php

namespace App\Http\Controllers\backoffice;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('checkPermissions:user,true');
    }

    public function index()
    {
        $users = User::all();
        return view('backoffice.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('backoffice.user.create_edt', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'min:6|required_with:confirm-password|same:confirm-password',
            'confirm-password' => 'min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        if ($request->avatar) {
            if (is_file(public_path('storage/avatares/' . $user->avatar)) && $user->avatar !== 'defaultuser.jpg') {
                unlink(public_path('storage/avatares/' . $user->avatar));
            }
            $imageName = time() . '_' . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('storage/avatares'), $imageName);
            $user->avatar = $imageName;
            $user->save();
        }

        if ($user->hasPermissionTo('assign permission') && $user->id != 1) {
            $user->syncPermissions([$request->input("permissions")]);
        }
        $request->session()->flash('status-success', 'The User was created successfully');
        return redirect()->route('user.edit', $user->id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();
        $user_permissions = $user->permissions->pluck('name');
        return view('backoffice.user.create_edt', compact('permissions', 'user', 'user_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => 'nullable|min:6|required_with:confirm-password|same:confirm-password',
            'confirm-password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $user = User::findOrFail($id);
        if ($request->input('password')) {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
        } else {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);
        }
        // Permissions
        if ($user->hasPermissionTo('assign permission') && $user->id != 1) {
            $user->syncPermissions([$request->input("permissions")]);
        }

        if ($request->avatar) {
            if (is_file(public_path('storage/avatares/' . $user->avatar)) && $user->avatar !== 'defaultuser.jpg') {
                unlink(public_path('storage/avatares/' . $user->avatar));
            }
            $imageName = time() . '_' . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('storage/avatares'), $imageName);
            $user->avatar = $imageName;
            $user->save();
        }

        $request->session()->flash('status-success', 'The User was created successfully');
        return redirect()->route('user.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $req
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === 1) {
            $req->session()->flash('status-error', "The user {$user->name} cannot be deleted.");
        } else {
            $user->delete();
            $req->session()->flash('status-success', "The user {$user->name} was successfully deleted.");
        }
        return redirect()->route('user.index');
    }
}
