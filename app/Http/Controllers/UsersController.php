<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
class UsersController extends Controller
{
  //用户注册;
    public function create()
    {
      return view('users.create');
    }
    //用户详情;
    public function show($id){
      $user=User::findOrFail($id);
      return view('users.show',compact('user'));
    }
    //用户注册表单保存
    public function store(Request $request){
        $this->validate($request,['name'=>'required|min:3|max:50',
                                  'email'=>'required|email|unique:users|max:255',
                                  'password'=>'required|confirmed']);
        $user = User::create([
          'name'=>$request->name,
          'email'=>$request->email,
          'password'=>bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','欢迎,您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);

    }







}
