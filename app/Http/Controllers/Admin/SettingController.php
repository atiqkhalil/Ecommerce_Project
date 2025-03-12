<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function adminchangepassword(){
        return view('admin.changepassword');
    }

    public function adminupdatepassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if(Hash::check($request->old_password,Auth::user()->password) == false){
            return redirect()->route('account.adminchangepassword',Auth::id())->with('error','Old Password is Incorrect!');
        }

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('admin.dashboard',Auth::id())->with('success','New Password is Changed Successfully!');
    }
}
