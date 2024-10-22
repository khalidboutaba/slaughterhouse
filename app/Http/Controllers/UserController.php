<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use DB;
use App\Http\Controllers\Controller;





class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list|user-show|user-create|user-edit|user-delete', ['only' => ['index']]);
         $this->middleware('permission:user-show', ['only' => ['show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Display a list of users
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        // Show the form for creating a new user
        return view('users.create',compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate and create a new user
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required'
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the selected roles to the user
        $user->assignRole($request->input('roles'));

        // Redirect to users index with success message
        return redirect()->route('users.index')->with('success', 'تم إنشاء المستخدم بنجاح!');
    }

    public function show(User $user)
    {
        $logs = UserLog::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        // Display a specific user
        return view('users.show', compact('user', 'logs'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        // Show the form for editing a specific user
        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, User $user)
    {
        // Validate and update the user
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح!');
    }

    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح!');
    }

}
