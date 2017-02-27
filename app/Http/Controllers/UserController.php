<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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

}
