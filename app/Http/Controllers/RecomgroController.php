<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RecomgroController extends Controller
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
        $query = DB::table('recomgro')->orderBy('id', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('title')){
            $key = $request->input('title');
            $query = $query->where('title', $key);
            $columns = ['title' => $key];
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }
        return view('/recomgro.index', compact('data'));
    }

    public function create()
    {
        return view('/recomgro.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        DB::table('recomgro')->insert(
            $data
        );
        return redirect('/recomgro');
    }

    public function edit($id)
    {
        $data = DB::table('recomgro')->where('id', $id)->first();
        return view('/recomgro.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        unset($data['_token']);
        unset($data['id']);
        $group = DB::table('recomgro')->where('id', $id)->update($data);
        if($group){
            return redirect('/recomgro');
        }
        return redirect('/recomgro/edit/'.$id);
    }

    public function delete($id)
    {
        $data = DB::table('recomcon')->where('group_id', $id)->get();
        foreach ($data as $v) {
            DB::table('recomcon')->where('id', $v->id)->delete();
        }
        DB::table('recomgro')->where('id', $id)->delete();
        return redirect('/recomgro');
    }
}
