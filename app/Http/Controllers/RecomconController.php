<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RecomconController extends Controller
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
        $group_id = $request->input('group_id');
        $query = DB::table('recomcon')->orderBy('time', 'DESC');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('group_id')){
            $key = $request->input('group_id');
            $query = $query->where('group_id', $key);
            $columns = ['group_id' => $key];
        }
        $data = $query->paginate(20);
        if(!empty($columns)){
            $columns = ['group_id' => $group_id];
            $data->appends($columns)->links();
        }
        return view('/recomcon.index', compact('data', 'group_id'));
    }

    public function create(Request $request)
    {
        $group_id = $request->input('group_id');
        return view('/recomcon.create', compact('group_id'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['time'] = date('Y-m-d H:i:s');
        DB::table('recomcon')->insert(
            $data
        );
        return redirect('/recomcon?group_id='.$data['group_id']);
    }

    public function edit($id)
    {
        $data = DB::table('recomcon')->where('id', $id)->first();
        return view('/recomcon.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        unset($data['_token']);
        unset($data['id']);
        $group = DB::table('recomcon')->where('id', $id)->update($data);
        if($group){
            return redirect('/recomcon?group_id='.$data['group_id']);
        }
        return redirect('/recomcon/edit/'.$id);
    }

    public function delete($id)
    {
        $data = DB::table('recomcon')->where('id', $id)->first();
        DB::table('recomcon')->where('id', $id)->delete();
        return redirect('/recomcon?group_id='.$data->group_id);
    }

    public function upord(Request $request)
    {
        $data = json_decode($request->input('data'));
        $group_id = $request->input('group_id');
        foreach ($data as $k => $v) {
            DB::table('recomcon')->where('id', $k)->update(['orby' => $v]);
        }
        return redirect('/recomcon?group_id='.$group_id);
    }

}
