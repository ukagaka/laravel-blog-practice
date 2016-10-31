<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TagController extends Controller
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
        $query = DB::table('tag')->where('status', '!=', 0)->orderBy('id', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('tag')){
            $key = $request->input('tag');
            $query = $query->where('tag', $key);
            $columns = ['tag' => $key];
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
        return view('/tag.index', compact('data'));
    }

    public function index2(Request $request)
    {
        $query = DB::table('tag')->where('status', 0)->orderBy('id', 'desc');

        if ($request->has('id')){
            $query = $query->where('id', $request->input('id'));
        }
        if ($request->has('post_id')){
            $query = $query->where('tag', $request->input('post_id'));
        }
        if ($request->has('user_id')){
            $query = $query->where('user_id', $request->input('user_id'));
        }
        $data = $query->paginate(10);
        return view('/tag.index2', compact('data'));
    }

    public function cancel($id, Request $request)
    {
        $status = $request->input('status');
        $dataKey = explode('|', $id);
        foreach ($dataKey as $v) {
            DB::table('tag')->where('id', $v)->update(['status' => $status]);
        }
        return redirect('/tagno');
    }

    public function delete($id)
    {
        $dataKey = explode('|', $id);
        foreach ($dataKey as $v) {
            DB::table('tag')->where('id', $v)->delete();
        }
        return redirect('/tagno');
    }

}
