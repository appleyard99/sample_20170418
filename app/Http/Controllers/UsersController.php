<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Mail;
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
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发到你邮箱上,请查收~');
        return redirect()->route('/');

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
    //发送邮件 调用mail的send接口;
    public  function sendEmailConfirmationTo($user){
      $view = 'emails.confirm';
      $data = compact('user');
      $from = 'apple_mgg@sina.com';
      $name ='Apple';
      $to = $user->email;
      $subject = '感谢注册 Sample 应用！请确认你的邮箱。';
      Mail::send($view,$data,function($message) use($from,$name,$to,$subject){
        $message->from($from,$name)->to($to)->subject($subject);
      });
    }

    //邮件确认;
    public function confirmEmail($token){
      $user = User::where('activation_token',$token)->firstOrFail();
      $user->activated = true;
      $user->activation_token = null;
      $user->save();

      Auth::login($user);
      session()->flash('success','恭喜你,激活成功');
      return redirect()->route('users.show',[$user]);

    }







}
