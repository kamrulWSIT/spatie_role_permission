<?php

// namespace App\Http\Controllers;

// use App\DataTables\UserDataTableEditor;
// use App\DataTables\UsersDataTable;
// use Illuminate\Http\Request;

// class UsersController extends Controller
// {
//     public function index(UsersDataTable $dataTable)
//     {
//         return $dataTable->render('yajra.index');
//     }

//     public function store(UserDataTableEditor $editor)
//     {
//         return $editor->process(request());
//     }
// }


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Display the view
    public function index()
    {
        return view('yajra.index');
    }

    // Fetch data for DataTables
    public function getData()
    {
        $users = User::query();
        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="/users/' . $user->id . '/edit" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->rawColumns(['action']) // Allow raw HTML for the 'action' column
            ->make(true);
    }
}

