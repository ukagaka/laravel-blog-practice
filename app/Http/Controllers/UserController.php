<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

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

    public function info()
    {
        $userId = Auth::user()->id;
        $data = User::where('id', $userId)->first();
        return view('/user.info', compact('data'));
    }

    public function getUser($id)
    {
        $user = User::where('id', $id)->first();
        if($user){
            return json_encode(['code'=>'success', 'data'=>['nick' => $user->name, 'uid' => $user->id]]);
        }
        return json_encode(['code'=>'fail']);
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

}
