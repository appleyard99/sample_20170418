<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
class UsersController extends Controller
{
  //初始化
  public function __construct(){
    $this->middleware('auth',['only'=>['edit','update','destroy']]);
    $this->middleware('guest',['only'=>['create']
      ]);
  }
  //获取用户列表;
  public function index(){
    $users = User::paginate(30);
    return view('users.index',compact('users'));
  }
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
    //编辑用户资料
    public function edit($id)
    {
      $user = User::findOrFail($id);
      $this->authorize('update',$user);
      return view('users.edit',compact('user'));
    }
    //保存编辑
    public function update($id,Request $request){
      $this->validate($request,['name'=>'required|max:50',
                                'password'=>'confirmed|min:6']);
      $user = User::findOrFail($id);
      $this->authorize('update',$user);
      $data = [];
      $data['name'] = $request->name;
      if($request->password){
        $data['password']=  bcrypt($request->password);
                    }
      $user->update($data);
      session()->flash('success','个人资料更新成功!');
      return redirect()->route('users.show',$id);
    }
    //删除用户;
    public function destroy($id){
      $user = User::findOrFail($id);
      $this->authorize('destroy',$user);
      $user->delete();
      session()->flash('success','成功删除用户!');
      return back();
    }






}
