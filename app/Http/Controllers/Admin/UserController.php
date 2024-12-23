<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // public function getUsers()
    // {
    //     return DataTables::of(User::query())
    //     ->addColumn('actions', function ($user) {
    //         return view('admin.users.actions', compact('user'))->render();
    //     })
    //     ->rawColumns(['actions'])
    //     ->make(true);
    // }

    public function getUsers()
    {
        return DataTables::of(User::query())
            ->addColumn('actions', function ($user) {
                return view('admin.users.actions', compact('user'))->render();
            })
            ->setRowClass(function ($user) {
                return $user->id % 2 == 0 ? 'text-orange-700' : 'text-red-700';
            })
            ->setRowId(function ($user) {
                return 'user-' . $user->id;
            })
            ->setRowAttr([
                'color' => function($user) {
                    return $user->name;
                },
            ])
            ->setRowData([
                'data-id' => 'row-{{$id}}',
                'data-name' => 'row-{{$name}}',
            ])
            ->addColumn('role', function(User $user) {
                return $user->roles->first()?->name ?? 'No Role';
            })
            // ->editColumn('name', function(User $user) {
            //     return 'Hi ' . $user->name . '!';
            // })
            ->rawColumns(['actions'])
            ->make(true);
    }




    public function show(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.role', compact('user', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $user->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission exists.');
        }

        $user->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');
        }

        return back()->with('message', 'Permission not exixts.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('message', 'you are admin');
        }

        $user->delete();

        return back()->with('message', 'User Deleted');
    }



    // create user
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('message', 'User created successfully');
    }


    public function getRolePermissions()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        // dd($roles);
        $permissions = $user->getDirectPermissions();
        // dd($permissions);
        return view('admin.users.rolePermission', compact('user', 'roles', 'permissions' ));
    }
}
