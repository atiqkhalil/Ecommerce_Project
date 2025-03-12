<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function authenticate(Request $request){
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credential)) {
            if (Auth::user()->role == 0) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout(); // Log out the unauthorized user
                return redirect()->route('admin.login')->with('error', 'You are not authorized to access the admin panel.');
            }
        }      
    }

    public function index(Request $request){
        $users = User::where('role',1)->latest();

        if (!empty($request->keyword)) {
            $users = $users->where('name', 'like', '%' . $request->keyword . '%');
        }        

        $users =  $users->paginate(10);
        return view('admin.users.list',compact('users'));
    }


    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','Users Deleted Successfully');
    }
}
