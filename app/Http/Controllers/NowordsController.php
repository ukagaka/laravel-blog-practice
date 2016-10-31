<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NowordsController extends Controller
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
        $query = DB::table('nowords')->where('status', '!=', 0)->orderBy('id', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('word')){
            $key = $request->input('word');
            $query = $query->where('word', 'like', '%'.$key.'%');
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }
        return view('/nowords.index', compact('data'));
    }

    public function create()
    {
        return view('/nowords.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $words = explode("\n", $data['words']);
        print_r($words);
        foreach ($words as $v) {
            if(!empty(trim($v))){
                $nowords[]['word'] = $v;
            }
        }
        DB::table('nowords')->insert(
            $nowords
        );
        return redirect('/nowords');
    }

    public function delete($id)
    {
        $dataKey = explode('|', $id);
        foreach ($dataKey as $v) {
            DB::table('nowords')->where('id', $v)->delete();
        }
        return redirect('/nowords');
    }

}
