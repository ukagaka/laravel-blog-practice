<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GubaController extends Controller
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
        $query = DB::table('guba')->where('status', '!=', 0)->orderBy('id', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('symbol')){
            $key = $request->input('symbol');
            $query = $query->where('symbol', $key);
            $columns = ['symbol' => $key];
        }
        if ($request->has('name')){
            $key = $request->input('name');
            $query = $query->where('name', $key);
            $columns = ['name' => $key];
        }
        if ($request->has('alias')){
            $key = $request->input('alias');
            $query = $query->where('alias', $key);
            $columns = ['alias' => $key];
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }
        $reconmGro = DB::table('recomgro')->where('status', '!=', 0)->pluck('title', 'id');
        return view('/guba.index', compact('data','reconmGro'));
    }

    public function create()
    {
        return view('/guba.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        DB::table('guba')->insert(
            $data
        );
        return redirect('/guba');
    }

    public function edit($id)
    {
        $data = DB::table('guba')->where('id', $id)->first();
        return view('/guba.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        unset($data['_token']);
        unset($data['id']);
        $group = DB::table('guba')->where('id', $id)->update($data);
        if($group){
            return redirect('/guba');
        }
        return redirect('/guba/edit/'.$id);
    }

    public function delete($id)
    {
        DB::table('guba')->where('id', $id)->update(['status' => 0]);
        return redirect('/guba');
    }

    public function recommend(Request $request)
    {
        $ids = $request->input('ids');
        $dataKey = explode('|', $ids);
        $group_id = $request->input('group_id');
        $time = date('Y-m-d H:i:s');
        $sum = 0;
        foreach ($dataKey as $v) {
            $guba = DB::table('guba')->where('id', $v)->first();
            $data[] = [
                'title' => $guba->name,
                'ftitle' => $guba->alias,
                'group_id' => $group_id,
                'time' => $time
            ];
            $sum++;
        }
        $recoCount = DB::table('recomcon')->where('group_id', $group_id)->count();
        $recomgro = DB::table('recomgro')->where('id', $group_id)->first();
        $recoSum = $sum + $recoCount - $recomgro->rec_sum;
        DB::table('recomcon')->insert(
            $data
        );
        if($recoSum > 0){
            DB::table('recomcon')->where('group_id', $group_id)->take($recoSum)->orderBy('time', 'asc')->delete();
        }
        return redirect('/recomcon?group_id='.$group_id);
    }

    public function modify(Request $request)
    {
        $id = $request->input('id');
        $aciton = $request->input('action');
        $value = $request->input('value');
        $post = DB::table('guba')->where('id', $id)->update([$aciton => $value]);
        if($post){
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }

}
