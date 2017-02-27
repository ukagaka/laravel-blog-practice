<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class PetController extends Controller
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
        $userId = Auth::user()->id;
        $query = DB::table('user_pet')
            ->leftJoin('pet', 'user_pet.user_id', '=', 'pet.id')
            ->where('user_pet.status', 1)
            ->where('user_pet.user_id', $userId)
            ->orderBy('user_pet.created_at', 'desc');
        $data = $query->paginate(10);
        return view('pet.index', compact('data'));
    }

    public function info($id)
    {
        $userId = Auth::user()->id;
        $data = DB::table('user_pet')->where('id', $id)->where('status', 1)->first();
        $config = \App\Pet::get_wcc_config($userId);
        return view('pet.info', compact('data', 'config'));
    }

    public function edit($id)
    {
        $data = DB::table('pet')->where('id', $id)->first();
        return view('/pet.edit', compact('data'));
    }

    public function all(Request $request)
    {
        $query = DB::table('pet')->orderBy('created_at', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('name')){
            $key = $request->input('name');
            $query = $query->where('name', $key);
            $columns = ['name' => $key];
        }
        if ($request->has('user_id')){
            $key = $request->input('user_id');
            $query = $query->where('user_id', $key);
            $columns = ['user_id' => $key];
        }
        if ($request->has('nick')){
            $key = $request->input('nick');
            $query = $query->where('nick', $key);
            $columns = ['nick' => $key];
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }
        return view('pet.all', compact('data'));
    }

    public function create()
    {
        return view('pet.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DB::table('pet')->insert([
                'name' => $data['name'],
                'nick' => $data['nick'],
                'user_id' => Auth::id(),
                'demand' => json_encode($data['demand']),
                'status' => 0
            ]);
        return redirect('/pet');
    }

    public function modify(Request $request)
    {
        $id = $request->input('id');
        $aciton = $request->input('action');
        $value = $request->input('value');
        $post = DB::table('pet')->where('id', $id)->update([$aciton => $value]);
        if($post){
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }

}
