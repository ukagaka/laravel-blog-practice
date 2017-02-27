<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
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
        $query = DB::table('event')->where('action', 7)->orderBy('time', 'desc');
        $data = $query->paginate(20);
        return view('event.index', compact('data'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function edit($id)
    {
        $data = DB::table('event')->where('id', $id)->first();
        return view('event.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        unset($data['_token']);
        unset($data['id']);
        $group = DB::table('event')->where('id', $id)->update($data);
        if($group){
            return redirect('/event');
        }
        return redirect('/event/edit/'.$id);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $data = [
            'action' => 7,
            'target_type' => 'gonggao',
            'content' => $input['content'],
            'type' => 'remind',
            'receiver' => $input['receiver'],
            'is_read' => 1
        ];
        DB::table('event')->insert(
            $data
        );
        return redirect('/event');
    }

    public function delete($id)
    {
        DB::table('event')->where('id', $id)->delete();
        return redirect('/event');
    }

    public function modify(Request $request)
    {
        $id = $request->input('id');
        $aciton = $request->input('action');
        $value = $request->input('value');
        $post = DB::table('event')->where('id', $id)->update([$aciton => $value]);
        if($post){
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }
}