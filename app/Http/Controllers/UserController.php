<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;
use DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::paginate(20);
        return view('user.index', compact('data'));
    }

    public function create()
    {
        return view('/user.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'email'=>'required|unique:users',
            'name'=>'required',
            'password' => 'required|between:6,20|confirmed'
        ];
        $messages = [
            'required'=>':attribute不能为空',
            'unique'=>'登录邮箱已被注册',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $groupid = $request->input('groupid');
        $status = $request->input('status');
        $data = $request->all();
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'groupid' => $groupid,
            'status' => $status
        ];
        User::create($data); //插入一条新纪录，并返回保存后的模型实例
        return redirect('/user');
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return view('/user.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        unset($data['_token']);
        unset($data['id']);
        $group = User::where('id', $id)->update($data);
        if($group){
            return redirect('/user');
        }
        return redirect('/user/edit/'.$id);
    }

    public function reset()
    {
        return view('/user.reset');
    }

    public function postReset(Request $request)
    {
        $oldpassword = $request->input('oldpassword');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'oldpassword'=>'required|between:6,20',
            'password'=>'required|between:6,20|confirmed',
        ];
        $messages = [
            'required' => '密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);
        $user = Auth::user();
        $validator->after(function($validator) use ($oldpassword, $user) {
            if (!\Hash::check($oldpassword, $user->password)) {
                $validator->errors()->add('oldpassword', '原密码错误');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $user->password = bcrypt($password);
        $user->save();
        Auth::logout();
        return redirect('/login');
    }

    public function auth(Request $request)
    {
        $query = DB::connection('mysql_auth')->table('user')->where('user_group', 0)->orderBy('register_at', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('nick')){
            $key = $request->input('nick');
            $query = $query->where('nick', $key);
            $columns = ['nick' => $key];
        }
        if ($request->has('name')){
            $key = $request->input('name');
            $query = $query->where('name', $key);
            $columns = ['name' => $key];
        }
        if ($request->has('register_at')){
            $key = $request->input('register_at');
            $time = date('Y-m-d', strtotime($key));
            $query = $query->where('register_at', '>=', $time);
            $query = $query->where('register_at', '<=', $time.' 59:59:59');
            $columns = ['register_at' => $key];
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }

        return view('user.auth', compact('data'));
    }

    public function authdel($id)
    {
        DB::connection('mysql_auth')->table('user')->where('id', $id)->update(['user_group' => 2]);
        return redirect('/user/auth');
    }

    public function freeze($id)
    {
        $replay = DB::table('replay')->find($id);
        $user_id = $replay->type == 1 ? $replay->user_id : $replay->ga_id;
        DB::table('freeze')->insert([
            'user_id' => $user_id,
            'type' => $replay->type,
            'durating' => 60,
            'time' => date('Y-m-d H:i:s')
        ]);
        return redirect('/replay');
    }

}
