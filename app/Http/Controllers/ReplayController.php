<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReplayController extends Controller
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
    public function index(Request $request)
    {
        $query = DB::table('replay')->where('status', '!=', 0)->orderBy('time', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('post_id')){
            $key = $request->input('post_id');
            $query = $query->where('post_id', $key);
            $columns = ['post_id' => $key];
        }
        if ($request->has('user_name')){
            $key = $request->input('user_name');
            $query = $query->where('user_name', $key);
            $columns = ['user_name' => $key];
        }
        if ($request->has('user_id')){
            $key = $request->input('user_id');
            $query = $query->where('user_id', $key);
            $columns = ['user_id' => $key];
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }
        return view('replay.index', compact('data'));
    }

    public function delete($id)
    {
        $dataKey = explode('|', $id);
        foreach ($dataKey as $v) {
            $data = DB::table('replay')->where('id', $v)->first();
            if($data->storey == 1){
                DB::table('post')->where('id', $data->post_id)->update(['status' => 0]);
            }
            DB::table('replay')->where('id', $v)->delete();
        }
        return redirect('/replay');
    }

    public function edit($id)
    {
        $data = DB::table('replay')->where('id', $id)->first();
        return view('/replay.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        unset($data['_token']);
        unset($data['id']);
        $group = DB::table('replay')->where('id', $id)->update($data);
        if($group){
            return redirect('/replay?post_id='.$data['post_id']);
        }
        return redirect('/replay/edit/'.$id);
    }

    public function report()
    {
        $data = DB::table('replay')->where('jubao', '!=', 0)->where('status', '!=', 0)->orderBy('jubao', 'desc')->paginate(20);
        return view('replay.report', compact('data'));
    }

    public function cancel($id)
    {
        DB::table('replay')->where('id', $id)->update(['jubao' => 0]);
        return redirect('/report');
    }

    public function modify(Request $request)
    {
        $id = $request->input('id');
        $operation = $request->input('type');
        $user_name = $request->input('value');
        $post = DB::table('replay')->where('id', $id)->update([$operation => $user_name]);
        if($post){
            $data = DB::table('replay')->where('id', $id)->first();
            if($data->storey == 1 && $operation == 'user_name'){
                DB::table('post')->where('id', $data->post_id)->update([$operation => $user_name]);
            }
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }
}
